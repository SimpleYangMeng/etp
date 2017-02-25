<?php
/* @desc；账户管理器
 * @date:2016-10-27
 */
class Portal_AccountController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->tplDirectory = "portal/views/account/";
        $this->includeTplForLayout = "portal/views/default/";
        if( $this->_customerAuth['account_type'] == 1 ){
            $this->_layoutFile     = 'purchaser-left-widget';
            $this->_leftTpl = 'left_buyer.tpl';
        } else {
            $this->_layoutFile     = 'supplier-left-widget';
            $this->_leftTpl = 'left.tpl';
        }
    }

    /* @desc:完善用户资料
     *
     */
    public function editAccountInfoAction() {
        if( $this->_request->isPost() ) {
            $enterpriseName         = trim( $this->_request->getParam( 'companyName', '' ) );//企业名称
            $contacts               = trim( $this->_request->getParam( 'contacts', '' ) );//联系人
            $contactNumber          = trim( $this->_request->getParam( 'contactNumber', '' ) );//联系电话
            $email                  = trim( $this->_request->getParam( 'email', '' ) );//联系人邮箱
            $currency               = trim( $this->_request->getParam( 'currency', '' ) );//交易币种
            $blImg                  = trim( $this->_request->getParam( 'blImage', '' ) );//营业执照
            $cfImg                  = trim( $this->_request->getParam( 'cfImage', '' ) );//身份证正面
            $cbImg                  = trim( $this->_request->getParam( 'cbImage', '' ) );//身份证背面

            $params = array(
                'companyName'           => $enterpriseName,
                'contacts'               => $contacts,
                'contactNumber'         => $contactNumber,
                'email'                  => $email,
                'currency'               => $currency,
                'file'                   => array(
                                                'businessLicense'=>$blImg,
                                                'idCardFront'=>$cfImg,
                                                'idCardBack'=>$cbImg,
                                            )
            );

            $return = Service_AccountProcess::getInstance()->editAccountCompanyInfo( $params );
            die( json_encode( $return ) );
        }
        //获取企业资料
        $companyInfo = Service_AccountProcess::getInstance()->getCompanyInfo();

        $columns = array( 'currency_code', 'currency_name_en','currency_name');
        $currency = Service_Currency::getByCondition( array(), $columns );

        $imageRows = Service_CustomerAttach::getByCondition(
            array(
                'customer_id'              =>$this->_customerAuth['account_id'],
                'type'                      =>$this->_customerAuth['account_type'],
                'attach_img_type_array'  => array(1,2,3)
            )
        );
        $image = array();
        foreach( $imageRows as $value ) {
            $image[ $value['attach_img_type'] ] = $value['customer_attach_id'];
        }

        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_companyinfo';

        $this->view->companyInfo = $companyInfo;
        $this->view->currency = $currency;
        $this->view->image = $image;


        $template   = 'supplier_company_info_manage.tpl';

        echo Ec::renderTpl(
            $this->tplDirectory . $template,
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.$this->_leftTpl,
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
        exit;
    }

    /* @desc:设置密码
     *
     */
    public function paymentPasswordAction() {

        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        $language = empty($language) ? 'zh_CN' : $language;
        $this->view->languageTpl = $language;

        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_setppwd';
        $layoutObj->includeBs = true;

        $template = 'purchaser_update_pay_password.tpl';

        echo Ec::renderTpl(
            $this->tplDirectory . $template,
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.$this->_leftTpl,
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
        exit;
    }

    /* @desc:检查旧支付密码
     *
     */
    public function checkPwdAction() {
        $error = '';
        $checkPwd = trim( $this->_request->getParam('payPwd', ''));
        $checkPwd = Common_Common::pwdAlgorithm($checkPwd);
        if(empty($checkPwd)){
            $error = Ec_Lang::getInstance()->getTranslate('payPwd').Ec_Lang::getInstance()->getTranslate('require');
            die(json_encode(array('error'=>$error)));
        }
        switch ($this->_customerAuth['account_type']) {
            case '1':
                $oldPayPwd = Service_Buyer::getByField($this->_customerAuth['account_code'], 'buyer_code', array('pay_password'));
                $oldPwd = $oldPayPwd['pay_password'];
                break;
            case '2':
                $oldPayPwd = Service_Seller::getByField($this->_customerAuth['account_code'], 'seller_code', array('pay_password'));
                $oldPwd = $oldPayPwd['pay_password'];
                break;
            default:
                $oldPwd = '';
                break;
        }
        if(empty($oldPwd)){
            $error = Ec_Lang::getInstance()->getTranslate('payPwd').Ec_Lang::getInstance()->getTranslate('require');
            die(json_encode(array('error'=>$error)));
        }
        if(strcasecmp($checkPwd, $oldPwd)){
            $error = Ec_Lang::getInstance()->getTranslate('payPwd').Ec_Lang::getInstance()->getTranslate('error');
            die(json_encode(array('error'=>$error)));
        }
        die(json_encode(array('ok'=>Ec_Lang::getInstance()->getTranslate('success'))));
    }

    /**
     * [updatePayPwdAction 更新支付密码]
     *
     * @return [type] [description]
     */
    public function updatePayPwdAction() {
        $return = array( 'state'=>0, 'message'=>'' );
        $oldPwd = trim( $this->_request->getParam('oldPwd', ''));
        $newPwd = $this->getRequest()->getParam('newPwd', '');
        $reNewPwd = $this->getRequest()->getParam('reNewPwd', '');
        if(empty($newPwd) || empty($reNewPwd)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('newPassword').Ec_Lang::getInstance()->getTranslate('require');
            die(json_encode($return));
        }
        if(strcasecmp($newPwd, $reNewPwd)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('TwoPass');
            die(json_encode($return));
        }
        $oldPwd = Common_Common::pwdAlgorithm($oldPwd);
        $payPwd = Common_Common::pwdAlgorithm($newPwd);
        $data = array(
            'account_id' => $this->_customerAuth['account_id'],
            'oldPwd' => $oldPwd,
            'payPwd' => $payPwd
        );
        $maps = array(
            'oldPwd' => 'oldPassword',
            'payPwd' => 'newPassword'
        );
        switch ($this->_customerAuth['account_type']) {
            case '1':
                //$oldPayPwd = Service_Buyer::getByField($this->_customerAuth['account_code'], 'buyer_code', array('pay_password'));
                //$res = Service_Buyer::update(array('pay_password' => $payPwd), $this->_customerAuth['account_code'], 'buyer_code');
                $maps['account_id'] = 'buyerId';
                $apiObj = new Api_Buyer(array());
                $backUrl = '/portal/purchaser';
                break;
            case '2':
                //$oldPayPwd = Service_Seller::getByField($this->_customerAuth['account_code'], 'seller_code', array('pay_password'));
                //$res = Service_Seller::update(array('pay_password' => $payPwd), $this->_customerAuth['account_code'], 'seller_code');
                $maps['account_id'] = 'sellerId';
                $apiObj = new Api_Seller(array());
                $backUrl = '/portal/supplier';
                break;
        }
        $return = $apiObj->modifyPayPwd($data, $maps);
        /*
        if($res){
            $return['state'] = 1;
            $return['backUrl'] = $backUrl;
            $return['message'] = Ec_Lang::getInstance()->getTranslate('updateSuccessfully');
        }else {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('updateFailed');
        }
        */
        die(json_encode($return));
    }

    /**
     * [modifyLoginPwdAction 修改登录密码]
     *
     * @return [type] [description]
     */
    public function modifyLoginPwdAction(){
        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        $language = empty($language) ? 'zh_CN' : $language;
        $this->view->languageTpl = $language;
        echo Ec::renderTpl($this->tplDirectory . "modify_login_pwd.tpl",
            'purchaser-no-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
    }

    /**
     * [submitLoginPwd description]
     *
     * @return [type] [description]
     */
    public function submitLoginPwdAction(){
        $return = array( 'state'=>0, 'message'=>Ec_Lang::getInstance()->getTranslate('submit').Ec_Lang::getInstance()->getTranslate('fail'));
        $oldLoginPwd = $this->getRequest()->getParam('oldLoginPwd', '');
        $newLoginPwd = $this->getRequest()->getParam('newLoginPwd', '');
        $reLoginNewPwd = $this->getRequest()->getParam('reLoginPwd', '');
        if(empty($newLoginPwd) || empty($reLoginNewPwd)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('newLoginPwd').Ec_Lang::getInstance()->getTranslate('require');
            die(json_encode($return));
        }
        if(strcasecmp($newLoginPwd, $reLoginNewPwd)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('TwoPass');
            die(json_encode($return));
        }
        $data = array(
            'account_id' => $this->_customerAuth['account_id'],
            'oldLoginPwd' => Common_Common::pwdAlgorithm($oldLoginPwd),
            'newLoginPwd' => Common_Common::pwdAlgorithm($newLoginPwd),
            'reLoginPwd' => Common_Common::pwdAlgorithm($reLoginNewPwd),
        );

        $maps = array(
            'account_id' => 'buyerId',
            'oldLoginPwd' => 'oldPassword',
            'newLoginPwd' => 'newPassword'
        );
        // buyer
        if($this->_customerAuth['account_type'] == 1){
            $maps['account_id'] = 'buyerId';
            $apiObj = new Api_Buyer(array());
        //seller
        }else {
            $maps['account_id'] = 'sellerId';
            $apiObj = new Api_Seller(array());
        }
        $return = $apiObj->modifyLoginPwd($data, $maps);
        die(json_encode($return));
    }

    /**
     * [setLoginPwdSuccessAction description]
     */
    public function setLoginpwdSuccessAction (){
        $this->view->languageTpl = $this->language;
        $this->view->indexUrl = "/default/login/login?visitor_type={$this->_customerAuth['account_type']}";
        echo Ec::renderTpl($this->tplDirectory . "modify_loginpwd_success.tpl",
            'purchaser-no-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
    }
}