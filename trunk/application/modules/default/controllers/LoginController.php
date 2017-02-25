<?php
class Default_LoginController extends Ec_Controller_DefaultAction
{
	// --------------------------------------------------------------------
	public function preDispatch()
    {
        $this->tplDirectory	= "default/views/login/";
    }

    /**
     * 登陆首页
     *
     */
    public function indexAction()
    {
        $callbackurl = $this->getRequest()->getParam('callbackurl', '');
        if(!empty($callbackurl)){
            $callBackSession = new Zend_Session_Namespace('callbackurl');
            $callBackSession->callbackurl = $callbackurl;
        }
        $loginInfo  = Service_Login::getLoginInfo();
        if (empty($loginInfo['account_id'])) {
            $language = Ec_Lang::getInstance()->getCurrentLanguage();
            $language = empty($language) ? 'zh_CN' : $language;
            $this->view->language = $language;
            echo $this->view->render($this->tplDirectory . 'index.tpl');
        } else {
            $callBackSession = new Zend_Session_Namespace('callbackurl');
            if(!empty($callBackSession->callbackurl)){
                $this->_redirect($callBackSession->callbackurl);
            }else {
                if($loginInfo['account_type'] == 1){
                    $this->_redirect('/buyer/portal');
                }else {
                    $this->_redirect('/seller/portal');
                }
            }
        }
    }

    /**
     * [loginAction description]
     * @return [type] [description]
     */
    public function loginAction(){
        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        $language = empty($language) ? 'zh_CN' : $language;
        $this->view->language = $language;
        $loginInfo  = Service_Login::getLoginInfo();
        if (empty($loginInfo['account_id'])) {
            $this->view->visitor_type = $this->getRequest()->getParam('visitor_type', 1);
            echo $this->view->render($this->tplDirectory . 'index_login.tpl');
        } else {
            $callBackSession = new Zend_Session_Namespace('callbackurl');
            if(!empty($callBackSession->callbackurl)){
                $this->_redirect($callBackSession->callbackurl);
            }else {
                if($loginInfo['account_type'] == 1){
                    $this->_redirect('/buyer/portal');
                }else {
                    $this->_redirect('/seller/portal');
                }
            }
        }
    }

    /**
     * [checkAction 登陆检测]
     * @return [type] [description]
     */
	public function checkAction()
	{
		$verify	= new Common_Verifycode();
		$value	= $this->getRequest()->getParam('verify');
		//$state	= $verify->is_true($value);
        $state = true;
        $result = array();
		//if ($state) {
            $time = date('Y-m-d H:i:s');
            $name = trim($this->getRequest()->getParam('username', ''));
            $pwd = trim($this->getRequest()->getParam('password', ''));
            $accountType = trim($this->getRequest()->getParam('visitor_type', ''));
            $callBackUrl = trim($this->getRequest()->getParam('callBackUrl', ''));
            if(!empty($callBackUrl)) {
                $callBackSession = new Zend_Session_Namespace('callbackurl');
                $callBackSession->callbackurl = $callBackUrl;
            }
            $login = new Service_Login();
            $result = $login->check($name, $pwd , $accountType );
        /*
		} else {
            $result['ask'] = "0";
            $result['errorMsg'] = "验证码错误，请重新填写！";
            $result['authcodeError'] = 1;
		}
        */
        die(json_encode($result));
	}

	// --------------------------------------------------------------------
	/**
	 * 注销登陆
	 *
	 */
	public function outAction()
	{
		Service_Login::outLogin();
	}
	
	// --------------------------------------------------------------------
	/**
	 * 验证码
	 *
	 */
    public function verifyCodeAction()
    {
    	$verify	= new Common_Verifycode();    	
    	$verify->set_img_size(60,23);
    	echo $verify->render();
    }

}
/* End of file LoginController.php */
/* Location: /application/modules/default/controllers/LoginController.php */