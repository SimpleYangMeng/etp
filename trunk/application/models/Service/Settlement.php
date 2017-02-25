<?php
class Service_Settlement extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Settlement|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Settlement();
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
    public static function update($row, $value, $field = "settlement_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "settlement_id")
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
    public static function getByField($value, $field = 'settlement_id', $colums = "*")
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
     * @todo 结汇验证
     */
    public static function validatorSettlement($val)
    {
        $validateArr = $error = array();
        $validateArr[] = array("name" =>EC::Lang('sellerId'), "value" =>$val["seller_id"], "regex" => array("require"));
        $validateArr[] = array("name" =>EC::Lang('needsettlingValue'), "value" =>$val["needsettlingValue"], "regex" => array("require",'positive1'));

        return  Common_Validator::formValidator($validateArr);
    }

    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
            'E0'=>'settlement_id',
            'E1'=>'settlement_code',
            'E2'=>'status',
            'E3'=>'seller_id',
            'E4'=>'declare_comp_code',
            'E5'=>'declare_comp_name',
            'E6'=>'actual_settling_value',
            'E7'=>'actual_settling_currency',
            'E8'=>'settling_value',
            'E9'=>'settling_currency',
            'E10'=>'expect_settling_value',
            'E11'=>'expect_settling_currency',
            'E12'=>'handling_fee',
            'E13'=>'handling_fee_currency',
            'E14'=>'exchange_rate',
            'E15'=>'actual_exchange_rate',
            'E16'=>'note',
            'E17'=>'add_time',
            'E18'=>'update_time',
        );
        return $row;
    }

}