<?php
class Service_Orders extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Orders|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Orders();
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
    public static function update($row, $value, $field = "order_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "order_id")
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
    public static function getByField($value, $field = 'order_id', $colums = "*")
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

    public static function joinOrderPay( $condition = array(), $type = '*', $columns = '*', $pageSize = 0, $page = 1, $order = "" ) {
        $model = self::getModelInstance();
        return $model->joinOrderPay($condition, $type, $columns, $pageSize, $page, $order);
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
            'E0' => 'order_id',
            'E1' => 'order_code',
            'E2' => 'plate_code',
            'E3' => 'reference_no',
            'E4' => 'buyer_id',
            'E5' => 'buyer_code',
            'E6' => 'seller_id',
            'E7' => 'seller_code',
            'E8' => 'warehouse_id',
            'E9' => 'order_currency',
            'E10' => 'order_status',
            'E11' => 'order_amount',
            'E12' => 'sm_code',
            'E13' => 'notify_url',
            'E14' => 'pay_status',
            'E15' => 'pay_currency',
            'E16' => 'pay_rate',
            'E17' => 'pay_amount',
            'E18' => 'pay_no',
            'E19' => 'note',
            'E20' => 'order_pay_id',
            'E21' => 'add_time',
            'E22' => 'update_time',
            'E23' => 'pay_time',
        );
        return $row;
    }

}