<?php
/* @desc；日志管理器
 * @date:2016-10-27
 */
class Portal_RecordController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->tplDirectory = "portal/views/record/";
        $this->includeTplForLayout = "portal/views/default/";
        if( $this->_customerAuth['account_type'] == 1 ){
            $this->_layoutFile     = 'purchaser-left-widget';
            $this->_leftTpl = 'left_buyer.tpl';
        } else {
            $this->_layoutFile     = 'supplier-left-widget';
            $this->_leftTpl = 'left.tpl';
        }
    }

    /* @desc:提现状态管理
     *
     */
    public function withdrawListAction() {
        //获取登录账户的转账信息
        if( $this->_request->isPost() ) {
            $return = array( 'state' => 0, 'data' => array(), 'msg' => '', 'total' => 0 );

            $page           = trim( $this->_request->getParam( 'page', 1 ) );
            $pageSize       = trim( $this->_request->getParam( 'pageSize', 20 ) );
            $bankAccount    = trim( $this->_request->getParam( 'cardNo', '' ) );
            $withdrawType   = trim( $this->_request->getParam( 'withdrawType', '' ) );
            $sDate          = trim( $this->_request->getParam( 'cDateStart', '' ) );
            $eDate          = trim( $this->_request->getParam( 'cDateEnd', '' ) );
            $accountType    = $this->_customerAuth['account_type'];
            $accountId = $this->_customerAuth['account_id'];

            $condition = array();

            if( $accountType == 1 ) {//买家
                $serviceObj = new Service_BuyerWithdraw();
                $tmpFields = array(
                    'withdraw_code',
                    'add_time',
                    'amount',
                    'status',
                    'currency',
                );
                $fields = $serviceObj->getYourFieldsAlias( $tmpFields );
                $condition['buyer_id'] = $accountId;
                $condition['bank_buyer_name'] = $bankAccount;
                $condition['add_time_start'] = $sDate;
                $condition['add_time_end'] = $eDate;
                $total = Service_BuyerWithdraw::getByCondition( $condition, 'count(*)' );
                if( $total > 0 ) {
                    $return['state'] = 1;
                    $return['data'] = Service_BuyerWithdraw::getByCondition( $condition, $fields, $pageSize, $page, 'buyer_withdraw_id desc' );
                }
                $return['total'] = $total;
            } else { //卖家
                $serviceObj = new Service_SellerWithdraw();
                $tmpFields = array(
                    'withdraw_code',
                    'add_time',
                    'amount',
                    'status',
                    'currency',
                    'withdraw_type'
                );
                $fields = $serviceObj->getYourFieldsAlias( $tmpFields );
                //print_r($fields);
                $condition['seller_id'] = $accountId;
                $condition['bank_buyer_name'] = $bankAccount;
                $condition['add_time_start'] = $sDate;
                $condition['add_time_end'] = $eDate;
                $total = Service_SellerWithdraw::getByCondition( $condition, 'count(*)' );
                if( $total > 0 ) {
                    $return['state'] = 1;
                    $return['data'] = Service_SellerWithdraw::getByCondition( $condition, $fields, $pageSize, $page, 'seller_withdraw_id desc' );
                }
                $return['total'] = $total;
            }
           $currency =  Common_DataCache::getCurrencyMaps();
            foreach( $return['data'] as $key=>$value ) {
                if( isset( $value['C5'] ) ) {
                    $return['data'][$key]['C5'] = $value['C5'] == 1 ?  Ec_Lang::getInstance()->getTranslate('localWithdraw') : Ec_Lang::getInstance()->getTranslate('overseaWithdraw');
                }
                $return['data'][$key]['C4'] = $currency[$value['C4']]['currency_symbol_left'];
            }
            $return['pageTotal'] = ceil( $return['total'] / $pageSize);
            die( json_encode( $return ) );
        }

        $layoutObj                      = Zend_Registry::get('layout');
        $layoutObj->activeMenu          = 'menu_withdraw';
        $layoutObj->includeBsDate       = true;
        $layoutObj->includeBsPage       = true;

        $condition = $withdrawType = array();
        if( $this->_customerAuth['account_type'] == 1) {
            $condition        =  array( 'bussiness_table'=>'buyer_withdraw ','bussiness_column'=>'status' );
        } else {
            $condition        =  array( 'bussiness_table'=>'seller_withdraw ','bussiness_column'=>'status' );
            $withdrawType     = array(1=>Ec_Lang::getInstance()->getTranslate('localWithdraw'),2=>Ec_Lang::getInstance()->getTranslate('overseaWithdraw'));
        }
        $tags                                   = Service_BussinessStatus::getByCondition( $condition );
        $this->view->tags                       = $tags;
        $this->view->accountType                = $this->_customerAuth['account_type'];
        $this->view->withdrawType               = $withdrawType;
        echo Ec::renderTpl(
            $this->tplDirectory . 'withdraw-list.tpl',
            $this->_layoutFile,
            '交易订单',
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

    /* @desc:汇总提现明细
     *
     */
    public function withdrawSumDetailAction() {

    }

    /* @desc:买家交易订单查询
     *
     */
    public function purchaserTradeOrderAction() {
        $changeType = Common_DataCache::getBusinessStatus('buyer_balance_log', 'change_type', 1, 0, $this->language);
        if( $this->_request->isPost() ) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['buyer_id'] = $this->_customerAuth['account_id'];
            $count = Service_BuyerBalanceLog::getByCondition($condition, 'count(*)');
            if($count){
                $pageTotal = ceil($count / $pageSize);
                $showFields=array(
                    'buyer_balance_log_id',
                    'buyer_id',
                    'reference_code',
                    'cb_value',
                    'cb_value_change',
                    'cb_hold_value',
                    'cb_hold_value_change',
                    'cb_debit_value',
                    'cb_debit_value_change',
                    'cb_withdraw_hold_value',
                    'cb_withdraw_hold_value_change',
                    'cb_withdraw_value',
                    'cb_withdraw_value_change',
                    'change_type',
                    'add_time',
                );
                $rows = Service_BuyerBalanceLog::getByCondition($condition, $showFields, $pageSize, $page, array('buyer_balance_log_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['changeType'] = $changeType;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_buyer_trade_order';
        $layoutObj->includeBsPage = true;
        $layoutObj->includeBsDate = true;

        $this->view->changeType = $changeType;

        echo Ec::renderTpl(
            $this->tplDirectory . 'purchaser_trade_order_list.tpl',
            $this->_layoutFile,
            '交易订单',
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

    /**
     * [sellerTradeOrderAction 卖家交易订单查询]
     *
     * @return [type] [description]
     */
    public function supplierTradeOrderAction(){
        $changeType = Common_DataCache::getBusinessStatus('seller_balance_log', 'change_type', 1, 0, $this->language);
        if( $this->_request->isPost() ) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['seller_id'] = $this->_customerAuth['account_id'];
            $count = Service_SellerBalanceLog::getByCondition($condition, 'count(*)');
            if($count){
                $pageTotal = ceil($count / $pageSize);
                $showFields=array(
                    'seller_balance_log_id',
                    'seller_id',
                    'reference_code',
                    'sb_value',
                    'sb_value_change',
                    'settling_value',
                    'settling_value_change',
                    'settling_hold_value',
                    'settling_hold_value_change',
                    'internal_value',
                    'internal_value_change',
                    'foreign_value',
                    'foreign_value_change',
                    'change_type',
                    'add_time',
                );
                $rows = Service_SellerBalanceLog::getByCondition($condition, $showFields, $pageSize, $page, array('seller_balance_log_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['changeType'] = $changeType;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_sellier_trade_order';
        $layoutObj->includeBsPage = true;
        $layoutObj->includeBsDate = true;

        $this->view->changeType = $changeType;

        echo Ec::renderTpl(
            $this->tplDirectory . 'supplier_trade_order_list.tpl',
            $this->_layoutFile,
            '交易订单',
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

    /* @desc:充值明细查询
     *
     */
    public function creditDetailAction() {

    }

    /* @desc:查看提现明细
     *
     */
    public function viewWithdrawAction() {

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