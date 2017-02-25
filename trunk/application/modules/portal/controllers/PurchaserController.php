<?php
/* @desc；采购商控制器
 * @date:2016-10-27
 */
class Portal_PurchaserController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "portal/views/purchaser/";
        $this->includeTplForLayout = "portal/views/default/";
        if( $this->_customerAuth['account_type'] != 1 ) {
            $this->_redirect('/portal/supplier');
            exit;
        }
    }

    /* @desc:采购商登录后的首页
     *
     */
    public function indexAction() {
        if(!$this->_customerAuth['has_pay_password']){
            $this->_redirect('/portal/purchaser/set-paypwd-notice');
            exit;
        }
        $purchaserBalance = Service_BuyerBalance::getByField($this->_customerAuth['account_id'], 'buyer_id', array('cb_value'));
        //当日
        $incomeToday = Service_BuyerRecharge::getByCondition(array(
            'buyer_id' => $this->_customerAuth['account_id'],
            'status' => 5,
            'add_time_start' => date('Y-m-d 00:00:00'),
            'add_time_end' => date('Y-m-d 23:59:59'),
        ), array('sum(`actual_charge_value`) as income_today'));
        //当月
        $incomeCurrentMonth = Service_BuyerRecharge::getByCondition(array(
            'buyer_id' => $this->_customerAuth['account_id'],
            'status' => 5,
            'add_time_start' => date('Y-m-01 00:00:00'),
            'add_time_end' => date('Y-m-d 23:59:59'),
        ), array('sum(`actual_charge_value`) as income_month'));

        $this->view->incomeToday = empty($incomeToday[0]['income_today']) ? '0.0000' : $incomeToday[0]['income_today'];
        $this->view->incomeMonth = empty($incomeCurrentMonth[0]['income_month']) ? '0.0000' : $incomeCurrentMonth[0]['income_month'];
        $this->view->bBalance = empty($purchaserBalance['cb_value']) ? '0.0000' : $purchaserBalance['cb_value'];

        echo Ec::renderTpl(
            $this->tplDirectory . 'home.tpl',
            'purchaser-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.'left_buyer.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
        exit;
    }

    /**
     * [purchaserDetailAction 买家详情]
     *
     * @return [type] [description]
     */
    public function purchaserDetailAction() {
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->includeBsPage = true;
        $layoutObj->activeMenu = 'menu_purchaser_detail';
        $activeStatus = Common_DataCache::getBusinessStatus('buyer', 'is_active', 1, 0, $this->language);
        $status = Common_DataCache::getBusinessStatus('buyer', 'status', 1, 0, $this->language);
        $buyerRow = Service_Buyer::getByField($this->_customerAuth['account_id'], 'buyer_id');
        $buyerRow['is_active_text'] = isset($activeStatus[$buyerRow['is_active']]) ? $activeStatus[$buyerRow['is_active']] : Ec_Lang::getInstance()->getTranslate('nodefined');
        $buyerRow['status_text'] = isset($status[$buyerRow['status']]) ? $status[$buyerRow['status']] : Ec_Lang::getInstance()->getTranslate('nodefined');
        $this->view->loginLog = Service_BuyerLoginLog::getByCondition(array('buyer_id'=>$buyerRow['buyer_id']));
        $this->view->zdAccounts = Service_BuyerBankCardAssign::getByCondition(array('buyer_id'=>$buyerRow['buyer_id']));
        $this->view->buerRow = $buyerRow;
        echo Ec::renderTpl(
            $this->tplDirectory . 'detail.tpl',
            'purchaser-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.'left_buyer.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
        exit;
    }

    /**
     * [getPurchaserLogAction 买家日志]
     *
     * @return [type] [description]
     */
    public function getPurchaserLogAction(){
        $condition = $this->_request->getParam('condition', array());
        $page = $this->_request->getParam('page', 1);
        $pageSize = $this->_request->getParam('pageSize', 10);
        $page = $page ? $page : 1;
        $pageSize = $pageSize ? $pageSize : 10;
        $condition['buyer_id'] = $this->_customerAuth['account_id'];
        $count = Service_BuyerLog::getByCondition($condition, 'count(*)');
        if($count){
            $pageTotal = ceil($count / $pageSize);
            $showFields=array(
                'buyer_id',
                'operate_code',
                'bl_note',
                'add_time'
            );
            $rows = Service_BuyerLog::getByCondition($condition,$showFields, $pageSize, $page, array('buyer_log_id desc'));
            foreach ($rows as $key => $value) {
                $rows[$key]['operate_code'] = $value['operate_code'] == 0 ? 'system' : $value['operate_code'];
            }
            $return['data'] = $rows;
            $return['state'] = 1;
            $return['pageTotal'] = $pageTotal;
        }
        $return['total'] = $count;
        die(Zend_Json::encode($return));
    }
    /**
     * [rechargeListAction 充值明细查询]
     *
     * @return [type] [description]
     */
    /*
    public function rechargeListAction () {
        $status = Common_DataCache::getBusinessStatus('buyer_recharge', 'status', 1, 0, $this->language);
        $chargeType = Common_DataCache::getBusinessStatus('buyer_recharge', 'charge_type', 1, 0, $this->language);
        //请求数据
        if ($this->_request->isPost()) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['buyer_id'] = $this->_customerAuth['account_id'];
            $count = Service_BuyerRecharge::getByCondition($condition, 'count(*)');
            if($count){
                $pageTotal = ceil($count / $pageSize);
                $showFields=array(
                    'buyer_recharge_id',
                    'recharge_code',
                    'charge_type',
                    'charge_bank_name',
                    'charge_bank_card',
                    'charge_bank_card_name',
                    'charge_value',
                    'actual_charge_value',
                    'charge_currency',
                    'add_time',
                );
                $rows = Service_BuyerRecharge::getByCondition($condition, $showFields, $pageSize, $page, array('buyer_recharge_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['status'] = $status;
                $return['chargeType'] = $chargeType;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }

        $this->view->languageTpl = $this->language;
        $this->view->chargeType = $chargeType;
        $this->view->status = $status;
        //菜单样式
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_recharge_list';

        echo Ec::renderTpl(
            $this->tplDirectory . 'recharge_list.tpl',
            'purchaser-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.'left_buyer.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
    }
    */
    /**
     * [rechargeDetailAction 充值详情]
     *
     * @return [type] [description]
     */
    /*
    public function rechargeDetailAction(){
        $return = array('state'=>0, 'data'=> '', 'message'=> '');
        $status = Common_DataCache::getBusinessStatus('buyer_recharge', 'status', 1, 0, $this->language);
        $chargeType = Common_DataCache::getBusinessStatus('buyer_recharge', 'charge_type', 1, 0, $this->language);
        $buyerRechargeId = $this->_request->getParam('parmId', 0);
        if(!empty($buyerRechargeId)){
            $buyerRechargeRow = Service_BuyerRecharge::getByField($buyerRechargeId, 'buyer_recharge_id');
            if(!empty($buyerRechargeRow)){
                $return['state'] = 1;
                $buyerRechargeRow['status_text'] = isset($status[$buyerRechargeRow['status']]) ? $status[$buyerRechargeRow['status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $buyerRechargeRow['charge_type_text'] = isset($chargeType[$buyerRechargeRow['charge_type']]) ? $chargeType[$buyerRechargeRow['charge_type']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $return['data'] = $buyerRechargeRow;
            }else {
                $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            }
        }else {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        //菜单样式
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_recharge_list';
        $this->view->return = $return;
        echo Ec::renderTpl(
            $this->tplDirectory . 'recharge_detail.tpl',
            'purchaser-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.'left_buyer.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
    }
    */
    /**
     * [setPaypwdNoticeAction description]
     */
    public function setPaypwdNoticeAction(){
        $this->view->languageTpl = $this->language;
        echo Ec::renderTpl($this->tplDirectory . "set_paypwd_notice.tpl",
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
     * [setPaypwdAction 设置支付密码]
     */
    public function setPaypwdAction() {
        $this->view->languageTpl = $this->language;
        echo Ec::renderTpl($this->tplDirectory . "set_paypwd.tpl",
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
        $res = Service_Buyer::update(array('pay_password' => $payPwd), $this->_customerAuth['account_code'], 'buyer_code');
        switch ($this->_customerAuth['account_type']) {
            case '1':
                //$oldPayPwd = Service_Buyer::getByField($this->_customerAuth['account_code'], 'buyer_code', array('pay_password'));
                $res = Service_Buyer::update(array('pay_password' => $payPwd), $this->_customerAuth['account_code'], 'buyer_code');
                $backUrl = '/portal/purchaser';
                break;
            case '2':
                //$oldPayPwd = Service_Seller::getByField($this->_customerAuth['account_code'], 'seller_code', array('pay_password'));
                $res = Service_Seller::update(array('pay_password' => $payPwd), $this->_customerAuth['account_code'], 'seller_code');
                $backUrl = '/portal/supplier';
                break;
            default:
                $res = false;
                break;
        }
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
        $buyerPayPassword = Service_Buyer::getByField($this->_customerAuth['account_code'], 'buyer_code', array('pay_password'));
        if(!empty($buyerPayPassword['pay_password'])){
            $session = new Zend_Session_Namespace('customerAuth');
            $session->account['has_pay_password'] = 1;
        }else {
            $this->_redirect('/portal/purchaser/set-paypwd-notice');
            exit;
        }
        $this->view->languageTpl = $this->language;
        $this->view->indexUrl = '/portal/purchaser';
        echo Ec::renderTpl($this->tplDirectory . "set_paypwd_success.tpl",
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
     * [foreignCashAction 申请境外提现]
     * @return [type] [description]
     */
    public function foreignCashAction(){
        if(!$this->_customerAuth['has_pay_password']){
            $this->_redirect('/portal/purchaser/set-paypwd-notice');
            exit;
        }
        $this->view->languageTpl = $this->language;
        $this->view->country = Common_DataCache::getCountry();
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_cash';
        $purchaserBalance = Service_BuyerBalance::getByField($this->_customerAuth['account_id'], 'buyer_id', array('cb_value'));
        $this->view->currency = $this->_customerAuth['currency'];
        $this->view->cBalance = $purchaserBalance['cb_value'];
        echo Ec::renderTpl(
            $this->tplDirectory . 'foreign_cash.tpl',
            'purchaser-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.'left_buyer.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
    }

    /**
     * [cashSubmitAction 提交申请]
     *
     * @return [type] [description]
     */
    public function cashSubmitAction(){
        $return = array('state'=>0, 'message' => Ec_Lang::getInstance()->getTranslate('appOWithdraw').Ec_Lang::getInstance()->getTranslate('fail'), 'error'=>array());
        $data = $this->getRequest()->getParam('data', '');
        $errorArr = Service_BuyerWithdraw::validator($data);
        if (!empty($errorArr)) {
            $return['error'] = Common_EtpCommon::transErrors($errorArr);
            die(Zend_Json::encode($return));
        }
        $data['visitor_type'] = $this->_customerAuth['account_type'];
        $data['account_id'] = $this->_customerAuth['account_id'];
        $data['withdraw_code'] = Common_GetNumbers::getCode('buyer_withdraw', 10, 'BW', '提现申请流水号');
        //买家默认境外 提现区域：境内1，境外2
        $data['areaType'] = 1;
        $data['currency'] = 'USD';

        $maps = array(
            'visitor_type' => 'userType',
            'areaType' => 'areaType',
            'account_id' => 'userId',
            'bank_card'=>'bankCardNo',
            'bank_name'=>'bankName',
            'bank_buyer_name'=>'bankCustomerName',
            'country_id'=>'countryId',
            'withdraw_code' => 'withdrawCode',
            'currency' => 'currency',
            'amount'=>'amount',
            'note'=>'note'
        );
        $apiObj = new Api_Withdraw(array());
        $return = $apiObj->apply($data, $maps);
        if($return['state'] == 1){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('appOWithdraw').Ec_Lang::getInstance()->getTranslate('success');
        }
        die(Zend_Json::encode($return));
    }

    /**
     * [cashListAction 结汇申请列表-->purchaser-withdraw-record]
     * @return [type] [description]
     */
    public function cashListAction(){
        $cashStatus = Common_DataCache::getBusinessStatus('buyer_withdraw', 'status', 1, 0, $this->language);
        $cashType = Common_DataCache::getBusinessStatus('buyer_withdraw', 'cash_type', 1, 0, $this->language);
        //请求数据
        if ($this->_request->isPost()) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['buyer_id'] = $this->_customerAuth['account_id'];
            $count = Service_BuyerWithdraw::getByCondition($condition, 'count(*)');
            if($count){
                $pageTotal = ceil($count / $pageSize);
                $showFields=array(
                    'buyer_withdraw_id',
                    'withdraw_code',
                    'status',
                    'bank_name',
                    'bank_card',
                    'bank_buyer_name',
                    'currency',
                    'amount',
                    'add_time',
                );
                $rows = Service_BuyerWithdraw::getByCondition($condition,$showFields, $pageSize, $page, array('buyer_withdraw_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['cashStatus'] = $cashStatus;
                $return['cashType'] = $cashType;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }

        $this->view->languageTpl = $this->language;
        $this->view->cashType = $cashType;
        $this->view->cashStatus = $cashStatus;
        //菜单样式
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_cash_list';
        $layoutObj->includeBsPage = true;
        $layoutObj->includeBsDate = true;

        echo Ec::renderTpl(
            $this->tplDirectory . 'foreign_cash_list.tpl',
            'purchaser-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.'left_buyer.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
    }

    /**
     * [cashViewAction 显示提现详情 - dialog]
     *
     * @return [type] [description]
     */
    public function cashViewAction(){
        $return = array('state'=>0, 'data'=> '', 'message'=> '');
        $cashStatus = Common_DataCache::getBusinessStatus('buyer_withdraw', 'status', 1, 0, $this->language);
        $buyer_withdraw_id = $this->_request->getParam('buyer_withdraw_id', 0);
        if(!empty($buyer_withdraw_id)){
            $buyer_withdraw_row = Service_BuyerWithdraw::getByField($buyer_withdraw_id, 'buyer_withdraw_id');
            if(!empty($buyer_withdraw_row)){
                $return['state'] = 1;
                $buyer_withdraw_row['status_text'] = isset($cashStatus[$buyer_withdraw_row['status']]) ? $cashStatus[$buyer_withdraw_row['status']] : Ec_Lang::getInstance()->getTranslate('undefine');;
                $return['data'] = $buyer_withdraw_row;
            }else {
                $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            }
        }else {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        die(Zend_Json::encode($return));
    }

    /**
     * [cashViewDetailAction 跳转显示详情]
     *
     * @return [type] [description]
     */
    public function cashViewDetailAction(){
        $return = array('state'=>0, 'data'=> '', 'message'=> '');
        $cashStatus = Common_DataCache::getBusinessStatus('buyer_withdraw', 'status', 1, 0, $this->language);
        $buyer_withdraw_id = $this->_request->getParam('parmId', 0);
        if(!empty($buyer_withdraw_id)){
            $buyer_withdraw_row = Service_BuyerWithdraw::getByField($buyer_withdraw_id, 'buyer_withdraw_id');
            if(!empty($buyer_withdraw_row)){
                $return['state'] = 1;
                $buyer_withdraw_row['status_text'] = isset($cashStatus[$buyer_withdraw_row['status']]) ? $cashStatus[$buyer_withdraw_row['status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $return['data'] = $buyer_withdraw_row;
            }else {
                $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            }
        }else {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        //菜单样式
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_cash_list';
        $this->view->return = $return;
        echo Ec::renderTpl(
            $this->tplDirectory . 'foreign_cash_view_detail.tpl',
            'purchaser-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.'left_buyer.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
    }
    /* PurchaserController.php 买家相关控制器
     * SupplierController.php 卖家相关控制器
     * RecordController.php    订单，提现记录，订单明细，充值记录等相关列表
     * ResourceController.php   资源控制器，比如访问图片，下载文件
     * CommonController.php     一些通用的东西  比如获取城市
     * AccountController.php    账号的相关处理器，银行账号 用户账号  用户资料相关操作等等
     * TransactionController.php  交易相关的操作 充值 提现 等事务操作
     *
     *   上面都有说明 请尽量按说明放，把action 放到对应的控制器，别分的这一块那一块。
     */
}