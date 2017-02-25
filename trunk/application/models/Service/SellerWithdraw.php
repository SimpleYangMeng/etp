<?php
class Service_SellerWithdraw extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_SellerWithdraw|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_SellerWithdraw();
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
    public static function update($row, $value, $field = "seller_withdraw_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "seller_withdraw_id")
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
    public static function getByField($value, $field = 'seller_withdraw_id', $colums = "*")
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
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();
        
        return  Common_Validator::formValidator($validateArr);
    }
    /**
     * @todo 国外提现验证
     */
    public static function validatorforeignwithdraw($val)
    {
        $validateArr = $error = array();
        $validateArr[] = array("name" =>EC::Lang('bankName'), "value" =>$val["bank_name"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('bankLocation'), "value" =>$val["country_id"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('bankCardName'), "value" =>$val["bank_buyer_name"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('bankCardNum'), "value" =>$val["bank_card"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('cashAmount'), "value" =>$val["amount"], "regex" => array('require', "positive1"));
        //$validateArr[] = array("name" =>EC::Lang('remark'), "value" =>$val["note"], "regex" => array('require'));
        return  Common_Validator::formValidator($validateArr);
    }

    /**
     * @todo 国内提现验证
     */
    public static function validatorinternalwithdraw($val)
    {
        $validateArr = $error = array();
        $validateArr[] = array("name" =>EC::Lang('bankName'), "value" =>$val["bank_name"], "regex" => array("require"));
        //$validateArr[] = array("name" =>EC::Lang('bankLocation'), "value" =>$val["country_id"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('bankCardName'), "value" =>$val["bank_buyer_name"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('bankCardNum'), "value" =>$val["bank_card"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('cashAmount'), "value" =>$val["amount"], "regex" => array('require', "positive1"));
        //$validateArr[] = array("name" =>EC::Lang('remark'), "value" =>$val["note"], "regex" => array('require'));
        return  Common_Validator::formValidator($validateArr);
    }
    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
            'E0' => 'seller_withdraw_id',
            'E1' => 'withdraw_code',
            'E2' => 'seller_id',
            'E3' => 'withdraw_type',
            'E4' => 'transaction_no',
            'E5' => 'status',
            'E6' => 'bank_name',
            'E7' => 'bank_code',
            'E8' => 'bank_card',
            'E9' => 'bank_buyer_name',
            'E10' => 'country_id',
            'E11' => 'currency',
            'E12' => 'amount',
            'E13' => 'note',
            'E14' => 'send_time',
            'E15' => 'add_time',
            'E16' => 'update_time',
        );
        return $row;
    }

}