<?php
class Service_SellerBalanceLog extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_SellerBalanceLog|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_SellerBalanceLog();
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
    public static function update($row, $value, $field = "seller_balance_log_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "seller_balance_log_id")
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
    public static function getByField($value, $field = 'seller_balance_log_id', $colums = "*")
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
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
            'E0' => 'seller_balance_log_id',
            'E1' => 'reference_code',
            'E2' => 'seller_id',
            'E3' => 'sb_value',
            'E4' => 'sb_value_change',
            'E5' => 'sb_value_currency',
            'E6' => 'settling_value',
            'E7' => 'settling_value_change',
            'E8' => 'settling_done_value',
            'E9' => 'settling_done_value_change',
            'E10' => 'settling_hold_value',
            'E11' => 'settling_hold_value_change',
            'E12' => 'settling_currency',
            'E13' => 'foreign_value',
            'E14' => 'foreign_value_change',
            'E15' => 'foreign_hold_value',
            'E16' => 'foreign_hold_value_change',
            'E17' => 'foreign_value_currency',
            'E18' => 'foreign_withdraw_value',
            'E19' => 'foreign_withdraw_value_change',
            'E20' => 'internal_value',
            'E21' => 'internal_value_change',
            'E22' => 'internal_hold_value',
            'E23' => 'internal_hold_value_change',
            'E24' => 'internal_withdraw_value',
            'E25' => 'internal_withdraw_value_change',
            'E26' => 'internal_value_currency',
            'E27' => 'change_type',
            'E28' => 'add_time',
        );
        return $row;
    }

}