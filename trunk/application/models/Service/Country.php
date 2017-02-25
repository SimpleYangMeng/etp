<?php
class Service_Country extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Country|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Country();
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
    public static function update($row, $value, $field = "country_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "country_id")
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
    public static function getByField($value, $field = 'country_id', $colums = "*")
    {
        $model = self::getModelInstance();
        return $model->getByField($value, $field, $colums);
    }
    /**
     * 获取自定义SQL语句查询结果
     *
     * @access  public
     * @param   string  ($field     待返回的字段，默认为所有)
     * @param   string  ($condition 查询条件)
     * @param   mixed   ($value     待转换查询字段值)
     * @return  mixed
     */
    public static function getCustomQuery($field = '*', $condition = '', $value = '')
    {
        $model = self::getModelInstance();
        return $model->getCustomQuery($field, $condition, $value);
    }

    /**
     * @author william-fan
     * @todo 两种币种转化
     */
    public static function converByCode($code_start,$code_end,$value){
        if($code_start == '' || $code_end == '' || $value == ''){
            return 0;
        }
        if($code_start == $code_end){
            return $value;
        }
        $row_start = self::getByField($code_start,'currency_code');
        $row_end = self::getByField($code_end,'currency_code');
        if(empty($row_start) || empty($row_end)){
            return 0;
        }
        $transValue = ($value*$row_start['currency_rate'])/$row_end['currency_rate'];
        return sprintf('%.2f',$transValue);
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
              'E0' => 'country_id',
              'E1' => 'country_name',
              'E2' => 'country_name_en',
              'E3' => 'country_local_name',
              'E4' => 'country_alias',
              'E5' => 'country_code',
              'E6' => 'country_sort',
              'E7' => 'country_short_name',
              'E8' => 'trade_country',
              'E9' => 'country_area',
        );
        return $row;
    }

}