<?php
/* @desc；账户管理器
 * @date:2016-10-27
 */
class Seller_AccountController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->tplDirectory = "seller/views/account/";

        $this->_layoutObj           = Zend_Registry::get('layout');
        $this->_layoutFile          = 'supplier-left-widget';

        $this->_topTpl              = 'seller/views/layout/top.tpl';
        $this->_innerHeaderTpl      = 'seller/views/layout/header-inner.tpl';
        $this->_footerTpl           = 'seller/views/layout/footer.tpl';
        $this->_leftTpl             = 'seller/views/layout/left.tpl';
    }

    /* @desc:完善用户资料
     *
     */
    public function editAccountInfoAction() {

        if( $this->_request->isPost() ) {
            $enterpriseName         = trim( $this->_request->getParam( 'companyName', '' ) );//企业名称
            $address                = trim( $this->_request->getParam( 'address', '' ) );//地址
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
                'register_address'                => $address,
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
        $currency = Common_DataCache::getCurrencyMaps( 'USD' );

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
        $this->_layoutObj->activeMenu = 'menu_companyinfo';

        $this->view->companyInfo = $companyInfo;
        $this->view->currency = !empty( $currency ) ? array( $currency ) : array() ;
        $this->view->image = $image;

        $isAllowEdit = in_array($this->_customerAuth['status'], array('12')) ? 0 : 1;
        $this->view->isAllowEdit = $isAllowEdit;
        if(!$isAllowEdit){
            $status = Common_DataCache::getBusinessStatus('seller', 'status', 1, 0, $this->language);
            $statusText = isset($status[$this->_customerAuth['status']]) ? $status[$this->_customerAuth['status']] : Ec_Lang::getInstance()->getTranslate('undefine');
            $this->view->notAllowEditNotice = sprintf(Ec_Lang::getInstance()->getTranslate('statusError'), $statusText);
        }

        $template   = 'supplier_company_info_manage.tpl';

        echo Ec::renderTpl(
            $this->tplDirectory . $template,
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'left'          => $this->_leftTpl,
                'footer'        => $this->_footerTpl,
            )
        );
        exit;
    }

    /**
     * [setPaypwdNoticeAction description]
     */
    public function setPaypwdNoticeAction(){
        echo Ec::renderTpl($this->tplDirectory . "set_paypwd_notice.tpl",
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
            )
        );
    }

    /**
     * [setPaypwdAction 设置支付密码]
     */
    public function setPaypwdAction() {
        echo Ec::renderTpl($this->tplDirectory . "set_paypwd.tpl",
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
            )
        );
    }

    /**
     * [doSetPaypwdAction 设置支付密码]
     * @return [type] [description]
     */
    public function doSetPaypwdAction () {
        $return = array( 'state'=>0, 'message'=>'' );
        $payPwd = $this->getRequest()->getParam('payPwd', '');
        $rePwd = $this->getRequest()->getParam('rePwd', '');
        if(empty($payPwd) || empty($rePwd)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('payPwd').Ec_Lang::getInstance()->getTranslate('require');
            die(json_encode($return));
        }
        if(strcasecmp($payPwd, $rePwd)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('TwoPass');
            die(json_encode($return));
        }
        $payPwd = Common_Common::pwdAlgorithm($payPwd);
        $res = Service_Seller::update(array('pay_password' => $payPwd), $this->_customerAuth['account_code'], 'seller_code');
        $backUrl = '/seller/portal';
        if($res){
            $return['state'] = 1;
            //$return['backUrl'] = '/portal/purchaser';
            $return['message'] = Ec_Lang::getInstance()->getTranslate('updateSuccessfully');
        }else {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('updateFailed');
        }
        die(json_encode($return));
    }

    /**
     * [setSuccessAction 设置成功跳转]
     */
    public function setPaypwdSuccessAction () {
        //二次验证
        $buyerPayPassword = Service_Seller::getByField($this->_customerAuth['account_code'], 'seller_code', array('pay_password'));
        if(!empty($buyerPayPassword['pay_password'])){
            $session = new Zend_Session_Namespace('customerAuth');
            $session->account['has_pay_password'] = 1;
        }else {
            $this->_redirect('/seller/account/set-paypwd-notice');
            exit;
        }
        $this->view->indexUrl = '/seller/portal';
        echo Ec::renderTpl($this->tplDirectory . "set_paypwd_success.tpl",
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
            )
        );
    }

    /* @desc:设置密码
     *
     */
    public function paymentPasswordAction() {

        $this->_layoutObj->activeMenu = 'menu_setppwd';
        $this->_layoutObj->includeBs = true;

        $template = 'update_pay_password.tpl';

        echo Ec::renderTpl(
            $this->tplDirectory . $template,
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'left'          => $this->_leftTpl,
                'footer'        => $this->_footerTpl,
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
            $error = Ec_Lang::getInstance()->getTranslate('oldPpwdRequired');
            die(json_encode(array('error'=>$error)));
        }
        $oldPayPwd = Service_Seller::getByField($this->_customerAuth['account_code'], 'seller_code', array('pay_password'));
        $oldPwd = $oldPayPwd['pay_password'];
        if(empty($oldPwd)){
            $error = Ec_Lang::getInstance()->getTranslate('oldPpwdRequired');
            die(json_encode(array('error'=>$error)));
        }
        if(strcasecmp($checkPwd, $oldPwd)){
            $error = Ec_Lang::getInstance()->getTranslate('pPwdIsWrong');
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
        $oldPwd = trim( $this->_request->getParam('payPwd', ''));
        $newPwd = $this->getRequest()->getParam('newPwd', '');
        $reNewPwd = $this->getRequest()->getParam('reNewPwd', '');
        if(empty($newPwd) || empty($reNewPwd)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('newPpwdRequired');
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
        //$oldPayPwd = Service_Seller::getByField($this->_customerAuth['account_code'], 'seller_code', array('pay_password'));
        //$res = Service_Seller::update(array('pay_password' => $payPwd), $this->_customerAuth['account_code'], 'seller_code');
        $maps['account_id'] = 'sellerId';
        $apiObj = new Api_Seller(array());
        $backUrl = '/seller/portal';
        $return = $apiObj->modifyPayPwd($data, $maps);
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
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
            )
        );
    }

    /**
     * [submitLoginPwd description]
     *
     * @return [type] [description]
     */
    public function submitLoginPwdAction(){
        $return = array( 'state'=>0, 'message'=> Ec_Lang::getInstance()->getTranslate('fail'));
        $oldLoginPwd = $this->getRequest()->getParam('oldLoginPwd', '');
        $newLoginPwd = $this->getRequest()->getParam('newLoginPwd', '');
        $reLoginNewPwd = $this->getRequest()->getParam('reLoginPwd', '');
        if(empty($newLoginPwd) || empty($reLoginNewPwd)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('newLoginPwdRequired');
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
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
            )
        );
    }
}