<?php
class Service_BuyerRecharge extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_BuyerRecharge|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_BuyerRecharge();
        }
        return self::$_modelClass;
    }

    /**
     * @param $row
     * @return mixed
     */
    public static function add($row)
    {
        $model = self::getModelInstance();
        return $model->add($row);
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function update($row, $value, $field = "buyer_recharge_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "buyer_recharge_id")
    {
        $model = self::getModelInstance();
        return $model->delete($value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public static function getByField($value, $field = 'buyer_recharge_id', $colums = "*")
    {
        $model = self::getModelInstance();
        return $model->getByField($value, $field, $colums);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        $model = self::getModelInstance();
        return $model->getAll();
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByCondition($condition, $type, $pageSize, $page, $order);
    }

    /**
     * [getByWhere 多条件获取]
     * @param  [type] $where  [description]
     * @param  string $colums [description]
     * @return [type]         [description]
     */
    public static function getByWhere($where, $colums = "*")
    {
        if(empty($where) || !is_array($where)){
            return false;
        }
        $model = self::getModelInstance();
        return $model->getByWhere($where, $colums);
    }

    /**
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();
        
        return  Common_Validator::formValidator($validateArr);
    }
    /**
     * @author william-fan
     * @todo 用于平安买家充值验证
     */
    public static function validatorRechargepa($val){
        $validateArr = $error = array();
        $validateArr[] = array("name" =>EC::Lang('buyer_id'), "value" =>$val["buyer_id"], "regex" => array("require",));
        $validateArr[] = array("name" =>EC::Lang('charge_type'), "value" =>$val["charge_type"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('RechargeNo'), "value" =>$val["recharge_code"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('FromBankCard'), "value" =>$val["charge_bank_card"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('chargeValue'), "value" =>$val["charge_value"], "regex" => array("require","positive1"));
        $validateArr[] = array("name" =>EC::Lang('charge_currency'), "value" =>$val["charge_currency"], "regex" => array("require"));
        //$validateArr[] = array("name" =>EC::Lang('note'), "value" =>$val["note"], "regex" => array("require"));
        return  Common_Validator::formValidator($validateArr);
    }

    /**
     * @author william-fan
     * @todo 用于平安买家充值验证
     */
    public static function validatorRechargezd($val){
        $validateArr = $error = array();
        $validateArr[] = array("name" =>EC::Lang('buyer_id'), "value" =>$val["buyer_id"], "regex" => array("require",));
        $validateArr[] = array("name" =>EC::Lang('charge_type'), "value" =>$val["charge_type"], "regex" => array("require"));
        /*$validateArr[] = array("name" =>EC::Lang('RechargeNo'), "value" =>$val["recharge_code"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('FromBankCard'), "value" =>$val["charge_bank_card"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('charge_value'), "value" =>$val["charge_value"], "regex" => array("require","positive1"));
        $validateArr[] = array("name" =>EC::Lang('charge_currency'), "value" =>$val["charge_currency"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('note'), "value" =>$val["note"], "regex" => array("require"));*/
        return  Common_Validator::formValidator($validateArr);
    }

    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
            'E0' => 'buyer_recharge_id',
            'E1' => 'buyer_id',
            'E2' => 'recharge_code',
            'E3' => 'charge_type',
            'E4' => 'status',
            'E5' => 'charge_bank_name',
            'E6' => 'charge_bank_card',
            'E7' => 'charge_bank_card_name',
            'E8' => 'charge_value',
            'E9' => 'actual_charge_value',
            'E10' => 'etp_poundage',
            'E11' => 'bank_poundage',
            'E12' => 'charge_currency',
            'E13' => 'request_file',
            'E14' => 'response_file',
            'E15' => 'deal_note',
            'E16' => 'deal_user',
            'E17' => 'note',
            'E18' => 'add_time',
            'E19' => 'update_time',
        );
        return $row;
    }

}