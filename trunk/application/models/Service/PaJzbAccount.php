<?php
class Service_PaJzbAccount extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_PaJzbAccount|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_PaJzbAccount();
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
    public static function update($row, $value, $field = "account_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "account_id")
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
    public static function getByField($value, $field = 'account_id', $colums = "*")
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
        if( isset( $val['seller_code'] ) ) {
            $validateArr[] = array("name" =>EC::Lang('seller_code'), "value" =>$val["seller_code"], "regex" => array("require",));
        }
        if( isset( $val['account_nick_name'] ) ) {
            $validateArr[] = array("name" =>EC::Lang('account_nick_name'), "value" =>$val["account_nick_name"], "regex" => array("require",));
        }
        if( isset( $val['account_phone_no'] ) ) {
            $validateArr[] = array("name" =>EC::Lang('account_phone_no'), "value" =>$val["account_phone_no"], "regex" => array("require",'cnMobilePhone'));
        }
        if( isset( $val['account_email'] ) ) {
            $validateArr[] = array("name" =>EC::Lang('account_email'), "value" =>$val["account_email"], "regex" => array("require",));
        }
        return  Common_Validator::formValidator($validateArr);
    }


    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
              'E0' => 'account_id',
              'E1' => 'buyer_id',
              'E2' => 'buyer_code',
              'E3' => 'operate_code',
              'E4' => 'bl_note',
              'E5' => 'add_time',
        );
        return $row;
    }

}