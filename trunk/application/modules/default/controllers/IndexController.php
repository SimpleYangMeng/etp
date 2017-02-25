<?php

class Default_IndexController extends Ec_Controller_DefaultAction
{

    public function preDispatch()
    {
        $this->view->errMsg = '';
        $this->tplDirectory = "default/views/default/";
    }

    public function indexAction()
    {
        Service_Login::isLogin();
        $session = Service_Login::getLoginInfo();
        if( $session['account_type'] == 1 ) {
            $this->_redirect('/buyer/portal');
        } else {
            $this->_redirect('/seller/portal');
        }
    	exit;
    }

    public function loginAction()
    {
        die('login');
    }

    public function logoutAction()
    {
        $session = new Zend_Session_Namespace('customerAuth');
        $session->unsetAll();
        session_destroy();
    }

    /*
     * @输出验证码
     */
    public function verifyCodeAction()
    {
        $verifyCode = new Common_Verifycode();
        $verifyCode->set_sess_name('AdminVerifyCode');
        echo $verifyCode->render();
    }

    /**
     * author william-fan
     * @todo 用于改变语言
     */
    public function changeLanguageAction(){
    	/*if($this->_request->isPost()){
    		$langCode = $this->_request->getParam('langCode');
    		if($langCode){
    			$sessionUser = new Zend_Session_Namespace("userAuthorization");
    			$sessionUser->lang = $langCode;
    			echo json_encode('1');
    			die();
    		}
    	}*/
        $language = trim( $this->_request->getParam('lang','zh_CN') );
        Ec_Lang::getInstance()->setLanguage( $language );
        //Service_Login::outLogin();
        echo "<script>location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
        exit;
    }
    public function headerInnerAction(){
        echo $this->view->render($this->tplDirectory . 'header-inner.tpl');
    }

    public function headerAction(){
        //$session			= new Zend_Session_Namespace('RegisterStep');
        //$session->step = '4';
        //$this->view->step = $session->step;
        echo $this->view->render($this->tplDirectory ."header.tpl");
    }

    /**
     * [enVisitNoticeAction description]
     *
     * @return [type] [description]
     */
    public function enVisitNoticeAction(){
        echo Ec::renderTpl($this->tplDirectory . "en_visit_notice.tpl", 'layout-etp');
    }
}