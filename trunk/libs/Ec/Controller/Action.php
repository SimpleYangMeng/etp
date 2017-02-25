<?php

class Ec_Controller_Action extends Zend_Controller_Action
{
    protected	$_customerAuth	= '';

    public function init()
    {
    	//$sessionId			= $this->getRequest()->getParam('session');
		//if (!empty($sessionId)) {
		//	Zend_Session::setId($sessionId);
		//}
    	$phpSessId = $this->getRequest()->getParam('PHPSESSID');
    	if (!empty($phpSessId)) {
    		Zend_Session::setId($phpSessId);
    	}
        $http = new Zend_Controller_Request_Http();
        $callBackUrl = $http->getRequestUri();
    	Service_Login::isLogin($callBackUrl);
        Service_Login::checkPermissions($callBackUrl);
    	$this->view			= Zend_Registry::get('EcView');
        $this->_customerAuth= Service_Login::getLoginInfo();
        $this->view->account = $this->_customerAuth;
        $this->view->accountName = $this->_customerAuth['account_code'];
        $this->view->lastLoginTime = $this->_customerAuth['last_login_time'];
        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        $this->language = empty( $language ) ? 'zh_CN' : $language;
    }

    /**
     * [__call description]
     *
     * @param  [type] $methodName [当不存在的方法时调用]
     * @param  [type] $args       [description]
     *
     * @return [type]             [description]
     */
    public function __call($methodName, $args)
    {
        //
        $error_handler = array(
            'error_type' => Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER,
        );
        $this->_forward('error', 'error', 'default', $error_handler);
    }
}