<?php
class Service_Warehouse
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Warehouse|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Warehouse();
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
    public static function update($row, $value, $field = "warehouse_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "warehouse_id")
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
    public static function getByField($value, $field = 'warehouse_id', $colums = "*")
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
        $validateArr[] = array("name" =>EC::Lang('warehouseCode'), "value" =>$val["warehouse_code"], "regex" => array("require","english",));
        $validateArr[] = array("name" =>EC::Lang('country'), "value" =>$val["country_id"], "regex" => array("require","integer",));
        $validateArr[] = array("name" =>EC::Lang('status'), "value" =>$val["warehouse_status"], "regex" => array("positive"));
        return  Common_Validator::formValidator($validateArr);
    }


    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
        
              'E0'=>'warehouse_id',
              'E1'=>'warehouse_code',
              'E2'=>'warehouse_status',
              'E3'=>'country_id',
              'E4'=>'state',
              'E5'=>'city',
              'E6'=>'contacter',
              'E7'=>'phone_no',
              'E8'=>'street_address1',
              'E9'=>'street_address2',
              'E10'=>'warehouse_desc',
              'E11'=>'warehouse_add_time',
              'E12'=>'warehouse_update_time',
        );
        return $row;
    }

}