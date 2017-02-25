<?php
/* @desc；采购商订单控制器
 * @date:2016-10-27
 */
class Seller_OrderController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory     = "seller/views/order/";
        $this->_layoutObj = Zend_Registry::get('layout');

        $this->_layoutFile      = 'supplier-left-widget';
        $this->_topTpl          = 'seller/views/layout/top.tpl';
        $this->_innerHeaderTpl  = 'seller/views/layout/header-inner.tpl';
        $this->_leftTpl         = 'seller/views/layout/left.tpl';
        $this->_footerTpl       = 'seller/views/layout/footer.tpl';
    }
    /**
     * [cashListAction 订单列表]
     * @return [type] [description]
     */
    public function listAction(){

        $ordersStatus = Common_DataCache::getBusinessStatus('orders', 'order_status', 1, 0, $this->language);
        $ordersPayStatus = Common_DataCache::getBusinessStatus('orders', 'pay_status', 1, 0, $this->language);
        //请求数据
        if ($this->_request->isPost()) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['seller_id'] = $this->_customerAuth['account_id'];
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
                $obj = new Service_Orders();
                $alias = $obj->getFieldsAlias( $showFields );
                $rows = Service_Orders::getByCondition($condition, $alias, $pageSize, $page, array('order_id desc'));
                $currency =  Common_DataCache::getCurrencyMaps();
                foreach ($rows as $key => $value) {
                    $rows[$key]['E9'] = $currency[$value['E9']]['currency_symbol_left'];
                    if($value['E21'] != '0000-00-00 00:00:00'){
                        $rows[$key]['E21'] = date('Y-m-d', strtotime($value['E21']));
                    }else {
                        $rows[$key]['E21'] = '';
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

        $this->_layoutObj->includeBsPage = true;
        $this->_layoutObj->includeBsDate = true;

        $this->view->platefrom = Common_DataCache::getPlateform();
        $this->view->ordersStatus = $ordersStatus;
        $this->view->ordersPayStatus = $ordersPayStatus;
        //菜单样式
        $this->_layoutObj->activeMenu = 'menu_order_list';
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

    /* @desc:交易订单明细查询
     *
     */
    public function tradeDetailListAction() {
        $changeType = Common_DataCache::getBusinessStatus('seller_balance_log', 'change_type', 1, 0, $this->language);
        if( $this->_request->isPost() ) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['seller_id'] = $this->_customerAuth['account_id'];
            $tradeListCondition = new Zend_Session_Namespace('tradeListCondition');
            $tradeListCondition->condition = $condition;
            $count = Service_SellerBalanceLog::getByCondition($condition, 'count(*)');
            if($count){
                $pageTotal = ceil($count / $pageSize);
                $showFields = array(
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
                $obj = new Service_SellerBalanceLog();
                $alias = $obj->getFieldsAlias( $showFields );
                $rows = Service_SellerBalanceLog::getByCondition($condition, $alias, $pageSize, $page, array('seller_balance_log_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['changeType'] = $changeType;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }

        $this->_layoutObj->activeMenu = 'menu_sellier_trade_order';
        $this->_layoutObj->includeBsPage = true;
        $this->_layoutObj->includeBsDate = true;

        $this->view->changeType = $changeType;

        echo Ec::renderTpl(
            $this->tplDirectory . 'trade_detail_list.tpl',
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

     /**
     * [tradeDetailExportAction 导出交易记录]
     *
     * @return [type] [description]
     */
    public function tradeDetailExportAction(){
        $exportType = $this->_request->getParam('exportType','');
        $cblidArr = $this->_request->getParam('cblidArr','');
        $exportType = $this->_request->getParam("exportType","");
        $fileName = 'sellerBalance'.uniqid().'.xls';
        $ecLangObj = Ec_Lang::getInstance();
        header('Pragma:public');
        header("Content-Type:application/x-msexecl;name=$fileName");
        header("Content-Disposition:inline;filename=$fileName");
        $html = "<table border='1'>";
        $html.="<tr>";
        $html.="<td>".$ecLangObj->getTranslate('reference')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('type')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('AvaBalance').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('AvaBalance').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('settlingValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('settlingValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('settledValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('settledValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('settlingHoldValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('settlingHoldValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('foreignValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('foreignValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('forFrozenValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('forFrozenValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('foreignEdValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('foreignEdValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('localAccountBalanceHold').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('localAccountBalanceHold').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('inFrozenValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('inFrozenValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('presentValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('presentValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('changeTime')."</td>";
        $html.="</tr>";
        $changeType = Common_DataCache::getBusinessStatus('seller_balance_log', 'change_type', 1, 0, $this->language);
        if($exportType=="1"){
            foreach($cblidArr as $val){
                $balanceLog = Service_SellerBalanceLog::getByField($val, 'seller_balance_log_id', "*");
                $changeTypeText = isset($changeType[$balanceLog['change_type']]) ? $changeType[$balanceLog['change_type']] : $ecLangObj->getTranslate('undefine');
                $html.='<tr>';
                $html.="<td>".$balanceLog['reference_code']."</td>";
                $html.="<td>".$changeTypeText."</td>";
                $html.="<td>".$balanceLog['sb_value']."</td>";
                $html.="<td>".$balanceLog['sb_value_change']."</td>";
                $html.="<td>".$balanceLog['settling_value']."</td>";
                $html.="<td>".$balanceLog['settling_value_change']."</td>";
                $html.="<td>".$balanceLog['settling_done_value']."</td>";
                $html.="<td>".$balanceLog['settling_done_value_change']."</td>";
                $html.="<td>".$balanceLog['settling_hold_value']."</td>";
                $html.="<td>".$balanceLog['settling_hold_value_change']."</td>";
                $html.="<td>".$balanceLog['foreign_value']."</td>";
                $html.="<td>".$balanceLog['foreign_value_change']."</td>";
                $html.="<td>".$balanceLog['foreign_hold_value']."</td>";
                $html.="<td>".$balanceLog['foreign_hold_value_change']."</td>";
                $html.="<td>".$balanceLog['foreign_withdraw_value']."</td>";
                $html.="<td>".$balanceLog['foreign_withdraw_value_change']."</td>";
                $html.="<td>".$balanceLog['internal_value']."</td>";
                $html.="<td>".$balanceLog['internal_value_change']."</td>";
                $html.="<td>".$balanceLog['internal_hold_value']."</td>";
                $html.="<td>".$balanceLog['internal_hold_value_change']."</td>";
                $html.="<td>".$balanceLog['internal_withdraw_value']."</td>";
                $html.="<td>".$balanceLog['internal_withdraw_value_change']."</td>";
                $html.="<td>".$balanceLog['add_time']."</td>";
                $html.="</tr>";
            }
            $html.="</table>";
            echo $html;
            exit;
        }else {
            $tradeListCondition = new Zend_Session_Namespace('tradeListCondition');
            $condition = $tradeListCondition->condition;
            $count = Service_SellerBalanceLog::getByCondition($condition, "count(*)");
            $pageSize = 20;
            $totalPage = ceil($count/$pageSize);
            for($i=1; $i<=$totalPage; $i++){
                $BalanceList = Service_SellerBalanceLog::getByCondition($condition, "*", $pageSize, $i, "seller_balance_log_id DESC");
                foreach($BalanceList as $balanceLog){
                    $changeTypeText = isset($changeType[$balanceLog['change_type']]) ? $changeType[$balanceLog['change_type']] : $ecLangObj->getTranslate('undefine');
                    $html.='<tr>';
                    $html.="<td>".$balanceLog['reference_code']."</td>";
                    $html.="<td>".$changeTypeText."</td>";
                    $html.="<td>".$balanceLog['sb_value']."</td>";
                    $html.="<td>".$balanceLog['sb_value_change']."</td>";
                    $html.="<td>".$balanceLog['settling_value']."</td>";
                    $html.="<td>".$balanceLog['settling_value_change']."</td>";
                    $html.="<td>".$balanceLog['settling_done_value']."</td>";
                    $html.="<td>".$balanceLog['settling_done_value_change']."</td>";
                    $html.="<td>".$balanceLog['settling_hold_value']."</td>";
                    $html.="<td>".$balanceLog['settling_hold_value_change']."</td>";
                    $html.="<td>".$balanceLog['foreign_value']."</td>";
                    $html.="<td>".$balanceLog['foreign_value_change']."</td>";
                    $html.="<td>".$balanceLog['foreign_hold_value']."</td>";
                    $html.="<td>".$balanceLog['foreign_hold_value_change']."</td>";
                    $html.="<td>".$balanceLog['foreign_withdraw_value']."</td>";
                    $html.="<td>".$balanceLog['foreign_withdraw_value_change']."</td>";
                    $html.="<td>".$balanceLog['internal_value']."</td>";
                    $html.="<td>".$balanceLog['internal_value_change']."</td>";
                    $html.="<td>".$balanceLog['internal_hold_value']."</td>";
                    $html.="<td>".$balanceLog['internal_hold_value_change']."</td>";
                    $html.="<td>".$balanceLog['internal_withdraw_value']."</td>";
                    $html.="<td>".$balanceLog['internal_withdraw_value_change']."</td>";
                    $html.="<td>".$balanceLog['add_time']."</td>";
                    $html.="</tr>";
                }
            }
            $html.="</table>";
            echo $html;
            exit;
        }
    }

    /**
     * [cashViewDetailAction 跳转显示详情]
     *
     * @return [type] [description]
     */
    public function detailAction(){
        $return = array('state'=>0, 'data'=> '', 'msg'=> '');
        $ordersStatus = Common_DataCache::getBusinessStatus('orders', 'order_status', 1, 0, $this->language);
        $ordersPayStatus = Common_DataCache::getBusinessStatus('orders', 'pay_status', 1, 0, $this->language);
        $platefromData = Common_DataCache::getPlateform();
        $orderId = $this->_request->getParam('parmId', 0);
        if(!empty($orderId)){
            $orderRow = Service_Orders::getByField($orderId, 'order_id');
            if(!empty($orderRow)){
                $return['state'] = 1;
                $orderRow['status_text'] = isset($ordersStatus[$orderRow['order_status']]) ? $ordersStatus[$orderRow['order_status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $orderRow['pay_status_text'] = isset($ordersPayStatus[$orderRow['pay_status']]) ? $ordersPayStatus[$orderRow['pay_status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $orderRow['platefrom'] = $platefromData[$orderRow['plate_code']];
                $buyerRow = Service_Buyer::getByField($orderRow['buyer_code'], 'buyer_code', array('company_name'));
                $orderRow['buyer_name'] = $orderRow['buyer_code'].'-'.$buyerRow['company_name'];
                $return['data'] = $orderRow;
            }else {
                $return['msg'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            }
        }else {
            $return['msg'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        //菜单样式
        $this->_layoutObj->activeMenu = 'menu_order_list';
        $this->_layoutObj->includeBsPage = true;
        $this->view->return = $return;
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
        $return = array('state'=>0, 'data'=> '', 'msg'=> '');
        $orderCode = $this->_request->getParam('orderCode', '');
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
        //菜单样式
        $this->_layoutObj->activeMenu = 'menu_order_list';
        $this->view->return = $return;
        echo Ec::renderTpl(
            $this->tplDirectory . 'order_pay.tpl',
            $this->_layoutFile,
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

}