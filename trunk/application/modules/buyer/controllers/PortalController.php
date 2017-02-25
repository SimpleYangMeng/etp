<?php
/* @desc；采购商控制器
 * @date:2016-10-27
 */
class Buyer_PortalController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "buyer/views/default/";

        $this->_layoutObj           = Zend_Registry::get('layout');
        $this->_layoutFile          = 'purchaser-left-widget';

        $this->_topTpl              = 'buyer/views/layout/top.tpl';
        $this->_innerHeaderTpl      = 'buyer/views/layout/header-inner.tpl';
        $this->_footerTpl           = 'buyer/views/layout/footer.tpl';
        $this->_leftTpl             = 'buyer/views/layout/left.tpl';
    }

    /* @desc:采购商登录后的首页
     *
     */
    public function indexAction() {
        if(!$this->_customerAuth['has_pay_password']){
            $this->_redirect('/buyer/portal/set-paypwd-notice');
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
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'   => $this->_innerHeaderTpl,
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
        $this->view->languageTpl = $this->language;
        echo Ec::renderTpl($this->tplDirectory . "set_paypwd_notice.tpl",
            'purchaser-no-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'   => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
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
                'top'           => $this->_topTpl,
                'innerHeader'   => $this->_innerHeaderTpl,
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
        //$res = Service_Buyer::update(array('pay_password' => $payPwd), $this->_customerAuth['account_code'], 'buyer_code');
        switch ($this->_customerAuth['account_type']) {
            case '1':
                //$oldPayPwd = Service_Buyer::getByField($this->_customerAuth['account_code'], 'buyer_code', array('pay_password'));
                $res = Service_Buyer::update(array('pay_password' => $payPwd, 'update_time'=>date('Y-m-d H:i:s')), $this->_customerAuth['account_code'], 'buyer_code');
                $backUrl = '/buyer/portal';
                break;
            case '2':
                //$oldPayPwd = Service_Seller::getByField($this->_customerAuth['account_code'], 'seller_code', array('pay_password'));
                $res = Service_Seller::update(array('pay_password' => $payPwd, 'update_time'=>date('Y-m-d H:i:s')), $this->_customerAuth['account_code'], 'seller_code');
                $backUrl = '/seller/portal';
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
            $this->_redirect('/buyer/portal/set-paypwd-notice');
            exit;
        }
        $this->view->languageTpl = $this->language;
        $this->view->indexUrl = '/buyer/portal';
        echo Ec::renderTpl($this->tplDirectory . "set_paypwd_success.tpl",
            'purchaser-no-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'   => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
            )
        );
    }

    /**
     * [purchaserDetailAction 买家详情]
     *
     * @return [type] [description]
     */
    public function detailAction() {
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
     * [getPurchaserLogAction 买家日志]
     *
     * @return [type] [description]
     */
    public function getLogAction(){
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
    }
}