<?php
/* @desc；采购商订单控制器
 * @date:2016-10-27
 */
class Portal_PurchaserOrderController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        //不是对应买家的请跳转或抛出页面不存在的异常
        if( $this->_customerAuth['account_type'] != 1 ) {
            $this->_redirect('/portal/supplier');
            exit;
        }
        $this->tplDirectory     = "portal/views/purchaser_order/";
        $this->_layoutFile      = 'purchaser-left-widget';
        $this->_topTpl          = 'portal/views/default/top.tpl';
        $this->_innerHeaderTpl  = 'portal/views/default/header-inner.tpl';
        $this->_leftTpl         = 'portal/views/default/left_buyer.tpl';
        $this->_footerTpl       = 'portal/views/default/footer.tpl';
    }
    /**
     * [cashListAction 订单列表]
     * @return [type] [description]
     */
    public function listAction(){
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->includeBsPage = true;
        $layoutObj->includeBsDate = true;
        $ordersStatus = Common_DataCache::getBusinessStatus('orders', 'order_status', 1, 0, $this->language);
        $ordersPayStatus = Common_DataCache::getBusinessStatus('orders', 'pay_status', 1, 0, $this->language);
        //请求数据
        if ($this->_request->isPost()) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['buyer_id'] = $this->_customerAuth['account_id'];
            $count = Service_Orders::getByCondition($condition, 'count(*)');
            if($count){
                $pageTotal = ceil($count / $pageSize);
                $showFields=array(
                    'order_id',
                    'seller_code',
                    'order_code',
                    'reference_no',
                    'plate_code',
                    'add_time',
                    'pay_currency',
                    'pay_amount',
                    'order_currency',
                    'order_amount',
                    'order_status',
                    'pay_status'
                );
                $rows = Service_Orders::getByCondition($condition, $showFields, $pageSize, $page, array('order_id desc'));
                $currency =  Common_DataCache::getCurrencyMaps();
                foreach ($rows as $key => $value) {
                    $rows[$key]['order_currency'] = $currency[$value['order_currency']]['currency_symbol_left'];
                    if($value['add_time'] != '0000-00-00 00:00:00'){
                        $rows[$key]['add_time'] = date('Y-m-d', strtotime($value['add_time']));
                    }else {
                        $rows[$key]['add_time'] = '';
                    }
                }
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['ordersStatus'] = $ordersStatus;
                $return['ordersPayStatus'] = $ordersPayStatus;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }
        $this->view->platefrom = Common_DataCache::getPlateform();
        $this->view->languageTpl = $this->language;
        $this->view->ordersStatus = $ordersStatus;
        $this->view->ordersPayStatus = $ordersPayStatus;
        //菜单样式
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_order_list';
        echo Ec::renderTpl(
            $this->tplDirectory . 'order_list.tpl',
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

    /**
     * [cashViewDetailAction 跳转显示详情]
     *
     * @return [type] [description]
     */
    public function detailAction(){
        //菜单样式
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_order_list';
        $orderCode = $this->_request->getParam('orderCode', '');
        $this->view->return = $this->getOrderRow($orderCode);
        echo Ec::renderTpl(
            $this->tplDirectory . 'order_detail.tpl',
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

    /**
     * [payOrderAction 支付订单]
     *
     * @return [type] [description]
     */
    public function payOrderAction(){
        //菜单样式
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_order_list';
        $orderCode = $this->_request->getParam('orderCode', '');
        $this->view->return = $this->getOrderRow($orderCode);
        echo Ec::renderTpl(
            $this->tplDirectory . 'order_pay.tpl',
            'purchaser-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->_topTpl,
                'innerHeader' => $this->_innerHeaderTpl,
                'left' => $this->_leftTpl,
                'footer' => $this->_footerTpl,
            )
        );
    }

    /**
     * [cancleOrderAction 取消订单]
     *
     * @return [type] [description]
     */
    public function cancleOrderAction(){
        echo 111;
    }
    /**
     * [getOrderRow 订单基本信息]
     *
     * @param  [type] $orderCode [description]
     *
     * @return [type]            [description]
     */
    private function getOrderRow($orderCode){
        $return = array('state'=>0, 'data'=> '', 'msg'=> '');
        $ordersStatus = Common_DataCache::getBusinessStatus('orders', 'order_status', 1, 0, $this->language);
        $ordersPayStatus = Common_DataCache::getBusinessStatus('orders', 'pay_status', 1, 0, $this->language);
        $platefromData = Common_DataCache::getPlateform();
        if(!empty($orderCode)){
            $orderRow = Service_Orders::getByField($orderCode, 'order_code');
            if(!empty($orderRow)){
                $return['state'] = 1;
                $orderRow['status_text'] = isset($ordersStatus[$orderRow['order_status']]) ? $ordersStatus[$orderRow['order_status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $orderRow['pay_status_text'] = isset($ordersPayStatus[$orderRow['pay_status']]) ? $ordersPayStatus[$orderRow['pay_status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $orderRow['platefrom'] = $platefromData[$orderRow['plate_code']];
                $buyerRow = Service_Buyer::getByField($orderRow['buyer_code'], 'buyer_code', array('company_name'));
                $orderRow['buyer_name'] = $orderRow['buyer_code'].'-'.$buyerRow['company_name'];
                $return['data'] = $orderRow;
            }else {
                $return['msg'] = Ec_Lang::getInstance()->getTranslate('unkownOrder');
            }
        }else {
            $return['msg'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        return $return;
    }
    /**
     * [payOrderSubmitAction 提交支付订单]
     *
     * @return [type] [description]
     */
    public function payOrderSubmitAction(){
        $return = array( 'state'=>0, 'message'=>'' );
        /*
        $errorArr = Service_BuyerWithdraw::validator($data);
        if (!empty($errorArr)) {
            $return['error'] = Common_EtpCommon::transErrors($errorArr);
            die(Zend_Json::encode($return));
        }
        */
        $orderId = $this->getRequest()->getParam('orderId', '');
        if(empty($orderId)){
            $return['error'] = Common_EtpCommon::transErrors(array(Ec_Lang::getInstance()->getTranslate('paramsError')));
            die(Zend_Json::encode($return));
        }
        $orderRow = Service_Orders::getByField($orderId, 'order_id');
        if(empty($orderRow)){
            $return['error'] = Common_EtpCommon::transErrors(array(Ec_Lang::getInstance()->getTranslate('unkownOrder')));
            die(Zend_Json::encode($return));
        }
        $maps = array(
            'order_id' => 'orderId',
            'pay_no' => 'payNo',
            'buyer_code' => 'buyerCode',
            'seller_code'=>'sellerCode',
            'pay_amount'=>'payAmount',
            'pay_currency'=>'payCurrency'
        );
        $apiObj = new Api_Order(array());
        $return = $apiObj->payOrder($orderRow, $maps);
        if($return['state'] == 1){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('appOWithdraw').Ec_Lang::getInstance()->getTranslate('success');
        }
        die(json_encode($return));
    }

    /* @desc:买家交易订单查询
     *
     */
    public function tradeOrderAction() {
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
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'left'          => $this->_leftTpl,
                'footer'        => $this->_footerTpl,
            )
        );
        exit;
    }

}