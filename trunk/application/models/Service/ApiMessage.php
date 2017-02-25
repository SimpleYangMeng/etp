<?php
class Service_ApiMessage extends Common_Service
{
	public function getBasePath() {

	}
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_IePort|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_ApiMessage();
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
    public static function update($row, $value, $field = "am_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "am_id")
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
    public static function getByField($value, $field = 'am_id', $colums = "*")
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
        
        $validateArr[] = array("name" =>EC::Lang('消息类型'), "value" =>$val["api_type"], "regex" => array("require",));
        $validateArr[] = array("name" =>EC::Lang('接口名称'), "value" =>$val["api_name"], "regex" => array("require",));
        return  Common_Validator::formValidator($validateArr);
    }


    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
            'E0'=>'am_id',
            'E1'=>'api_type',
            'E2'=>'api_name',
            'E3'=>'api_url',
            'E4'=>'refer_code',
            'E5'=>'module',
            'E6'=>'sub_module',
            'E7'=>'add_date',
            'E8'=>'paramer_request',
            'E9'=>'paramer_response',
            'E10'=>'am_message',
            'E11'=>'update_date',
        );
        return $row;
    }
    /**
     * @author william-fan
     * @todo 用于创建
     */
	public static function createApiMessageProcess($row,$type='order'){
        $jamobj = new Service_ApiMessage();


         //print_r($row);
		 return $jamobj->add($row);
	}
}