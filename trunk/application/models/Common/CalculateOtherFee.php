<?php
class Common_CalculateOtherFee
{
    protected $_paramsArray = array(); //参数
    protected $_dataArray = array(); //自定义
    protected $_errorArray = array(); //错误信息
    //只针对以下运输方式扣费
    protected $allowShipType = array(
        'SZY-EMS',
        'SZY-EUB',
        'WG-EUB',
        'WG-EMS'
    );
    protected $zccqShipType = array(
        'ZCCQ',
    );
    protected $iszccq = false;
	/***
	 * 逻辑如下:
	 * -----------------------------------------------------------
	 * 								
	 * 								可用   （按设置的打折）
	 * 				1) 设置客户杂费 
	 * 设置费用可用   					不可用 （不收费）
	 * 
	 *				2) 没设置客户杂费   不打折全额收费
	 *------------------------------------------------------------
	 *								可用  （收费） 客户打折收费
	 *				3）设置客户杂费   
	 *								 不可用 不收费	
	 * 设置费用不可用
	 * 				4）没设置客户杂费
	 * ------------------------------------------------------------
	 */
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
            'order_code'=>null,
        	'receiving_code'=>null,	
        	'receiving_weight'=>null,	
        	'orderProducts'=>array(),
        	'orderInfo'=>array(),
        	'receingInfo'=>array()	
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
        $ordersProducts = '';
        $orderinfo = '';
        if(isset($this->_paramsArray['order_code']) && $this->_paramsArray['order_code']!='') {
        	$ordersProductCondition = array(
        			'order_code'=>$this->_paramsArray['order_code']
        	);
        	$ordersProducts = Service_OrderProduct::getByCondition($ordersProductCondition,'*');
        	$orderinfo=Service_Orders::getByField($this->_paramsArray['order_code'],'order_code');
            $this->_paramsArray['warehouse_id'] = $orderinfo['warehouse_id'];
        }
        $this->_paramsArray['orderProducts'] = $ordersProducts;
        $this->_paramsArray['orderInfo'] = $orderinfo;
        if(isset($this->_paramsArray['receiving_code']) && $this->_paramsArray['receiving_code']!='') {
        	$receivinginfo=Service_Receiving::getByField($this->_paramsArray['receiving_code'],'receiving_code');
        	$this->_paramsArray['receingInfo'] = $receivinginfo;
        }
        $this->getzccq();
    }
    private function getzccq(){
        $smCode = strtoupper($this->_paramsArray['smCode']);
        if(in_array($smCode,$this->zccqShipType)){
            $this->iszccq =true;
        }
    }
    /**
     * @todo 得到其它费用
     */
    public function getOtherFee($feeCode=''){
    	$result = array('state' => 0, 'error' => array(), 'data' => array());
		if(!empty($feeCode)){
			switch(strtoupper($feeCode)){
				case "CAOZUO":
					$this->getCaozuoFee();
					break;
				case "CANGCHU":
					$this->getWarehouseFee();
					break;
				case "BAOGUAN":
					$this->getBaoguanFee();
					break;
				case "TIHUO":
					$this->getTiHuoFee();
					break;
				case "YUNSHU":	
					$this->getYunshuFee();
					break;
                case "RUKU":
                    $this->getRuKuFee();
                    break;
                case "WULIUCAOZUO";
                    $this->getWuLiuCaoZuoFee();
                    break;
                case 'PIANYUAN':
                    $this->getPianYuanFee();
                case '4PXPYDQ':
                    $this->get4PxpydqFee();
                case "WULIAO":
                    $this->wuliaoFee();
                    break;
                case "GUANLI":
                    $this->guanliFee();
                    break;
                case "JIANGUANYUNSHU":
                    $this->getJianguanYunshuFee();
                    break;                
		          case "BHDPDREMOTEFEE":
                    $this->getBHDPDRemoteFee();
                    break;
                case "CZBGF":
                    $this->getChaozhiBaoguanFee();
                    break;
               case 'FBATAX':
                    $this->getFbataxFee();
                    break;
                case "KYF":
                    $this->kongyunFee();
                    break;
                /*case "JZBG":
                    $this->getJzsbFee();
                    break;*/
                case "POD":
                    $this->podFee();
                    break;
                case "GFX";
                    $this->gaofengxianFee();
                    break;
                case "SXZ";
                    $this->shouxianzhiFee();
                    break;
                case '4PX-DUTY':
                    $this->duty4pxFeee();
                    break;
                case 'SANZU':
                    $this->sanzuFee();
                    break;
            }
		}else{
			$this->getCaozuoFee();
			$this->getWarehouseFee();
			$this->getBaoguanFee();
			$this->getTiHuoFee();
			$this->getYunshuFee();
            $this->getRuKuFee();
            $this->getWuLiuCaoZuoFee();
            $this->getPianyuanFee();
            $this->get4PxpydqFee();
            $this->wuliaoFee();
            $this->guanliFee();
            $this->getJianguanYunshuFee();
            $this->getBHDPDRemoteFee();
            $this->getChaozhiBaoguanFee();
            $this->getFbataxFee();
            $this->kongyunFee();
            $this->gaofengxianFee();
            $this->shouxianzhiFee();
            //$this->getJzsbFee();
            $this->podFee();
            $this->duty4pxFeee();
            $this->sanzuFee();
		}
    	$result = array('state' => 1, 'data' => array('otherFee' => $this->_dataArray['costArr']['otherFee']));
    	return $result;
    }
    /**
     * [getFbataxFee 关税预付操作费]
     * @todo [计算关税操作费]
     * @return [type] [description]
     */
    private function getFbataxFee()
    {
        $otherfee = Service_OtherFee::getByField('FBATAX', 'fee_code');
        $return = array('currency_code' => $otherfee['fee_currency_code'], 'price' => 0, 'fee_id' => $otherfee['fee_id']);
        if ($this->iszccq) {
            return $return;
        }

        $fee_id = 0;
        $cost = 0;
        $discount = 1; /* 客户折扣，1=100% */

        if (empty($otherfee)) {
            return;
        }
        $fbataxfee = $otherfee['fee_value'];
        $cost = $otherfee['fee_amount'];

        $customerFeeCondition = array(
            'customer_code' => $this->_paramsArray['orderInfo']['customer_code'],
            'fee_id' => $otherfee['fee_id'],
        );
        $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');

        if ('1' == $otherfee['status']) {
            //杂费状态：可用
            if (!empty($customerOtherFee)) {
                if ($customerOtherFee[0]['status'] == '1') {
                    //客户杂费可用，则参与打折计算
                    $fbataxfee = $customerOtherFee[0]['discount'] * $fbataxfee;
                    $discount = $customerOtherFee[0]['discount'];
                } else {
                    $fbataxfee = 0;
                }
            } else {
                //非默认费用且该客户无此项杂费设置，则此项费用不收
                if ('0' == $otherfee['is_default_fee']) {
                    $fbataxfee = 0;
                    $cost = 0;
                }
            }
        } else {
            //杂费状态：不可用
            $fbataxfee = 0;
            $cost = 0;
        }

        $fbataxfee = sprintf('%.2f', $fbataxfee);
        $this->_dataArray['costArr']['otherFee']['fbatax'] = array(
            'currency_code' => $otherfee['fee_currency_code'],
            'price' => $fbataxfee,
            'fee_id' => $otherfee['fee_id'],
            'discount' => $discount,
            'cost' => $cost,
        );
    }
    /**
     * @author william-fan
     * @todo 用于计算操作费
     */
    private function getCaozuoFee(){
        $otherfee=Service_OtherFee::getByField('CAOZUO','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
    	//1.5元/单+0.5*（n-1）
        $maxNumber  = 5;    /* 最多只收5件费用，超过5件后不再增加 */
        $feeAdd     = 0.5;  /* 续件0.5元 */
        $discount   = 1;    /* 客户折扣，1=100% */
        $otherfee = Service_OtherFee::getByField('CAOZUO', 'fee_code');
        if (empty($otherfee)) {
            return;
        }
        $caozuofee  = $otherfee['fee_value'];
        if ($this->_paramsArray['orderInfo']['order_mode_type'] == '0') {
            //备货模式才收操作费
            $products = 0;
            if (isset($this->_paramsArray['orderProducts'])) {
                $ordersProducts = $this->_paramsArray['orderProducts'];
                foreach ($ordersProducts as $key => $value) {
                    $products += $value['op_quantity'];
                }
            }
            if ($products > 0) {
                if($products <= $maxNumber){
                    $caozuofee  = $caozuofee + ($products - 1) * $feeAdd;
                }else{
                    $caozuofee  = $caozuofee + 2 +($products - 5) * 0.1;
                }
                //$cost       = $cost + ($products - 1) * $feeAdd;
            }

            $customerFeeCondition = array(
                'customer_code' => $this->_paramsArray['orderInfo']['customer_code'],
                'fee_id'        => $otherfee['fee_id']
            );
            $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');

            if('1' == $otherfee['status']){
                //杂费状态：可用
                if(!empty($customerOtherFee)) {
                    if ($customerOtherFee[0]['status'] == '1') {
                        //客户杂费可用，则参与打折计算
                        $caozuofee  = $customerOtherFee[0]['discount'] * $caozuofee;
                        $cost       = 0;
                        $discount   = $customerOtherFee[0]['discount'];
                    }
                } else {
                    //非默认费用且该客户无此项杂费设置，则此项费用不收
                    if('0' == $otherfee['is_default_fee']){
                        $caozuofee  = 0;
                        $cost       = 0;
                    }
                }
            } else {
                //杂费状态：不可用
                $caozuofee  = 0;
                $cost       = 0;
            }

        } else {
            //集货模式操作费为0
            $caozuofee  = 0;
            $cost       = 0;
        }
    	$otherfee=Service_OtherFee::getByField('CAOZUO','fee_code');
    	if(!empty($otherfee)){
    		$customerFeeCondition = array(
    				'customer_code'=>$this->_paramsArray['orderInfo']['customer_code'],
    				'fee_id'=>$otherfee['fee_id']
    		);
    		$customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition,'*');
    		
    		if($otherfee['status']=='1'){
    			if(!empty($customerOtherFee)){
    				//设置了费用
    				if($customerOtherFee[0]['status']=='1'){
    					//客户杂费可用
    					$caozuofee = $customerOtherFee[0]['discount']*$caozuofee;
    				}else{
    					$caozuofee =0; //不可用不收费
    				}
    			}
    		}else{
    			//费用不可用
    			if(!empty($customerOtherFee) && $customerOtherFee[0]['status']=='1'){
    				$caozuofee = $customerOtherFee[0]['discount']*$caozuofee;
    			}else{
    				$caozuofee = 0;
    			}
    		}
            $caozuofee = sprintf('%.2f',$caozuofee);
    		$this->_dataArray['costArr']['otherFee']['caozuo'] = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>$caozuofee,'fee_id'=>$otherfee['fee_id']);
    	}
    }
    /**
     * @author william-fan
     * @todo 用于计算仓储费
     */
    private function getWarehouseFee(){
        $otherfee = Service_OtherFee::getByField('CANGCHU','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
    	/* 第一个月全免（30天），
    	 之后按0.1元/SKU/天 */
        if($this->_paramsArray['orderInfo']['order_mode_type']=='0'){
        	$cangchuFee = 0;
        	$pickingCondition = array(
        			'order_code'=>$this->_paramsArray['order_code'],
        			'pd_status'=>'1'
        	);
        	$pickingDetails=Service_PickingDetail::getByCondition($pickingCondition,'*');
        	//print_r($pickingDetails);
        	if(!empty($pickingDetails)){
        		$dateTo = date('Y-m-d H:i:s');
        		foreach ($pickingDetails as $key=>$value){
        			//$value['product_id']
        			$inventoryBatch = Service_InventoryBatch::getByField($value['ib_id']);
        			if(!empty($inventoryBatch)){
        				$dateFrom = $inventoryBatch['ib_add_time'];
        				$diffdate = $this->getDiffDate($dateFrom, $dateTo);
        				//echo $diffdate.":".$dateFrom.":".$dateTo;echo "<br/>";
        				$cangchuFee=$cangchuFee+0.1*$value['pd_quantity']*($diffdate);
        			}
        		}
        	}
        }else{
        	$cangchuFee = '0';
        }
        $cangchuFee = sprintf('%.2f',$cangchuFee);
        $otherfee = Service_OtherFee::getByField('CANGCHU','fee_code');
        
        if(!empty($otherfee)){
        	$customerFeeCondition = array(
        			'customer_code'=>$this->_paramsArray['orderInfo']['customer_code'],
        			'fee_id'=>$otherfee['fee_id']
        	);
        	$customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition,'*');
        	if($otherfee['status']=='1'){
        		//操作费可用
        		if(!empty($customerOtherFee)){
        			if($customerOtherFee[0]['status']=='1'){
        				$cangchuFee = $customerOtherFee[0]['discount']*$customerOtherFee;
        			}else{
        				$cangchuFee = 0;
        			}
        		}
        	}else{
        		//操作费不可用
        		if(!empty($customerOtherFee) && $customerOtherFee[0]['status']=='1'){
        			$cangchuFee = $customerOtherFee[0]['discount']*$customerOtherFee;
        		}else{
        			$cangchuFee = 0;
        		}
        	}
            $cangchuFee = sprintf('%.2f',$cangchuFee);
        	$this->_dataArray['costArr']['otherFee']['cangchu'] = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>$cangchuFee,'fee_id'=>$otherfee['fee_id']);
        }
    }
    /**
     * @author william-fan
     * @todo 用于计算两个时间段的时间差
     */
    private function getDiffDate($dateFrom,$dateTo){
		list($year, $month, $day) = sscanf($dateFrom, '%d-%d-%d');
		if(!checkdate($month, $day, $year)){
			return false;
		}
		list($year, $month, $day) = sscanf($dateTo, '%d-%d-%d');
		if(!checkdate($month, $day, $year)){
			return false;
		}
		$timeStamp = (strtotime($dateTo)-strtotime($dateFrom));
		return ceil($timeStamp/(24*3600));
    }
    /**
     * @author solar<solarzheng@cargofe.com.cn>
     * @todo 计算报关费
     */
    private function getBaoguanFee() {
        $otherfee = Service_OtherFee::getByField('BAOGUAN1','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
        $weight_1       = 2;    /* 第一重量段：小于等于 2kg */
        $weight_2       = 80;  /* 第二重量段：小于等于 200kg */
        //$weight_3       = 500;  /* 第三重量段：小于等于 500kg */
        $baoguanFee     = 0;
        $orderWeight    = $this->_paramsArray['weight'];

        $fee_id         = 0;
        $cost           = 0;
        $discount       = 1;    /* 客户折扣，1=100% */

        if ($orderWeight <= $weight_1) { //如果小于等于第一重量段
            $baoguan1       = Service_OtherFee::getByField('BAOGUAN1', 'fee_code');
            $baoguan        = $baoguan1;
            $currency_code  = $baoguan1['fee_currency_code'];
            $fee_id         = $baoguan1['fee_id'];

            switch($baoguan1['fee_unit']){
                case '1':
                    $baoguanFee     = $baoguan1['fee_value']*$orderWeight;
                    $cost           = $baoguan1['fee_amount']*$orderWeight;
                    break;
                case '2':
                    $baoguanFee     = $baoguan1['fee_value'];
                    $cost           = $baoguan1['fee_amount'];
                    break;
            }
        } elseif ($orderWeight>=$weight_1 && $orderWeight<=$weight_2) {
            $baoguan1       = Service_OtherFee::getByField('BAOGUAN2', 'fee_code');
            $baoguan        = $baoguan1;
            $currency_code  = $baoguan1['fee_currency_code'];
            $fee_id         = $baoguan1['fee_id'];
            switch($baoguan1['fee_unit']){
                case '1':
                    $baoguanFee     = $baoguan1['fee_value']*$orderWeight;
                    $cost           = $baoguan1['fee_amount']*$orderWeight;
                    break;
                case '2':
                    $baoguanFee     = $baoguan1['fee_value'];
                    $cost           = $baoguan1['fee_amount'];
                    break;
            }
        } elseif ($orderWeight >$weight_2){
            $baoguan1       = Service_OtherFee::getByField('BAOGUAN3', 'fee_code');
            $baoguan        = $baoguan1;
            $currency_code  = $baoguan1['fee_currency_code'];
            $fee_id         = $baoguan1['fee_id'];
            switch($baoguan1['fee_unit']){
                case '1':
                    $baoguanFee     = $baoguan1['fee_value']+0.5*$orderWeight;
                    $cost           = $baoguan1['fee_amount'];
                    break;
                case '2':
                    $baoguanFee     = $baoguan1['fee_value'];
                    $cost           = $baoguan1['fee_amount'];
                    break;
            }
        } else {
            $baoguan        = '';
            $currency_code  = '';
            $fee_id         = '';
            $baoguanFee     = 0;
            $cost           = 0;
        }
    	$baoguanFee = sprintf('%.2f', $baoguanFee);
    	
    	if(!empty($baoguan)){
    		$customerFeeCondition = array(
    				'customer_code'=>$this->_paramsArray['orderInfo']['customer_code'],
    				'fee_id'=>$fee_id
    		);
    		$customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition,'*');
    		if($baoguan['status']=='1'){
    			//报关费可用情况
    			if(!empty($customerOtherFee)){
    				//设置了客户折扣费用
    				if($customerOtherFee[0]['status']=='1'){
    					$baoguanFee = $customerOtherFee[0]['discount']*$baoguanFee;
    				}else{
    					$baoguanFee = 0; //设置了客户费用但是不可用就不收费
    				}
    			}
    		}else{
    			if(!empty($customerOtherFee) && $customerOtherFee[0]['status']=='1'){
    				//设置了客户杂费并且可用
    				$baoguanFee = $customerOtherFee[0]['discount']*$baoguanFee;
    			}else{
    				$baoguanFee = 0;
    			}
    		}
            $baoguanFee = sprintf('%.2f',$baoguanFee);
    		$this->_dataArray['costArr']['otherFee']['baoguan'] = array('currency_code'=>$currency_code,'price'=>$baoguanFee,'fee_id'=>$fee_id);
    	}
    }
    
    /**
     * @author solar<solarzheng@cargofe.com.cn>
     * @todo 计算提货费
     */
    private function getTiHuoFee() {
    	$tihuoFee = 0;
    	$receivingRow = $this->_paramsArray['receingInfo'];
    	$tihuo = Service_OtherFee::getByField('TIHUO', 'fee_code');
    	/* if($receivingRow && $tihuo && $tihuo['status']==1) {

    	} */
        if (empty($tihuo)) {
            return;
        }
    	if(isset($this->_paramsArray['receiving_weight']) && $this->_paramsArray['receiving_weight']>0){
    		$weight = $this->_paramsArray['receiving_weight'];
    	}else{
    		$weight = 0;
            if($this->_paramsArray['receiving_code']){
                if($receivingRow['receive_model_type']==1) {	//集货
                    $weight = Service_ReceivingOrderDetail::sumNetWeight($this->_paramsArray['receiving_code']);
                } else {	//备货
                    $weight = Service_ReceivingDetail::sumNetWeight($this->_paramsArray['receiving_code']);
                }
            }
    	}

        switch($tihuo['fee_unit']){
            case '1':
                $tihuoFee     = $tihuo['fee_value']*$weight;
                break;
            case '2':
                $baoguanFee     = $tihuo['fee_value'];
                break;
        }


    	$tihuoFee = $tihuo['fee_value'] * $weight;
    	$tihuoFee = sprintf('%.2f', $tihuoFee);
        //最低100RMB限制
        if($tihuoFee>0){
            $tihuoFeeRMB=Service_Currency::converByCode($tihuo['fee_currency_code'],'RMB',$tihuoFee);
            if($tihuoFeeRMB<100){
                $tihuoFeeRMB = 100;
                $tihuoFee = Service_Currency::converByCode('RMB',$tihuo['fee_currency_code'],$tihuoFeeRMB);
            }
        }
    	if(!empty($tihuo)){
    		//设置提货费情况
    		//查询客户折扣
    		$customerFeeCondition = array(
    				'customer_code'=>$this->_paramsArray['receingInfo']['customer_code'],
    				'fee_id'=>$tihuo['fee_id']
    		);
    		$customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition,'*');
    		if($tihuo['status']=='1'){
    			//提货费用可用
    			if(!empty($customerOtherFee)){
    				//设置了客户折扣费用
    				if($customerOtherFee[0]['status']=='1'){
    					$tihuoFee = $customerOtherFee[0]['discount']*$tihuoFee;
    				}else{
    					$tihuoFee = 0; //设置了客户费用但是不可用就不收费
    				}
    			}
    		}else{
    			//提货费用不可用
    			if(!empty($customerOtherFee) && $customerOtherFee[0]['status']=='1'){
    				//设置了客户杂费并且可用
    				$tihuoFee = $customerOtherFee[0]['discount']*$tihuoFee;
    			}else{
    				$tihuoFee = 0;
    			}
    		}
            $tihuoFee = sprintf('%.2f',$tihuoFee);
    		$this->_dataArray['costArr']['otherFee']['tihuo'] = array('currency_code'=>$tihuo['fee_currency_code'],'price'=>$tihuoFee,'fee_id'=>$tihuo['fee_id']);
    	}
    }
    
    /**
     * @author solar<solarzheng@cargofe.com.cn>
     * @todo 计算中转运输费
     */
    private function getYunshuFee() {
        $otherfee = Service_OtherFee::getByField('YUNSHU','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
    	$yunshuFee = 0;
    	$yunshu = Service_OtherFee::getByField('YUNSHU', 'fee_code');
    	$weight = Service_Orders::calculateWeight($this->_paramsArray['order_code']);
        $allowShip = array(
            'SELF-HF-ASENDIA',
            'SELF-HF-DGM',
            'SELF-HF-PNLP',
            'SELF-HF-DDP'
        );
    	if(!empty($yunshu)){
    		$customerFeeCondition = array(
    				'customer_code'=>$this->_paramsArray['orderInfo']['customer_code'],
    				'fee_id'=>$yunshu['fee_id']
    		);
    		$customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition,'*');
    		
    		if($yunshu['status']=='1'){
    			//运输费可用
    			if(!empty($customerOtherFee)){
                    if(in_array($this->_paramsArray['orderInfo']['sm_code'],$allowShip)){
                        $yunshuFee  = sprintf('%.2f', $yunshu['fee_value'] * $weight);
                        $yunshuFee = sprintf('%.2f', $yunshuFee);
                    }
    				//设置了客户折扣费用
    				if($customerOtherFee[0]['status']=='1'){
    					//客户设置了安折扣收费
    					$yunshuFee = $customerOtherFee[0]['discount']*$yunshuFee;
    				}else{
    					//不可用 不收费
    					$yunshuFee = 0;
    				}
    			}	
    		}else{
    			//运输费不可用
    			if(!empty($customerOtherFee) && $customerOtherFee[0]['status']=='1'){
    				//设置了客户杂费并且可用
    				$yunshuFee = $customerOtherFee[0]['discount']*$yunshuFee;
    			}else{
    				$yunshuFee = 0;
    			}	
    		}
            $yunshuFee = sprintf('%.2f',$yunshuFee);
    		$this->_dataArray['costArr']['otherFee']['yunshu'] = array('currency_code'=>$yunshu['fee_currency_code'],'price'=>$yunshuFee,'fee_id'=>$yunshu['fee_id']);    		
    	}
    }

    /**
     * @author
     * @todo 计算监管车运输费
     */
    private function getJianguanYunshuFee()
    {
        $yunshuFee  = 0;
        $cost       = 0;
        $discount   = 1;    /* 客户折扣，1=100% */
        $yunshu     = Service_OtherFee::getByField('JIANGUANYUNSHU', 'fee_code');
        $weight     = $this->_paramsArray['weight'];
        $allowShip = array(
            'SELF-HF-EUB',
        );

        if (!empty($yunshu)) {
            $customerFeeCondition = array(
                'customer_code' => $this->_paramsArray['orderInfo']['customer_code'],
                'fee_id'        => $yunshu['fee_id']
            );
            $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');

            if('1' == $yunshu['status']){
                //杂费状态：可用
                if(!empty($customerOtherFee)) {
                    if ($customerOtherFee[0]['status'] == '1') {
                        if(in_array($this->_paramsArray['orderInfo']['sm_code'],$allowShip)){
                            $yunshuFee  = sprintf('%.2f', $yunshu['fee_value'] * $weight);
                            $cost       = sprintf('%.2f', $yunshu['fee_amount'] * $weight);
                        }
                        //客户杂费可用，则参与打折计算
                        $yunshuFee  = $customerOtherFee[0]['discount'] * $yunshuFee;
                        $discount   = $customerOtherFee[0]['discount'];
                    }
                } else {
                    //非默认费用且该客户无此项杂费设置，则此项费用不收
                    if('0' == $yunshu['is_default_fee']){
                        $yunshuFee  = 0;
                        $cost       = 0;
                    }
                }
            } else {
                //杂费状态：不可用
                $yunshuFee  = 0;
                $cost       = 0;
            }

            $this->_dataArray['costArr']['otherFee']['jianguanyunshu'] = array(
                'currency_code' => $yunshu['fee_currency_code'],
                'price'         => $yunshuFee,
                'discount'      => $discount,
                'cost'          => $cost,
                'sp_code'       => $yunshu['sp_code'],
                'fee_id'        => $yunshu['fee_id']
            );
        }
    }

    private function getRuKuFee(){
        $otherfee = Service_OtherFee::getByField('RUKU','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
        if($this->_paramsArray['receingInfo']['receive_model_type']=='0'){
            $weight=$this->_paramsArray['receingInfo']['roughweight'];
            $ruku = Service_OtherFee::getByField("RUKU","fee_code","*");
            if(!empty($ruku)){    
            $ruku = Service_OtherFee::getByField("RUKU","fee_code","*");
                $customerFeeCondition = array(
                    'customer_code'=>$this->_paramsArray['receingInfo']['customer_code'],
                    'fee_id'=>$ruku['fee_id']
                );
                $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition,'*');
                $mapCharge=array(
                    '1000'=>array('0','2000'),
                    '1500'=>array('2000','5000'),
                    '2000'=>array('5000'),
                );
                $rukuFee = $ruku['fee_value']*$weight;
                foreach($mapCharge as $maxMoney=>$weightRange){
                    if(isset($weightRange[1])){
                          if($weight<=$weightRange[1]){
                              if($rukuFee>$maxMoney){
                                $rukuFee=$maxMoney;
                              }
                             break;
                          }
                    }else{
                        $rukuFee=$maxMoney;
                    }
                }
                if($ruku['status']=='1'){
                    //入库费可用情况
                    if(!empty($customerOtherFee)){
                        //设置了客户折扣费用
                        if($customerOtherFee[0]['status']=='1'){
                            $rukuFee = $customerOtherFee[0]['discount']*$rukuFee;
                        }
                    }
                }else{
                    if(!empty($customerOtherFee) && $customerOtherFee[0]['status']=='1'){
                        //设置了客户杂费并且可用
                        $rukuFee = $customerOtherFee[0]['discount']*$rukuFee;
                    }else{
                        $rukuFee = 0;
                    }
                }
                $rukuFee = sprintf('%.2f',$rukuFee);
                $this->_dataArray['costArr']['otherFee']['ruku'] = array('currency_code'=>$ruku['fee_currency_code'],'price'=>$rukuFee,'fee_id'=>$ruku['fee_id']);
            }
        }
    }

    private function getWuLiuCaoZuoFee(){
        $otherfee = Service_OtherFee::getByField('WULIUCAOZUO','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
        $shippingMethod = Service_ShippingMethod::getByField($this->_paramsArray['orderInfo']['sm_code'],"sm_code","*");
        $wlcz = Service_OtherFee::getByField("WULIUCAOZUO","fee_code","*");
        if($shippingMethod['sm_channel']=="1"){
            $this->_dataArray['costArr']['otherFee']['wuliucaozuo'] = array('currency_code'=>$wlcz['fee_currency_code'],'price'=>0,'fee_id'=>$wlcz['fee_id']);
        }else{
            if(!empty($wlcz)){
                $customerFeeCondition = array(
                    'customer_code'=>$this->_paramsArray['orderInfo']['customer_code'],
                    'fee_id'=>$wlcz['fee_id']
                );
                $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition,'*');
                $wlczFee = $wlcz['fee_value'];
                if($wlcz['status']=='1'){
                    //入库费可用情况
                    if(!empty($customerOtherFee)){
                        //设置了客户折扣费用
                        if($customerOtherFee[0]['status']=='1'){
                            $wlczFee = $customerOtherFee[0]['discount']*$wlczFee;
                        }
                    }
                }else{
                    if(!empty($customerOtherFee) && $customerOtherFee[0]['status']=='1'){
                        //设置了客户杂费并且可用
                        $wlczFee = $customerOtherFee[0]['discount']*$wlczFee;
                    }else{
                        $wlczFee = 0;
                    }
                }
                $wlczFee = sprintf('%.2f',$wlczFee);
                $this->_dataArray['costArr']['otherFee']['wuliucaozuo'] = array('currency_code'=>$wlcz['fee_currency_code'],'price'=>$wlczFee,'fee_id'=>$wlcz['fee_id']);
            }
        }
    }


    /**
     * @author william-fan
     * @todo 计算集中申报费(无逻辑，暂时不用)
     */
    private function getJzsbFee() {
        $cost = 0;
        $discount = 1; /* 客户折扣，1=100% */
        $jzsb = Service_OtherFee::getByField("JZSB","fee_code","*");

        if (! empty ( $jzsb )) {
            $customerFeeCondition = array (
                'customer_code' => $this->_paramsArray ['orderInfo'] ['customer_code'],
                'fee_id' => $jzsb ['fee_id']
            );
            $customerOtherFee = Service_CustomerOtherFee::getByCondition ( $customerFeeCondition, '*' );
            $jzsbFee = $jzsb ['fee_value'] ;
            $cost = $jzsb ['fee_amount'];

            if ('1' == $jzsb ['status']) {
                // 杂费状态：可用
                if (! empty ( $customerOtherFee )) {
                    if ($customerOtherFee [0] ['status'] == '1') {
                        // 客户杂费可用，则参与打折计算
                        $orderWeight = $this->_paramsArray ['weight'];
                        $jzsb = Service_OtherFee::getByField ( "JZSB", "fee_code", "*" );

                        switch($jzsb['fee_unit']){
                            case '1':
                                $jzsbFee     = $jzsb['fee_value']*$orderWeight;
                                $cost           = $jzsb['fee_amount']*$orderWeight;
                                break;
                            case '2':
                                $jzsbFee     = $jzsb['fee_value'];
                                $cost           = $jzsb['fee_amount'];
                                break;
                        }
                        $jzsbFee = $customerOtherFee [0] ['discount'] * $jzsbFee;
                        $discount = $customerOtherFee [0] ['discount'];
                    }
                } else {
                    // 非默认费用且该客户无此项杂费设置，则此项费用不收
                    if ('0' == $jzsb ['is_default_fee']) {
                        $jzsbFee = 0;
                        $cost = 0;
                    }
                }
            } else {
                // 杂费状态：不可用
                $jzsbFee = 0;
                $cost = 0;
            }
            $this->_dataArray ['costArr'] ['otherFee'] ['jzsb'] = array (
                'currency_code' => $jzsb ['fee_currency_code'],
                'price' => $jzsbFee,
                'discount' => $discount,
                'cost' => $cost,
                'sp_code' => $jzsb ['sp_code'],
                'fee_id' => $jzsb ['fee_id']
            );
        }
    }


    /**
     * @author william-fan
     * @todo 计算偏远费
     */
    private function getPianyuanFee(){
        $otherfee = Service_OtherFee::getByField('PIANYUAN','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
        //是偏远的订单
        if($this->_paramsArray['orderInfo']['is_remote_city']=='1'){
            //4PX-HKDHL该渠道只扣偏远地区附加费
            if($this->_paramsArray['orderInfo']['sm_code']=='4PX-HKDHL'){
                return;
            }
            //偏远城市，计算偏远费
            $pianyuan = Service_OtherFee::getByField ( "PIANYUAN", "fee_code", "*" );
            if (! empty ( $pianyuan )) {
                $customerFeeCondition = array (
                    'customer_code' => $this->_paramsArray ['orderInfo'] ['customer_code'],
                    'fee_id' => $pianyuan ['fee_id']
                );
                $customerOtherFee = Service_CustomerOtherFee::getByCondition ( $customerFeeCondition, '*' );
                $pianyuanFee = $pianyuan ['fee_value'] ;
                $cost = $pianyuan ['fee_amount'];
                $discount = 1;

                if ('1' == $pianyuan ['status']) {
                    // 杂费状态：可用
                    if (! empty ( $customerOtherFee )) {
                        if ($customerOtherFee [0] ['status'] == '1') {
                            // 客户杂费可用，则参与打折计算
                            $pianyuanFee = $customerOtherFee [0] ['discount'] * $pianyuanFee;
                            $discount = $customerOtherFee [0] ['discount'];
                        }
                    } else {
                        // 非默认费用且该客户无此项杂费设置，则此项费用不收
                        if ('0' == $pianyuan ['is_default_fee']) {
                            $pianyuanFee = 0;
                            $cost = 0;
                        }
                    }
                } else {
                    // 杂费状态：不可用
                    $pianyuanFee = 0;
                    $cost = 0;
                }
                $pianyuanFee = sprintf('%.2f',$pianyuanFee);
                $this->_dataArray ['costArr'] ['otherFee'] ['pianyuan'] = array (
                    'currency_code' => $pianyuan ['fee_currency_code'],
                    'price' => $pianyuanFee,
                    'discount' => $discount,
                    'cost' => $cost,
                    'sp_code' => $pianyuan ['sp_code'],
                    'fee_id' => $pianyuan ['fee_id']
                );
            }

        }
    }

    /**
     * @author events
     * @todo 计算偏远地区附加费
     */
    private function get4PxpydqFee(){
        $otherfee = Service_OtherFee::getByField('4PXPYDQ','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
        // $weight = Service_ShipOrder::getByField($this->_paramsArray['order_code'],'order_code',"*");
        // $weight = Service_Orders::calculateWeight($this->_paramsArray['order_code']);
        // print_r($weight);exit;
        //是偏远的订单
        if($this->_paramsArray['orderInfo']['is_remote_city']=='1'){
            //偏远城市，计算偏远附加费
            $pydqfjf = Service_OtherFee::getByField ( "4PXPYDQ", "fee_code", "*" );
            if (! empty ( $pydqfjf )) {
                if($this->_paramsArray['orderInfo']['sm_code']=='4PX-HKDHL'){
                    $customerFeeCondition = array (
                        'customer_code' => $this->_paramsArray ['orderInfo'] ['customer_code'],
                        'fee_id' => $pydqfjf ['fee_id']
                    );
                    $customerOtherFee = Service_CustomerOtherFee::getByCondition ( $customerFeeCondition, '*' );
                    $smCode = $this->_paramsArray['smCode'];
                    $orderWeight    = Service_Orders::calculateWeight($this->_paramsArray['order_code']);
                    $pydqfjfFee = $pydqfjf ['fee_value'] ;
                    $cost = $pydqfjf ['fee_amount'];
                    $discount = 1;
                    if(!empty($smCode)){
                        $shippingMethod = Service_ShippingMethod::getByField($smCode,"sm_code");
                        if('CRE' == $shippingMethod['sm_class_code']){
                            //计费逻辑：RMB3.6/KG,费用=RMB3.6*订单计费重*(1+燃油附加费率)=A，判断A与RMB176的大小，若小于，则偏远地区附加费为RMB176,否则偏远地区附加费为A。成本与费用计算逻辑一样。
                            $pydqfjfFee = $pydqfjf ['fee_value']*$orderWeight*(1+$shippingMethod['sm_baf'])>176 ? $pydqfjf ['fee_value']*$orderWeight*(1+$shippingMethod['sm_baf']) : 176;
                        }
                    }
                    $cost=$pydqfjf ['fee_amount']*$orderWeight*(1+$shippingMethod['sm_baf'])>176 ? $pydqfjf ['fee_amount']*$orderWeight*(1+$shippingMethod['sm_baf']) : 176;
                    if ('1' == $pydqfjf ['status']) {
                        // 杂费状态：可用
                        if (! empty ( $customerOtherFee )) {
                            if ($customerOtherFee [0] ['status'] == '1') {
                                // 客户杂费可用，则参与打折计算
                                $pydqfjfFee = $customerOtherFee [0] ['discount'] * $pydqfjfFee;
                                $discount = $customerOtherFee [0] ['discount'];
                            }
                        } else {
                            // 非默认费用且该客户无此项杂费设置，则此项费用不收
                            if ('0' == $pydqfjf ['is_default_fee']) {
                                $pydqfjfFee = 0;
                                $cost = 0;
                            }
                        }
                    } else {
                        // 杂费状态：不可用
                        $pydqfjfFee = 0;
                        $cost = 0;
                    }
                    $pydqfjfFee = sprintf('%.2f',$pydqfjfFee);
                    $this->_dataArray ['costArr'] ['otherFee'] ['4pxpydq'] = array (
                        'currency_code' => $pydqfjf ['fee_currency_code'],
                        'price' => $pydqfjfFee,
                        'discount' => $discount,
                        'cost' => $cost,
                        'sp_code' => $pydqfjf ['sp_code'],
                        'fee_id' => $pydqfjf ['fee_id']
                    );
                    // print_r($this->_dataArray ['costArr'] ['otherFee'] ['4pxpydq']);exit;
                }
            }

        }
    }
    /**
     * @author william-fan
     * @todo 计算物料费
     */
    private function wuliaoFee(){
        $wuliaoFee  = 0;
        $cost       = 0;
        $discount   = 1;    /* 客户折扣，1=100% */
        $wuliao     = Service_OtherFee::getByField('WULIAO', 'fee_code');
        $weight     = $this->_paramsArray['weight'];

        if (!empty($wuliao)) {
            $customerFeeCondition = array(
                'customer_code' => $this->_paramsArray['orderInfo']['customer_code'],
                'fee_id'        => $wuliao['fee_id']
            );
            $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');

            if('1' == $wuliao['status']){
                //杂费状态：可用
                if(!empty($customerOtherFee)) {
                    if(in_array($this->_paramsArray['smCode'],$this->allowShipType)){
                        $wuliaoFee  = sprintf('%.2f', $wuliao['fee_value'] * $weight);
                        $cost       = sprintf('%.2f', $wuliao['fee_amount'] * $weight);
                    }
                    if ($customerOtherFee[0]['status'] == '1') {
                        //客户杂费可用，则参与打折计算
                        $wuliaoFee  = $customerOtherFee[0]['discount'] * $wuliaoFee;
                        $discount   = $customerOtherFee[0]['discount'];
                    }
                } else {
                    //非默认费用且该客户无此项杂费设置，则此项费用不收
                    if('0' == $wuliao['is_default_fee']){
                        $wuliaoFee  = 0;
                        $cost       = 0;
                    }
                }
            } else {
                //杂费状态：不可用
                $wuliaoFee  = 0;
                $cost       = 0;
            }

            $this->_dataArray['costArr']['otherFee']['wuliao'] = array(
                'currency_code' => $wuliao['fee_currency_code'],
                'price'         => $wuliaoFee,
                'discount'      => $discount,
                'cost'          => $cost,
                'sp_code'       => $wuliao['sp_code'],
                'fee_id'        => $wuliao['fee_id']
            );
        }
    }
    /**
     * @author william-fan
     * @todo 计算管理费
     */
    private function guanliFee(){
        $guanliFee  = 0;
        $cost       = 0;
        $discount   = 1;    /* 客户折扣，1=100% */
        $guanli     = Service_OtherFee::getByField('GUANLI', 'fee_code');
        $weight     = $this->_paramsArray['weight'];

        if (!empty($guanli)) {
            $customerFeeCondition = array(
                'customer_code' => $this->_paramsArray['orderInfo']['customer_code'],
                'fee_id'        => $guanli['fee_id']
            );
            $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');

            if('1' == $guanli['status']){
                //杂费状态：可用
                if(!empty($customerOtherFee)) {
                    if(in_array($this->_paramsArray['smCode'],$this->allowShipType)){
                        $guanliFee  = sprintf('%.2f', $guanli['fee_value'] * $weight);
                        $cost       = sprintf('%.2f', $guanli['fee_amount'] * $weight);
                    }
                    if ($customerOtherFee[0]['status'] == '1') {
                        //客户杂费可用，则参与打折计算
                        $guanliFee  = $customerOtherFee[0]['discount'] * $guanliFee;
                        $discount   = $customerOtherFee[0]['discount'];
                    }
                } else {
                    //非默认费用且该客户无此项杂费设置，则此项费用不收
                    if('0' == $guanli['is_default_fee']){
                        $guanliFee  = 0;
                        $cost       = 0;
                    }
                }
            } else {
                //杂费状态：不可用
                $guanliFee  = 0;
                $cost       = 0;
            }

            $this->_dataArray['costArr']['otherFee']['guanli'] = array(
                'currency_code' => $guanli['fee_currency_code'],
                'price'         => $guanliFee,
                'discount'      => $discount,
                'cost'          => $cost,
                'sp_code'       => $guanli['sp_code'],
                'fee_id'        => $guanli['fee_id']
            );
        }
    }
    
    private function getBHDPDRemoteFee(){
        $BHDPDRemoteFee     = Service_OtherFee::getByField('BHDPDREMOTEFEE', 'fee_code');
        if(!empty($BHDPDRemoteFee)){
            if($BHDPDRemoteFee['status'] =="1"){

            }
            $this->_dataArray['costArr']['otherFee']['BHDPDRemoteFee'] = array(
                'currency_code' => $BHDPDRemoteFee['fee_currency_code'],
                'price'         => $BHDPDRemoteFee['fee_value'],
                'discount'      => $BHDPDRemoteFee['fee_discount'],
                'cost'          => $BHDPDRemoteFee['fee_value'],
                'sp_code'       => $BHDPDRemoteFee['sp_code'],
                'fee_id'        => $BHDPDRemoteFee['fee_id']
            );
        }
    }

    /**
     * @author kevin-wang
     * @todo 计算超值报关费
     */
    private function getChaozhiBaoguanFee(){
        $otherfee = Service_OtherFee::getByField('CZBGF','fee_code');
        $return = array('currency_code'=>$otherfee['fee_currency_code'],'price'=>0,'fee_id'=>$otherfee['fee_id']);
        if($this->iszccq){
            return $return;
        }
        $chaozhiFee=0;
        $cost=0;
        $discount=1;
            if (! empty ( $otherfee )) {
                $customerFeeCondition = array (
                    'customer_code' => $this->_paramsArray ['orderInfo'] ['customer_code'],
                    'fee_id' => $otherfee ['fee_id']
                );
                $customerOtherFee = Service_CustomerOtherFee::getByCondition ( $customerFeeCondition, '*' );
                $sum=0;
                foreach ($this->_paramsArray['orderProducts'] as $key => $value) {
                    $total=$value['op_quantity']*$value['op_purpose_declared_value'];
                    $sum+=$total;
                }
                if ('1' == $otherfee ['status']) {
                   // 杂费状态：可用
                    if('1' == $otherfee['is_default_fee']){
                        if($this->_paramsArray['orderInfo']['sm_code']=='HKDHL'&&$sum>120){
                            $chaozhiFee = $otherfee['fee_value'] ;
                            $cost = $otherfee ['fee_amount'];
                            if (!empty($customerOtherFee)) {
                                if ($customerOtherFee[0]['status'] == '1') {
                                $chaozhiFee = $customerOtherFee [0] ['discount'] * $chaozhiFee;
                                $discount = $customerOtherFee [0] ['discount']; 
                                }
                            }
                        }
                    }else{
                        if (!empty($customerOtherFee)) {
                            if($this->_paramsArray['orderInfo']['sm_code']=='HKDHL'&&$sum>120){
                            $chaozhiFee = $otherfee['fee_value'] ;
                            $cost = $otherfee ['fee_amount'];
                                if ($customerOtherFee[0]['status'] == '1') {
                                $chaozhiFee = $customerOtherFee [0] ['discount'] * $chaozhiFee;
                                $discount = $customerOtherFee [0] ['discount']; 
                                }
                            }
                        }
                        //非默认费用且该客户无此项杂费设置，则此项费用不收
                    }
                } else {
                    // 杂费状态：不可用
                    $chaozhiFee = 0;
                    $cost = 0;
                }
                $this->_dataArray ['costArr'] ['otherFee'] ['chaozhibaoguan'] = array (
                    'cost_currency_code'=>$otherfee['cost_currency_code'],
                    'currency_code' => $otherfee['fee_currency_code'],
                    'price' => $chaozhiFee,
                    'discount' => $discount,
                    'cost' => $cost,
                    'sp_code' => $otherfee['sp_code'],
                    'fee_id' => $otherfee['fee_id']
                );
            }

    }
    /* @author kevin-wang
     * @todo 空运费
     */
    private function kongyunFee(){
        if($this->iszccq){
            return;
        }
        $kongyunFee  = 0;
        $cost       = 0;
        $discount   = 1;    /* 客户折扣，1=100% */
        $kongyun     = Service_OtherFee::getByField('KYF', 'fee_code');
        $weight     = 0;
        if (!empty($this->_paramsArray['orderProducts'])) {
            foreach ($this->_paramsArray['orderProducts'] as $key => $value) {
                $product=Service_Product::getByField($value['product_id'],'product_id');
                $weight+=$product['product_weight'];
            }
        }
        $allowShip=array('PNLG','PNLN','PNLP');
        if (!empty($kongyun)) {
            $customerFeeCondition = array(
                'customer_code' => $this->_paramsArray['orderInfo']['customer_code'],
                'fee_id'        => $kongyun['fee_id']
            );
            $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');
            if('1' == $kongyun['status']){
                //杂费状态：可用
                 if('1' == $kongyun['is_default_fee']){
                    if(in_array($this->_paramsArray['orderInfo']['sm_code'],$allowShip)){
                            $cost       = $kongyun['fee_amount'] * $weight;
                        }
                    if(!empty($customerOtherFee)) {
                        
                        if ($customerOtherFee[0]['status'] == '1') {
                            //客户杂费可用，则参与打折计算
                            $cost  = $customerOtherFee[0]['discount'] * $cost;
                            $discount   = $customerOtherFee[0]['discount'];
                        }
                    } 
                   
                }else{
                    if(!empty($customerOtherFee)) {
                        if(in_array($this->_paramsArray['orderInfo']['sm_code'],$allowShip)){
                            $cost       = $kongyun['fee_amount'] * $weight;
                        }
                        if ($customerOtherFee[0]['status'] == '1') {
                            //客户杂费可用，则参与打折计算
                            $cost  = $customerOtherFee[0]['discount'] * $cost;
                            $discount   = $customerOtherFee[0]['discount'];
                        }
                    } 
                }
            } else {
                //杂费状态：不可用
                $cost       = 0;
            }

            $this->_dataArray['costArr']['otherFee']['kongyun'] = array(
                'cost_currency_code'      => $kongyun['cost_currency_code'],
                'currency_code' => $kongyun['fee_currency_code'],
                'price'         => $kongyunFee,
                'discount'      => $discount,
                'cost'          => $cost,
                'sp_code'       => $kongyun['sp_code'],
                'fee_id'        => $kongyun['fee_id']
            );
        }
    }
    /* @author kevin-wang
     * @todo 高风险附加费
     */
    private function gaofengxianFee(){
        if($this->iszccq){
            return;
        }
        $gfx    = Service_OtherFee::getByField('Elevated Risk', 'fee_code');
        $cost       = 0;  //费用
        $gfxFee     = 0;  //成本
        //高风险地区附加费
        $allowCountry=array("阿富汗","布隆迪","伊拉克","利比亚","马里","尼日尔","南苏丹","叙利亚","也门");
        //受限制地区附加费
       /* $cityArr1=array("中非共和国","科特迪瓦","刚果民主共和国","厄立特里亚","伊拉克","伊朗","北韩","利比亚","利比利亚","索马里","苏丹","叙利亚","也门");*/
        if (!empty($gfx)) {
            if('1' == $gfx['status']){
                //杂费状态：可用
                if ($this->_paramsArray['orderInfo']['sm_code'] == 'HKDHL'||$this->_paramsArray['orderInfo']['sm_code'] == 'BH-HKDHL') {
                    $country=Service_Country::getByField($this->_paramsArray['countryId'],'country_id');
                    if (in_array($country['country_name'],$allowCountry)){
                        $cost = $gfx['fee_value'];
                        $gfxFee = $gfx['fee_amount'];
                    }
                }    
            } else {
                //杂费状态：不可用
                $cost       = 0;
                $gfxFee     = 0;
            }
            $this->_dataArray['costArr']['otherFee']['gfx'] = array(
                'cost_currency_code'      => $gfx['cost_currency_code'],
                'currency_code' => $gfx['fee_currency_code'],
                'price'         => $cost,
                'discount'      => 1,
                'cost'          => $gfxFee,
                'sp_code'       => $gfx['sp_code'],
                'fee_id'        => $gfx['fee_id']
            );
        }
    }
    /* @author kevin-wang
     * @todo 受限制附加费
     */
    private function shouxianzhiFee(){
        if($this->iszccq){
            return;
        }
        $sxz    = Service_OtherFee::getByField('Restricted Destination', 'fee_code');
        $cost       = 0;  //费用
        $sxzFee     = 0;  //成本
        //受限制地区附加费
        $allowCountry=array("中非共和国","科特迪瓦","刚果民主共和国","厄立特里亚","伊拉克","伊朗","北韩","利比亚","利比利亚","索马里","苏丹","叙利亚","也门");
        if (!empty($sxz)) {
            if('1' == $sxz['status']){
                //杂费状态：可用
                if ($this->_paramsArray['orderInfo']['sm_code'] == 'HKDHL'||$this->_paramsArray['orderInfo']['sm_code'] == 'BH-HKDHL') {
                    $country=Service_Country::getByField($this->_paramsArray['countryId'],'country_id');
                    if (in_array($country['country_name'],$allowCountry)){
                        $cost = $sxz['fee_value'];
                        $sxzFee = $sxz['fee_amount'];
                    }
                }    
            } else {
                //杂费状态：不可用
                $cost       = 0;
                $sxzFee     = 0;
            }

            $this->_dataArray['costArr']['otherFee']['sxz'] = array(
                'cost_currency_code' => $sxz['cost_currency_code'],
                'currency_code' => $sxz['fee_currency_code'],
                'price'         => $cost,
                'discount'      => 1,
                'cost'          => $sxzFee,
                'sp_code'       => $sxz['sp_code'],
                'fee_id'        => $sxz['fee_id']
            );
        }
    }

    // POD服务费
    public function podFee() {
        $pod = Service_OtherFee::getByField('POD', 'fee_code');
        $cost = 0;  //成本
        $podFee = 0;  //费用
        $discount = 1;   /* 客户折扣，1=100% */
        if (!empty($pod)) {
            $customerFeeCondition = array(
                'customer_code' => $this->_paramsArray['orderInfo']['customer_code'],
                'fee_id' => $pod['fee_id']
            );
            $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');
            if ('1' == $pod['status']) {
                //杂费状态：可用
                if ($this->_paramsArray['orderInfo']['sm_code'] == '4PX-LYT_GH' && $this->_paramsArray['orderInfo']['is_pod'] == 1) {
                    $podFee = $pod['fee_value'];
                    $cost = $pod['fee_amount'];
                }
                if (!empty($customerOtherFee)) {
                    if ($customerOtherFee[0]['status'] == '1') {
                        //客户杂费可用，则参与打折计算
                        $podFee = $customerOtherFee[0]['discount'] * $podFee;
                        $discount = $customerOtherFee[0]['discount'];
                    }
                }else{
                       //非默认费用且该客户无此项杂费设置，则此项费用不收
                    if('0' == $pod['is_default_fee']){
                        $podFee  = 0;
                        $cost       = 0;
                    }
                }
            }
            $this->_dataArray['costArr']['otherFee']['pod'] = array(
                'cost_currency_code' => $pod['cost_currency_code'],
                'currency_code' => $pod['fee_currency_code'],
                'price' => $podFee,
                'discount' => $discount,
                'cost' => $cost,
                'sp_code' => $pod['sp_code'],
                'fee_id' => $pod['fee_id']
            );
        }
    }
     /**
     * @author yao
     * @todo 计算英国税金
     */
    private function duty4pxFeee(){
        $taxFee  = 0;
        $cost = 0;
        $discount = 1;    /* 客户折扣，1=100% */
        $tax = Service_OtherFee::getByField('4PX-DUTY', 'fee_code');
        if (!empty($tax)) {
                $smCode=$this->_paramsArray['orderInfo']['sm_code'];
                $orderAderss=Service_OrderAddressBook::getByField($this->_paramsArray['orderInfo']['order_code'],'order_code');
                //针对4PX-LYT_GH渠道和4PX-EU_PACKET渠道，发往英国的，其目的海关申报价值大于等于20美金的订单扣税费
            if($smCode=='4PX-LYT_GH'&& in_array($orderAderss['oab_country_id'],array('252','89'))
               ||$smCode=='4PX-EU_PACKET'){
            $customerFeeCondition = array(
                'customer_code' => $this->_paramsArray['orderInfo']['customer_code'],
                'fee_id'        => $tax['fee_id']
            );
            $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');
         
            if('1' == $tax['status']){
                //杂费状态：可用
                if($this->_paramsArray['orderProducts']){
                    $totalMony=0;
                    foreach($this->_paramsArray['orderProducts'] as $product){
                        $totalMony+=($product['op_purpose_declared_value']*$product['op_quantity']);
                    }
                    $totalMony=sprintf('%.2f',$totalMony);
                    if($totalMony>=20){
                        $taxFee=$totalMony*0.2;
                        $cost=$totalMony*0.2;
                        if(!empty($customerOtherFee)) {
                            if ($customerOtherFee[0]['status'] == '1') {
                                //客户杂费可用，则参与打折计算
                                $taxFee  = $customerOtherFee[0]['discount'] * $tax;
                                $discount   = $customerOtherFee[0]['discount'];
                            }
                        } else {
                            //非默认费用且该客户无此项杂费设置，则此项费用不收
                            if('0' == $guanli['is_default_fee']){
                                $taxFee  = 0;
                                $cost       = 0;
                            }
                        }
                    }  
                }
            }
            $this->_dataArray['costArr']['otherFee']['4pxduty'] = array(
                'currency_code' => $tax['fee_currency_code'],
                'price'         => $taxFee,
                'discount'      => $discount,
                'cost'          => $cost,
                'sp_code'       => $tax['sp_code'],
                'fee_id'        => $tax['fee_id']
            );
            }
        }
    }
    
    /**
     * [sanzuFee 散租费]
     * @return [type] [description]
     */
    private function sanzuFee(){
        $sanzuFee  = 0;
        $cost = 0;
        //客户折扣 1=100% 
        $discount = 1;   
        $sanzuRow = Service_OtherFee::getByField('SANZU', 'fee_code');
        if (!empty($sanzuRow) && array_key_exists('status', $sanzuRow) && $sanzuRow['status'] == '1') {
            $receivingCode  = $this->_paramsArray['receingInfo']['receiving_code'];
            $receivingRow   = $this->_paramsArray['receingInfo'];
            //集货
            if ($receivingRow['receive_model_type'] == 1) {
                $productWeight = Service_ReceivingOrderDetail::sumNetWeight($receivingCode);
            //备货
            }else {
                $productWeight = Service_ReceivingDetail::sumNetWeight($receivingCode);
            }
            if($productWeight > 0){
                //录入的重量来计费，RMB0.5 /KG。
                $sanzuFee = $productWeight * sprintf('%.2f', $sanzuRow['fee_value']);
                $cost = $productWeight * sprintf('%.2f', $sanzuRow['fee_amount']);
                $customerFeeCondition = array(
                    'customer_code' => $this->_paramsArray['receingInfo']['customer_code'],
                    'fee_id'        => $sanzuRow['fee_id']
                );
                $customerOtherFee = Service_CustomerOtherFee::getByCondition($customerFeeCondition, '*');
                //客户杂费可用，则参与打折计算
                if(!empty($customerOtherFee) && $customerOtherFee[0]['status'] == '1') {
                    $sanzuFee = $customerOtherFee[0]['discount'] * $sanzuFee;
                    $discount = $customerOtherFee[0]['discount'];
                }
                //非默认费用且该客户无此项杂费设置，则此项费用不收
                if($sanzuRow['is_default_fee'] == 0){
                    $sanzuFee = 0;
                    $cost = 0;
                }
            }
        }
        $this->_dataArray['costArr']['otherFee']['sanzu'] = array(
            'currency_code' => $sanzuRow['fee_currency_code'],
            'price'         => $sanzuFee,
            'discount'      => $discount,
            'cost'          => $cost,
            'sp_code'       => $sanzuRow['sp_code'],
            'fee_id'        => $sanzuRow['fee_id']
        );
    }
}