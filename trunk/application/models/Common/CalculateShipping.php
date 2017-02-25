<?php
class Common_CalculateShipping
{
    protected $_paramsArray = array(); //参数
    protected $_dataArray = array(); //自定义
    protected $_errorArray = array(); //错误信息

    public function construct($params = array())
    {
        $this->setParams($params);
    }

    /**
     * @设置参数
     */
    public function setParams($params = array())
    {
        $keys = array(
            'customerCode' => '',
            'warehouseId' =>'',
            'countryId' => 0,
            'smId' => 0,
            'smCode' => '',
            'weight' => 0,
            'length' => 0,
            'width' => 0,
            'height' => 0,
            'provinceId' => 0,
            'cityId' => 0,
            'zip' => null,
            //  'warehouseName' => '',
            //  'countryCode' => '',
//            'smClassCode' => null, //运输方式分类的code
            'smFeeType' => null, //费用类型：单票,总单
            'smCalcType' => null, //计费类型：区间,首续重
               'postcode'=>'',
        );
        if (is_array($params)) {
            foreach ($keys as $key => $val) {
                if (isset($params[$key])) {
                    $keys[$key] = $params[$key];
                }
            }
        }
        unset($params);
        $this->_paramsArray = $keys;
    }

    /**
     * @获取物流费用
     * @return array
     */
    public function getRate()
    {
        $result = array('state' => 0, 'error' => array(), 'data' => array());
        $this->setShippingMethod();
        //选择自有渠道的订单，不需要进行物流费用的冻结、扣款 order表change_order是0 shipping_method的sm_channel是1
        if($this->_dataArray['smArr']['sm_channel']=='1'){
            //不需要物流费的直接返回物流费为0
            $directoryArray =  array(
                'weight' => '0',
                'cost' => '0',
                'price' => '0',
                'totalCost'=>'0',
                'currency_code' => 'RMB',
                'sm_channel'=>'1' //自有渠道
            );
            $result = array('state' => 1, 'data' => array('sm' => $this->_dataArray['smArr'], 'cost' => $directoryArray));
            return $result;
        }
        $this->setCountry();
        $this->setRealWeight();
        $this->validator();
        if (!empty($this->_errorArray)) {
            $result['error'] = $this->getError();
            return $result;
        }
        $this->setArea();
        $this->getCostRate();
        if (!empty($this->_errorArray)) {
            $result['error'] = $this->getError();
            return $result;
        }
        $this->setDiscount();
        $this->setCustomerDiscount();
        $this->costAccounting();
        $result = array('state' => 1, 'data' => array('sm' => $this->_dataArray['smArr'], 'cost' => $this->_dataArray['costArr']));
        return $result;
    }

    /**
     *@首续重计费模式+区间重量计费 所有可用货运方式
     *@根据 仓库ID,国家ID,省份ID,城市ID 计费类型(默认全部) 获取可用的货运方式;
     * @return array('state'=>0,'message'=>string,'data'=array())
     */
    public function getArrivedSM()
    {
        $return = array('state' => 0, 'message' => 'No data', 'data' => array());
        $condition = array(
            'warehouse_id_arr' => array(0, $this->_paramsArray['warehouseId']),
            'country_id_arr' => array(0, $this->_paramsArray['countryId']),
            'province_id_arr' => array(0, $this->_paramsArray['provinceId']),
            'city_id_arr' => array(0, $this->_paramsArray['cityId']),
        );
        $smCondition = array(
            'sm_status' => 1,
            'warehouse_id_arr' => array(0, $this->_paramsArray['warehouseId']),
            'sm_calc_type' => $this->_paramsArray['smCalcType'],
            'sm_fee_type' => $this->_paramsArray['smFeeType'],
        );
        $shippingMethodRows = Service_ShippingMethod::getByCondition($smCondition, '*');
        if (empty($shippingMethodRows)) {
            return $return;
        }
        $smCodeArr = array();
        foreach ($shippingMethodRows as $sm) {
            $condition['smcm_type'] = $sm['sm_calc_type'];
            $condition['smcm_calc_type'] = $sm['sm_fee_type'];
            $mapRows = Service_SmCountryMap::getByInCondition($condition, 'area', 0, 0, array('warehouse_id desc', 'country_id desc', 'province_id desc', 'city_id desc'));
            if (!empty($mapRows)) {
                $smCodeArr[] = array(
                    'sm_id' => $sm['sm_id'],
                    'sm_code' => $sm['sm_code'],
                    'sm_calc_type' => $sm['sm_calc_type'],
                    'sm_fee_type' => $sm['sm_fee_type'],
                    'sm_limit_weight' => $sm['sm_limit_weight'],
                );
            }
        }
        if (!empty($smCodeArr)) {
            $return = array('state' => 1, 'message' => 'Success', 'data' => $smCodeArr);
        }
        return $return;
    }

    /**
     * @desc 获取所有可到达的运输方式及运费
     * @params 根据仓库ID,国家ID,计费类型,重量,长,宽,高,客户Code
     * @return array('state'=>0,'message'=>string,'data'=array())
     */
    public function getAllShippingMethodCost()
    {
        $return = array('state' => 0, 'message' => 'No data', 'data' => array());
        $smCondition = array(
            'warehouse_id_arr' => array(0, $this->_paramsArray['warehouseId']),
            'sm_status' => 1,
            'sm_calc_type' => $this->_paramsArray['smCalcType'],
            'sm_fee_type' => $this->_paramsArray['smFeeType'],
        );
        $shippingMethodRows = Service_ShippingMethod::getByCondition($smCondition, '*');
        if (empty($shippingMethodRows)) {
            return $return;
        }
        $costArr = array();
        foreach ($shippingMethodRows as $sm) {
            $this->_paramsArray['smCode'] = $sm['sm_code'];
            $result = $this->getRate();
            $this->_errorArray = array();
            if (isset($result['state']) && $result['state'] == '1') {
                $costArr[] = $result['data'];
            }
        }
        if (!empty($costArr)) {
            $return = array('state' => 1, 'message' => 'Success', 'data' => $costArr);
        }
        return $return;
    }

    private function getError()
    {
        $error = array(
            '1' =>  Ec_Lang::getInstance()->getTranslate('Country_does_not_exist') ,
            '2' =>  Ec_Lang::getInstance()->getTranslate('ShippingMethodDoNotExist'),
            '3' =>  Ec_Lang::getInstance()->getTranslate('Incorrect_Weight'),
            '4' =>  Ec_Lang::getInstance()->getTranslate('shipping_is_not_available'),
            '5' =>  Ec_Lang::getInstance()->getTranslate('No_Ship_Price'),
            '6' =>  Ec_Lang::getInstance()->getTranslate('choose_shippingmethod_first'),
            '7' =>  Ec_Lang::getInstance()->getTranslate('Over_Weight_Maximum_weight').$this->_dataArray['smArr']['sm_limit_weight'],
            '8' =>  Ec_Lang::getInstance()->getTranslate('shippingmethod_not_available_for_this_warehouse'),
            '9' =>  Ec_Lang::getInstance()->getTranslate('Warehousemethod_not_exist'),
			'10'=>  Ec_Lang::getInstance()->getTranslate('Low_Min_Weight').$this->_dataArray['smArr']['sm_limit_weight']
        );
        $errorArr = array();
        foreach ($this->_errorArray as $code) {
            if (isset($error[$code])) {
                $errorArr[] = $error[$code];
            }
        }
        return $errorArr;
    }

    private function setShippingMethod()
    {
        if ($this->_paramsArray['smCode'] != '') {
            $condition = array(
                'warehouse_id_arr'=>array(0,$this->_paramsArray['warehouseId']),
                'sm_code'=>$this->_paramsArray['smCode']
            );
            //$smRow = Service_ShippingMethod::getByField($this->_paramsArray['smCode'], 'sm_code');
            $smRow = Service_ShippingMethod::getByCondition($condition,"*");
            if ($smRow[0]['sm_status'] == '1') {
                $this->_dataArray['smArr'] = $smRow[0];
            }
            return true;
        }
        if ($this->_paramsArray['smId'] != '' && $this->_paramsArray['smId'] != '0') {
            $smRow = Service_ShippingMethod::getByField($this->_paramsArray['smId'], 'sm_id');
            if ($smRow['sm_status'] == '1') {
                $this->_dataArray['smArr'] = $smRow;
            }
            return true;
        }
    }

    private function setCountry()
    {
        $this->_dataArray['countryArr'] = Service_Country::getByField($this->_paramsArray['countryId'], 'country_id');
    }

    private function validator()
    {
        if(empty($this->_paramsArray['warehouseId'])){
            $this->_errorArray[] = '9'; //仓库不能为空
        }
        if (empty($this->_dataArray['smArr']) || !isset($this->_dataArray['smArr'])) {
            $this->_errorArray[] = '1'; //货运方式不存在.
        } elseif (!in_array($this->_dataArray['smArr']['warehouse_id'], array(0, $this->_paramsArray['warehouseId']))) {
            $this->_errorArray[] = '8'; //货运方式不支持仓库
        }
        if (empty($this->_dataArray['countryArr']) || !isset($this->_dataArray['countryArr'])) {
            $this->_errorArray[] = '2'; //国家不存在.
        }
        if (empty($this->_paramsArray['weight'])) {
            $this->_errorArray[] = '3'; //重量不能为空
        } elseif (isset($this->_dataArray['realWeight']) && $this->_dataArray['realWeight'] > $this->_dataArray['smArr']['sm_limit_weight']) {
            $this->_errorArray[] = '7'; //超重
        }
    }

    /**
     * @desc 计费重量
     * @return bool
     */
    private function setRealWeight()
    {
        if (!isset($this->_dataArray['smArr'])) {
            return false;
        }
        $this->_dataArray['realWeight'] = $this->_paramsArray['weight'];
        if ($this->_dataArray['smArr']['sm_is_volume'] == '1' && $this->_dataArray['smArr']['sm_vol_rate'] > 0 && $this->_dataArray['smArr']['sm_calc_type'] == '0' && $this->_dataArray['smArr']['sm_fee_type'] == '0') {
            $vol = $this->_paramsArray['length'] * $this->_paramsArray['width'] * $this->_paramsArray['height'];
            $volWeight = sprintf("%.2f", $vol / $this->_dataArray['smArr']['sm_vol_rate']);
            if ($volWeight > $this->_paramsArray['weight'] && $vol > $this->_dataArray['smArr']['sm_limit_volume']) {
                $this->_dataArray['realWeight'] = $volWeight;
            }
        }
    }

    /**
     * @desc 设置分区代码
     * @ set $this->_dataArray['areaArr']
     */
    private function setArea()
    {
        $this->_dataArray['areaArr'] = array();
        $condition = array(
            'warehouse_id_arr' => array(0, $this->_paramsArray['warehouseId']),
            'country_id_arr' => array(0, $this->_paramsArray['countryId']),
            'province_id_arr' => array(0, $this->_paramsArray['provinceId']),
            'city_id_arr' => array(0, $this->_paramsArray['cityId']),
            'sm_id' => $this->_dataArray['smArr']['sm_id'],
            'regex_post_code'=>$this->_paramsArray['postcode'],
            
        );
        //$condition['smcm_calc_type'] = $this->_dataArray['smArr']['sm_calc_type'];
        //$condition['smcm_fee_type'] = $this->_dataArray['smArr']['sm_fee_type'];
        $mapRows = Service_SmCountryMap::getByInCondition($condition, 'area', 0, 0, array('warehouse_id desc', 'country_id desc', 'province_id desc', 'city_id desc'));
        //var_dump($condition);
         if (empty($mapRows)) {
            $condition['regex_post_code']='';
             $mapRows = Service_SmCountryMap::getByInCondition($condition, 'area', 0, 0, array('warehouse_id desc', 'country_id desc', 'province_id desc', 'city_id desc'));
             if(empty($mapRows)){
                return false;
             }
        }
        if (empty($mapRows)) {
            return false;
        }
        foreach ($mapRows as $val) {
            $areaArr[] = $val['area'];
        }
        $this->_dataArray['areaArr'] = $areaArr;
        return true;
    }

    /**
     * @desc 获取相对应该的基本费用
     */
    private function getCostRate()
    {
        $areaArr = isset($this->_dataArray['areaArr']) ? $this->_dataArray['areaArr'] : array();
        if (empty($areaArr)) {
            $this->_errorArray[] = '4'; //货运方式国家不存在对应的区域
            return false;
        }
        //区间价格
        if ($this->_dataArray['smArr']['sm_calc_type'] == '0') {
            $priceRow = $this->interval($areaArr);
        } else {
            //首续重
            $priceRow = $this->firstWeight($areaArr);
        }
        if (!is_array($priceRow)) {
            return false;
        }
        $this->_dataArray['costArr'] = $priceRow;
    }

    /**
     * @desc 区间
     * @param array $areaArr
     * @return array|bool
     */
    private function interval($areaArr = array())
    {
        $condition = array(
            'sm_id' => $this->_dataArray['smArr']['sm_id'],
            'area_arr' => $areaArr,
            'warehouse_id_arr' => array(0, $this->_paramsArray['warehouseId']),
            'sp_fee_type' => $this->_dataArray['smArr']['sm_fee_type'],
            'sp_weight_gt' => $this->_dataArray['realWeight']
        );
        $spObj = new Table_ShipPrice();
        $smPriceRow = $spObj->getByInCondition($condition, '*', array('warehouse_id desc','sp_weight', 'sp_price'));
        if (empty($smPriceRow)) {
            $this->_errorArray[] = '5'; //没有找到费用
            return false;
        }
        //$smRow = Service_ShippingMethod::getByField($smPriceRow['sm_code'],"sm_code","*");
        $one_ticket_fee = 0;
        $one_ticket_cbcost = 0;
        if($this->_dataArray['smArr']['sm_class_code']=="CRP"||$this->_dataArray['smArr']['sm_class_code']=="CPS"){
            $one_ticket_fee = $smPriceRow['sp_ticket_cost'];
        }
        if($this->_dataArray['smArr']['sm_class_code']=="CRP"||$this->_dataArray['smArr']['sm_class_code']=="CPS"){
            $one_ticket_cbcost = $smPriceRow['one_ticket_cbcost'];
        }

        // 判断是否存在成本币种，否则成本币种与费用币种一致（程序兼容性）
        if ('' === trim($smPriceRow['cost_currency_code'])) {
          $smPriceRow['cost_currency_code'] = $smPriceRow['currency_code'];
        }

        $priceRow = array(
            'weight' => $smPriceRow['sp_weight'],
            'cost' => $smPriceRow['sp_cost'],
            'price' => $smPriceRow['sp_price'],
            'cost_currency_code' => $smPriceRow['cost_currency_code'], // 成本币种
            'currency_code' => $smPriceRow['currency_code'],
            'type' => $smPriceRow['sp_fee_type'],
            'sm_id' => $smPriceRow['sm_id'],
            'one_ticket_fee'=>$one_ticket_fee,
            'one_ticket_cbcost'=>$one_ticket_cbcost,
            'map_cost' => Service_Currency::converByCode($smPriceRow['cost_currency_code'], $smPriceRow['currency_code'], $smPriceRow['sp_cost']), // 成本费用转变为与费用一致的币种
            'map_one_ticket_cost' => Service_Currency::converByCode($smPriceRow['cost_currency_code'], $smPriceRow['currency_code'], $one_ticket_cbcost), // 成本单票费用转变为与费用一致的币种
        );
        return $priceRow;
    }


    /**
     * @desc 首续重
     * @param array $areaArr
     * @return array|bool
     */
    private function firstWeight($areaArr = array())
    {
        $condition = array(
            'sm_id' => $this->_dataArray['smArr']['sm_id'],
            'area_arr' => $areaArr,
            'warehouse_id_arr' => array(0, $this->_paramsArray['warehouseId']),
            'swp_fee_type' => $this->_dataArray['smArr']['sm_fee_type']
        );
        $spObj = new Table_ShipWeightPrice();
        $smPriceRow = $spObj->getByInCondition($condition, '*', array('warehouse_id desc'));
        if (empty($smPriceRow)) {
            $this->_errorArray[] = '5'; //没有找到费用
            return false;
        }

        //费用计算
        if ($smPriceRow["swp_weight"] - $this->_dataArray['realWeight'] > 0) {
            $cost = $smPriceRow["swp_cost"];
            $price = $smPriceRow["swp_price"];
        } else {
            $cost = ($this->_dataArray['realWeight'] - $smPriceRow["swp_weight"]) / $smPriceRow["swp_exces_weight"];
            $cost = ceil($cost) * $smPriceRow["swp_exces_cost"] + $smPriceRow["swp_cost"];
            $price = ($this->_dataArray['realWeight'] - $smPriceRow["swp_weight"]) / $smPriceRow["swp_exces_weight"];
            $price = ceil($price) * $smPriceRow["swp_exces_price"] + $smPriceRow["swp_price"];
        }

        // 单票成本
        $one_ticket_cbcost = 0;
        if($this->_dataArray['smArr']['sm_class_code']=="CRP"||$this->_dataArray['smArr']['sm_class_code']=="CPS"){
            $one_ticket_cbcost = $smPriceRow['one_ticket_cbcost'];
        }

        // 判断是否存在成本币种，否则成本币种与费用币种一致（程序兼容性）
        if ('' === trim($smPriceRow['cost_currency_code'])) {
          $smPriceRow['cost_currency_code'] = $smPriceRow['currency_code'];
        }

        $priceRow = array(
            'weight' => $smPriceRow['swp_weight'],
            'addedWeight' => $smPriceRow['swp_exces_weight'],
            'cost' => $cost,
            'price' => $price,
            'cost_currency_code' => $smPriceRow['cost_currency_code'], // 成本币种
            'currency_code' => $smPriceRow['currency_code'],
            'type' => $smPriceRow['swp_fee_type'],
            'sm_id' => $smPriceRow['sm_id'],
            'one_ticket_fee'=>$smPriceRow['one_ticket_fee'],
            'one_ticket_cbcost'=>$one_ticket_cbcost,
            'map_cost' => Service_Currency::converByCode($smPriceRow['cost_currency_code'], $smPriceRow['currency_code'], $cost), // 成本费用转变为与费用一致的币种
            'map_one_ticket_cost' => Service_Currency::converByCode($smPriceRow['cost_currency_code'], $smPriceRow['currency_code'], $one_ticket_cbcost), // 成本单票费用转变为与费用一致的币种
        );
        return $priceRow;
    }

    /**
     * @desc 计算运输方式折扣及其它费用
     */
    private function setDiscount()
    {
        $this->_dataArray['costArr']['addCost'] = sprintf('%.2f', $this->_dataArray['smArr']['sm_addons']);
        $this->_dataArray['costArr']['pCost'] = sprintf('%.2f', $this->_dataArray['smArr']['sm_mp_fee']);
        $this->_dataArray['costArr']['regCost'] = sprintf('%.2f', $this->_dataArray['smArr']['sm_reg_fee']);

        /* 计算燃油附加费 */
        $shippingMethod = Service_ShippingMethod::getByField($this->_dataArray['smArr']['sm_id'],"sm_id","*");
        if('CRE' == $shippingMethod['sm_class_code']){
          $baf = ($this->_dataArray['costArr']['price'] + $this->_dataArray['costArr']['addCost'] + $this->_dataArray['costArr']['pCost'] + $this->_dataArray['costArr']['regCost']) * $shippingMethod['sm_baf'];
          $baseBaf = $baf;
          $cost_baf = $this->_dataArray['costArr']['cost'] * $shippingMethod['sm_baf'];
          $map_cost_baf = Service_Currency::converByCode($this->_dataArray['costArr']['cost_currency_code'], $this->_dataArray['costArr']['currency_code'], $cost_baf);
        }
        else {
          $baf = '0.00';
          $cost_baf = '0.00';
          $map_cost_baf = '0.00';
          $baseBaf = '0.00';
        }

        $discount = $this->_dataArray['smArr']['sm_discount'];
        $discount = 1; //暂时不开放
        $baseCost = $this->_dataArray['costArr']['price'] * $discount;
        $oneTicketFee = isset($this->_dataArray['costArr']['one_ticket_fee'])?$this->_dataArray['costArr']['one_ticket_fee']:'0';
        $baseTicketFee = $oneTicketFee * $discount; // 单票费用也要打折

        //控制成本
        $cost_total = $this->_dataArray['costArr']['map_cost'] + $this->_dataArray['costArr']['map_one_ticket_cost'] + $cost_baf; // 成本费用
        $real_total = $baseCost + $baseTicketFee + $baf; // 实际费用
        if ($real_total < $cost_total) {
          $baseCost = $this->_dataArray['costArr']['map_cost'];
          $baseTicketFee = $this->_dataArray['costArr']['map_one_ticket_cost'];
          $baseBaf = $cost_baf;
        }

        $this->_dataArray['costArr']['baseCost'] = sprintf('%.2f', $baseCost);
        $this->_dataArray['costArr']['baseTicketFee'] = sprintf('%.2f', $baseTicketFee);
        $this->_dataArray['costArr']['baseBaf'] = sprintf('%.2f', $baseBaf); // 实际需要扣费的燃油费
        $this->_dataArray['costArr']['baf'] = sprintf('%.2f', $baf); // 燃油费
        $this->_dataArray['costArr']['cost_baf'] = sprintf('%.2f', $cost_baf); // 成本燃油费
        $this->_dataArray['costArr']['map_cost_baf'] = sprintf('%.2f', $map_cost_baf); // 成本燃油费转变为与费用一致的币种
        $this->_dataArray['costArr']['totalCost'] = sprintf('%.2f', $baseCost + $baseTicketFee + $baseBaf + $this->_dataArray['costArr']['addCost'] + $this->_dataArray['costArr']['pCost'] + $this->_dataArray['costArr']['regCost']);
    }

    /**
     * @desc 根据客户及运输方式获取折扣率
     * set $this->_dataArray['smArr']['customer_discount']
     */
    private function setCustomerDiscount()
    {
        $discount = 1; //默认无折扣
        $condition = array(
            'customer_code_arr' => array('*', $this->_paramsArray['customerCode']),
            'sm_code_arr' => array('*', $this->_dataArray['smArr']['sm_code']),
            'warehouse_id_arr' => array(0, $this->_paramsArray['warehouseId'])
        );
        $obj = new Table_SmCustomerMap();
        $customerMap = $obj->getByCondition($condition, '*', 5, 1, array('sm_code desc', 'customer_code desc', 'warehouse_id desc'));
        if (empty($customerMap)) {
            $this->_dataArray['smArr']['customer_discount'] = $discount;
            return false;
        }
        $smArr = array();
        foreach ($customerMap as $val) {
            if ($val['customer_code'] == $this->_paramsArray['customerCode'] && $val['warehouse_id'] == $this->_paramsArray['warehouseId'] && $this->_dataArray['smArr']['sm_code'] == $val['sm_code']) {
                $this->_dataArray['smArr']['customer_discount'] = $val['smc_discount'] > 0 ? $val['smc_discount'] : $discount;
                return true;
            }
            $smArr[$val['sm_code'] . '_' . $val['customer_code'] . '_' . $val['warehouse_id']] = $val['smc_discount'] > 0 ? $val['smc_discount'] : $discount;
        }
        if (isset($smArr[$this->_dataArray['smArr']['sm_code'] . '_' . $this->_paramsArray['customerCode'] . '_0'])) {
            $this->_dataArray['smArr']['customer_discount'] = $smArr[$this->_dataArray['smArr']['sm_code'] . '_' . $this->_paramsArray['customerCode'] . '_0'];
            return true;
        }
        if (isset($smArr[$this->_dataArray['smArr']['sm_code'] . '_*_' . $this->_paramsArray['warehouseId']])) {
            $this->_dataArray['smArr']['customer_discount'] = $smArr[$this->_dataArray['smArr']['sm_code'] . '_*_' . $this->_paramsArray['warehouseId']];
            return true;
        }
        if (isset($smArr[$this->_dataArray['smArr']['sm_code'] . '_*_0'])) {
            $this->_dataArray['smArr']['customer_discount'] = $smArr[$this->_dataArray['smArr']['sm_code'] . '_*_0'];
            return true;
        }
        if (isset($smArr['*_' . $this->_paramsArray['customerCode'] . '_' . $this->_paramsArray['warehouseId']])) {
            $this->_dataArray['smArr']['customer_discount'] = $smArr['*_' . $this->_paramsArray['customerCode'] . '_' . $this->_paramsArray['warehouseId']];
            return true;
        }
        $this->_dataArray['smArr']['customer_discount'] = $customerMap[0]['smc_discount'] > 0 ? $customerMap[0]['smc_discount'] : $discount;
        return true;
    }

    /**
     * @desc 成本核算
     */
    private function costAccounting()
    {
        $baseCost = $this->_dataArray['costArr']['baseCost'];
        $baseTicketFee = $this->_dataArray['costArr']['baseTicketFee'];
        if (isset($this->_dataArray['smArr']['customer_discount']) && $this->_dataArray['smArr']['customer_discount'] > 0) {
            $baseCost = $baseCost * $this->_dataArray['smArr']['customer_discount'];
            $baseTicketFee = $baseTicketFee * $this->_dataArray['smArr']['customer_discount'];
        }

        $baseBaf = $this->_dataArray['costArr']['baseBaf'];
        $cost_total = $this->_dataArray['costArr']['map_cost'] + $this->_dataArray['costArr']['map_one_ticket_cost'] + $this->_dataArray['costArr']['cost_baf']; // 成本费用
        $real_total = $baseCost + $baseTicketFee + $baseBaf; // 实际费用
        if ($real_total < $cost_total) {
          $baseCost = $this->_dataArray['costArr']['map_cost'];
          $baseTicketFee = $this->_dataArray['costArr']['map_one_ticket_cost'];
          $baseBaf = $this->_dataArray['costArr']['cost_baf'];
        }

        $baseCost = sprintf('%.2f', $baseCost);
        $baseTicketFee = sprintf('%.2f', $baseTicketFee);
        $this->_dataArray['costArr']['baseCost'] = $baseCost;
        $this->_dataArray['costArr']['baseTicketFee'] = $baseTicketFee;
        $this->_dataArray['costArr']['baseBaf'] = sprintf('%.2f', $baseBaf);
        $totalCost = sprintf('%.2f', $baseCost + $baseTicketFee + $baseBaf + $this->_dataArray['costArr']['addCost'] + $this->_dataArray['costArr']['pCost'] + $this->_dataArray['costArr']['regCost']);
        $this->_dataArray['costArr']['totalCost'] = $totalCost;
    }

}