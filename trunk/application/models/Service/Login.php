<?php
class Service_Login
{

	public static $_modelClass	= null;

    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass	= new Table_Customer();
        }
        return self::$_modelClass;
    }

    public static function add($row)
    {
        $model	= self::getModelInstance();
        return $model->add($row);
    }

    public static function update($row, $value, $field = "country_id")
    {
        $model	= self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    public static function delete($value, $field = "country_id")
    {
        $model	= self::getModelInstance();
        return $model->delete($value, $field);
    }

    public static function getAll()
    {
        $model	= self::getModelInstance();
        return $model->getAll();
    }

    /**
     * 获取自定义SQL语句查询结果
     *
     * @access	public
     * @param   string	($field		待返回的字段，默认为所有)
     * @param   string	($condition	查询条件)
     * @param	mixed	($value		待转换查询字段值)
     * @return	mixed
     */
    public static function getCustomQuery($field = '*', $condition = '', $value = '')
    {
    	$model	= self::getModelInstance();
    	return $model->getCustomQuery($field, $condition, $value);
    }

    /**
     * 检查登陆信息
     *
     * @param	string		($username	登陆账号)
     * @param	string		($password	账号密码)
     * @param  int          $accountType 账号类型 1采购商 2供应商
     * @return	mixed
     */
    public function check( $account, $password, $accountType)
    {
        $return = array( 'state'=>0, 'errorMsg'=>'' );
        //先检查是否设置吧语言，如果没有就设置
        if( false == Ec_Lang::getInstance()->hasSetLanguage() ) {
            //因为买家都是国外的
            if( $accountType == 1)
                Ec_Lang::getInstance()->setLanguage( 'en_US' );
            //卖家都是国内的
            else
                Ec_Lang::getInstance()->setLanguage( 'zh_CN' );
        }
        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        if( $accountType === '') {
            $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('userCode').Ec_Lang::getInstance()->getTranslate('type').Ec_Lang::getInstance()->getTranslate('require');
            return $return;
        } else if( !in_array( $accountType, array( 1, 2) ) ) {
            $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('userCode').Ec_Lang::getInstance()->getTranslate('type').Ec_Lang::getInstance()->getTranslate('error');
            return $return;
        }

        if( $account === '') {
            $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('UserName').Ec_Lang::getInstance()->getTranslate('require');
            return $return;
        }

        //对密码进行解密
        $password = Common_Common::pwdAlgorithm( $password );

        if( $password === '' ) {
            $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('userPass').Ec_Lang::getInstance()->getTranslate('require');
            return $return;
        }

        $accountInfo = array();
        //买家
        if( $accountType == 1 ) {
            $accountRow = Service_Buyer::getByField( $account, 'buyer_code' );
            if(empty($accountRow) || !is_array($accountRow)){
                $accountRow = Service_Buyer::getByField( $account, 'email');
            }
            if( empty( $accountRow ) || $accountRow['password'] != $password ) {
                $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('passwordError');
                return $return;
            }
            //未完成注册
            if ($accountRow['reg_step'] < 3) {
                $current        = $accountRow['reg_step'] + 1;
                $session        = new Zend_Session_Namespace('register');
                $session->data  = array(
                    'id' => $accountRow['buyer_id'],
                //  'username' => $accountInfo['account_name'],
                    'code' => $accountRow['buyer_code'],
                    'email' => $accountRow['email'],
                    'visitor_type' => $accountType,
                    'current'   => $current
                );
                $return['state'] = "-1";
                $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('unFinilished');
                $return['current'] = $current;
                $return['visitor_type'] = $accountType;
                return $return;
            }
            $status = Common_DataCache::getBusinessStatus('buyer', 'status', 1, 0, $language);
            if(!in_array($accountRow['status'], array(1, 4, 12))){
                $statusText = isset($status[$accountRow['status']]) ? $status[$accountRow['status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $return['errorMsg'] = sprintf(Ec_Lang::getInstance()->getTranslate('statusError'), $statusText);
                return $return;
            }
            $accountInfo = array(
                'account_id'        => $accountRow['buyer_id'],
                'account_code'      => $accountRow['buyer_code'],
                'account_type'      => $accountType,
                'account_name'      => $accountRow['buyer_name'],
                'email'              => $accountRow['email'],
                'status'             => $accountRow['status'],
                'is_active'         => $accountRow['is_active'],
                'reg_step'          => $accountRow['reg_step'],
                'currency'          => $accountRow['currency'],
                'last_login_time'  => $accountRow['login_time'],
                'has_pay_password' => !empty ( $accountRow['pay_password'] ) ? 1 : 0 ,//判断是否设置了支付密码
            );

            Service_Buyer::update(
                array( 'login_time' => date('Y-m-d H:i:s') ),
                $accountRow['buyer_id'],
                'buyer_id');

            //登陆日志
            $loginLog = array(
                'buyer_id' => $accountRow['buyer_id'],
                'buyer_code' => $accountRow['buyer_code'],
                'login_ip' => Common_Common::getRealIp(),
                'bl_note' => 'login',
                'add_time' => date('Y-m-d H:i:s')
            );
            Service_BuyerLoginLog::add($loginLog);

        } else if($accountType == 2 ){//卖家
            $accountRow = Service_Seller::getByField( $account, 'seller_code' );
            if(empty($accountRow) || !is_array($accountRow)){
                $accountRow = Service_Seller::getByField( $account, 'email');
            }
            if( empty( $accountRow ) || $accountRow['password'] != $password ) {
                $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('passwordError');
                return $return;
            }
            //未完成注册
            if ($accountRow['reg_step'] < 3) {
                $current        = $accountRow['reg_step'] + 1;
                $session        = new Zend_Session_Namespace('register');
                $session->data  = array(
                    'id' => $accountRow['seller_id'],
                //  'username' => $accountInfo['account_name'],
                    'code' => $accountRow['seller_code'],
                    'email' => $accountRow['email'],
                    'visitor_type' => $accountType,
                    'current'   => $current
                );
                $return['state'] = "-1";
                $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('unFinilished');
                $return['current'] = $current;
                $return['visitor_type'] = $accountType;
                return $return;
            }
            $status = Common_DataCache::getBusinessStatus('seller', 'status', 1, 0, $language);
            if(!in_array($accountRow['status'], array(1, 4, 8, 12))){
                $statusText = isset($status[$accountRow['status']]) ? $status[$accountRow['status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $return['errorMsg'] = sprintf(Ec_Lang::getInstance()->getTranslate('statusError'), $statusText);
                return $return;
            }
            $accountInfo = array(
                'account_id'        => $accountRow['seller_id'],
                'account_code'      => $accountRow['seller_code'],
                'account_type'      => $accountType,
                'account_name'      => $accountRow['seller_name'],
                'email'              => $accountRow['email'],
                'status'             => $accountRow['status'],
                'is_active'         => $accountRow['is_active'],
                'reg_step'          => $accountRow['reg_step'],
                'currency'          => $accountRow['currency'],
                'last_login_time'  => $accountRow['login_time'],
                'has_pay_password' => !empty ( $accountRow['pay_password'] ) ? 1 : 0 ,//判断是否设置了支付密码
            );

            Service_Seller::update(
                array( 'login_time' => date('Y-m-d H:i:s') ),
                $accountRow['seller_id'],
                'seller_id');

            //登陆日志
            $loginLog = array(
                'seller_id' => $accountRow['seller_id'],
                'seller_code' => $accountRow['seller_code'],
                'login_ip' => Common_Common::getRealIp(),
                'note' => 'login',
                'add_time' => date('Y-m-d H:i:s')
            );
            Service_SellerLoginLog::add($loginLog);
        }else {
            $return['errorMsg'] == Ec_Lang::getInstance()->getTranslate('paramsError');;
            return $return;
        }
        $return['callback'] = 0;
        $callBackSession = new Zend_Session_Namespace('callbackurl');
        if(!empty($callBackSession->callbackurl)){
            $return['callbackurl'] = urldecode($callBackSession->callbackurl);
            $return['callback'] = 1;
            $callBackSession->unsetAll();
        }
        /*
        if ($accountInfo['reg_step'] < 3) {
            $current        = $accountInfo['reg_step'] + 1;
            $session        = new Zend_Session_Namespace('register');
            $session->data  = array(
                'id' => $accountInfo['account_id'],
            //    'username' => $accountInfo['account_name'],
                'code' => $accountInfo['account_code'],
                'email' => $accountRow['email'],
                'visitor_type' => $accountType,
                'current'   => $current
            );
            $return['state'] = "-1";
            $return['errorMsg'] = Ec_Lang::getInstance()->getTranslate('unFinilished');
            $return['currenct'] = $current;
            $return['visitor_type'] = $accountType;
            return $return;
        }
        */
        //设置登录信息
        $this->setLoginInfo( $accountInfo );

        $return['state'] = 1;
        $return['jumpToUrl'] = $accountType == 1 ? '/buyer/portal' : '/seller/portal';
        $return['visitor_type'] = $accountType;
        $return['msg'] = Ec_Lang::getInstance()->getTranslate('success');
        return $return;
    }

    /**
     * 保存登陆信息
     *
     * @param	array		($accountInfo	账户信息)
     * @param	int			($keep		存储时间)
     * @return	void
     */
    protected function setLoginInfo( $accountInfo, $keep = FALSE)
    {
    	$session	= new Zend_Session_Namespace('customerAuth');
    	$session->account	= array(
    		'account_id'		      => $accountInfo['account_id'],
    		'account_code'		  => $accountInfo['account_code'],
    		'account_name'          => $accountInfo['account_name'],
            'account_type'          => $accountInfo['account_type'],
    		'email'	              => $accountInfo['email'],
    		'status'		          => $accountInfo['status'],
    		'is_active'	          => $accountInfo['is_active'],
    		'reg_step'	              => $accountInfo['reg_step'],
            'currency'              => $accountInfo['currency'],
            'last_login_time'      => $accountInfo['last_login_time'],
            'has_pay_password'     => $accountInfo['has_pay_password'],
    	);
    	if (!empty($keep)) {
    		$session->setExpirationSeconds($keep);
    	}
    }

    /**
     * 更新登陆信息
     *
     * @param	int			($id		账户ID)
     * @return	void
     */
    public static function updateLoginInfo($id)
    {
    	$data	= array(
    		'last_login_time'	=> date('Y-m-d H:i:s')
    	);
    	return self::update($data, $id, 'customer_id');
    }

    /**
     * 获取登陆信息
     *
     * @return	array
     */
	public static function getLoginInfo()
	{
		$session	= new Zend_Session_Namespace('customerAuth');
		return isset( $session->account ) &&  !empty( $session->account['account_id'] ) ? $session->account : null;
	}

	/**
	 * 登陆状态
	 *
	 * @return	void
	 */
	public static function isLogin($callBackUrl = '')
	{
		$info = self::getLoginInfo();
		if( empty( $info['account_id'] ) ){
			self::outLogin($callBackUrl);
            return false;
		}
        return true;
	}

	/**
	* 注销登陆
	*
	* @return	void
	*/
	public static function outLogin($callBackUrl = '')
	{
        $session = new Zend_Session_Namespace('customerAuth');
        $session->unsetAll();
        if(!empty($callBackUrl)){
            $callBackUrl = urlencode($callBackUrl);
            $goUrl = '/login?callbackurl='.$callBackUrl;
        }else {
            $goUrl = '/login';
        }
		//Zend_Session::destroy();
		die("<script>window.location.href='".$goUrl."';</script>");
	}

    /**
     * @todo 用于校验买家买家是否有权限
     */
    public static function checkPermissions($callBackUrl){
        $info = self::getLoginInfo();
        $denyurl ='/default/error/deny';
        if(!empty($info)){
            switch($info['account_type']){
                case '1':
                    //用数组，方便以后在加，万一不止一个的情况
                    $pox = array(
                        'buyer',
                        'portal',##修改密码用的是这个，公用的
                        'common'
                    );
                    //买家,都用buyer开头
                    $check = Common_Common::checkurl($callBackUrl,$pox);
                    if(!$check){
                        die("<script>window.location.href='".$denyurl."';</script>");
                    }
                    break;
                case '2':
                    //卖家都用seller开头
                    $pox = array(
                        'seller',
                        'portal',
                        'common'
                    );
                    $check = Common_Common::checkurl($callBackUrl,$pox);
                    if(!$check){
                        die("<script>window.location.href='".$denyurl."';</script>");
                    }
                    break;
                default:
                    die("<script>window.location.href='".$denyurl."';</script>");
            }
        }
    }
}