<?php
class Service_Buyer
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_Buyer|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_Buyer();
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
     * 取得客户登录信息
     *
     * @return Zend_Session_Namespace
     */
    public static function getLoginInfo ()
    {
        $sessionUser = new Zend_Session_Namespace("customerAuth");
        return $sessionUser;
    }
    /**
     * 设置客户登录信息
     *
     * @param boolean $isLogin
     * @param array $infos
     * @return void
     */
    public static function setLoginInfo ($isLogin, $customer = null)
    {
        $sessionUser = new Zend_Session_Namespace("customerAuth");
        $sessionUser->isLogin = $isLogin;
        if ($isLogin) {
            /*
             * customer对应数据表customer的数据
            */
            Merchant_Service_Customer::update(array('login_time'=>date('Y-m-d H:i:s')), $customer['buyer_id'], 'buyer_id');
            $sessionUser->customer = $customer;
            $sessionUser->lang = "1"; // 临时处理
        } else {
            if (isset($sessionUser->customer)){
                unset($sessionUser->customer);
            }
        }
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function update($row, $value, $field = "buyer_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "buyer_id")
    {
        $model = self::getModelInstance();
        return $model->delete($value, $field);
    }
    
    /**
     * 共享锁记录
     * @author solar
     * @param int $buyer_id
     * @return array
     */
    public static function getLockInShareMode($buyer_id) {
      $model = self::getModelInstance();
      return $model->getLockInShareMode($buyer_id);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public static function getByField($value, $field = 'buyer_id', $colums = "*")
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
     * 获取自定义SQL语句查询结果
     *
     * @access  public
     * @param   string  ($field   待返回的字段，默认为所有)
     * @param   string  ($condition 查询条件)
     * @param mixed ($value   待转换查询字段值)
     * @return  mixed
     */
    public static function getCustomQuery($field = '*', $condition = '', $value = '')
    {
      $model = self::getModelInstance();
      return $model->getCustomQuery($field, $condition, $value);
    }

    public static function  getCustomerByShortCode($customer_short){
        $model = self::getModelInstance();
        return $model->getCustomerByShortCode($customer_short);
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
    /*
     * 判断是否是服务商账号登陆
     */
     public static function checkIsService(){
       $loginInfo= self::getLoginInfo();
        return $loginInfo->data['customer_type']?true:false;
    }

    /**
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();
        $validateArr[] = array("name" =>EC::Lang('email'), "value" =>$val["customer_email"], "regex" => array("require",));
        $validateArr[] = array("name" =>EC::Lang('status'), "value" =>$val["customer_status"], "regex" => array("positive"));
        $validateArr[] = array("name" =>EC::Lang('salesRep'), "value" =>$val["customer_saler_user_id"], "regex" => array("positive"));
        $validateArr[] = array("name" =>EC::Lang('customerServiceRep'), "value" =>$val["customer_cser_user_id"], "regex" => array("positive"));
        return  Common_Validator::formValidator($validateArr);
    }

    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
        
              'E0'=>'buyer_id',
              'E1'=>'buyer_code',
              'E2'=>'buyer_name',
              'E3'=>'password',
              'E4'=>'pay_password',
              'E5'=>'email',
              'E6'=>'type',
              'E7'=>'status',
              'E8'=>'zd_card_assign',
              'E9'=>'activate_code',
              'E10'=>'company_name',
              'E11'=>'register_address',
              'E12'=>'contact_name',
              'E13'=>'contact_telphone',
              'E14'=>'currency',
              'E15'=>'add_time',
              'E16'=>'update_time',
              'E17'=>'login_time',
              'E18'=>'verify_code',
              'E19'=>'verify_time',
        );
        return $row;
    }

}