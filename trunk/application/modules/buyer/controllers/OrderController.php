<?php
/* @desc；采购商订单控制器
 * @date:2016-10-27
 */
class Buyer_OrderController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory     = "buyer/views/order/";
        $this->_layoutObj = Zend_Registry::get('layout');

        $this->_layoutFile      = 'purchaser-left-widget';
        $this->_layoutNoLeftFile = 'purchaser-no-left-widget';
        $this->_topTpl          = 'buyer/views/layout/top.tpl';
        $this->_innerHeaderTpl  = 'buyer/views/layout/header-inner.tpl';
        $this->_leftTpl         = 'buyer/views/layout/left.tpl';
        $this->_footerTpl       = 'buyer/views/layout/footer.tpl';
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
        $this->_layoutObj->includejqueryConfirm = true;
        $this->view->platefrom = Common_DataCache::getPlateform();
        $this->view->languageTpl = $this->language;
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

    /**
     * [cashViewDetailAction 跳转显示详情]
     *
     * @return [type] [description]
     */
    public function detailAction(){
        $return = array('state'=>0, 'data'=> '', 'msg'=> '');
        $orderCode = $this->_request->getParam('orderCode', '');
        $this->view->return = $this->getOrderRow($orderCode);
        //菜单样式
        $this->_layoutObj->activeMenu = 'menu_order_list';
        $this->_layoutObj->includeBsPage = true;
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
     * [getOrderLogAction 订单日志]
     *
     * @return [type] [description]
     */
    public function getLogAction(){
        $condition = $this->_request->getParam('condition', array());
        $page = $this->_request->getParam('page', 1);
        $pageSize = $this->_request->getParam('pageSize', 10);
        $page = $page ? $page : 1;
        $pageSize = $pageSize ? $pageSize : 10;
        $count = Service_OrderLog::getByCondition($condition, 'count(*)');
        if($count){
            $pageTotal = ceil($count / $pageSize);
            $showFields = array(
                'status_from',
                'status_to',
                'note',
                'add_time'
            );
            $rows = Service_OrderLog::getByCondition($condition,$showFields, $pageSize, $page, array('order_log_id desc'));
            $ordersStatus = Common_DataCache::getBusinessStatus('orders', 'order_status', 1, 0, $this->language);
            foreach ($rows as $key => $value) {
                $rows[$key]['status_from'] = isset($ordersStatus[$value['status_from']]) ? $ordersStatus[$value['status_from']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $rows[$key]['status_to'] = isset($ordersStatus[$value['status_to']]) ? $ordersStatus[$value['status_to']] : Ec_Lang::getInstance()->getTranslate('undefine');
            }
            $return['data'] = $rows;
            $return['state'] = 1;
            $return['pageTotal'] = $pageTotal;
        }
        $return['total'] = $count;
        die(Zend_Json::encode($return));
    }

    /**
     * [payOrderAction 支付订单]
     *
     * @return [type] [description]
     */
    public function payOrderAction(){
        $return = array('state'=>0, 'data'=> '', 'msg'=> '');
        $orderCode = $this->_request->getParam('orderCode', '');
        $orderData = $this->getOrderRow($orderCode);
        //调用绑定接口
        if($orderData['state'] == 1){
            if($orderData['data']['order_status'] != 1 || $orderData['data']['pay_status'] == 2 ){
                $orderData['state'] = 0;
                $orderData['data'] = array();
                $orderData['msg'] = sprintf(Ec_Lang::getInstance()->getTranslate('orderPaied'), $orderCode);
            }
            /*
            if(!($orderRow['order_status'] != 1 || $orderRow['pay_status'] == 1 )){
                //未绑定
                if(empty($orderRow['buyer_id']) && empty($orderRow['buyer_code'])){
                    $loginInfo = Service_Login::getLoginInfo();
                    $orderRow['buyer_id'] = $loginInfo['account_id'];
                    $orderRow['buyer_code'] = $loginInfo['account_code'];
                    $maps = array(
                        'order_id' => 'orderId',
                        'buyer_code' => 'buyerCode'
                    );
                    $apiObj = new Api_Order(array('refcode' => $orderCode));
                    $apiRes = $apiObj->bindOrder($orderRow, $maps);
                    if($apiRes['state'] != 1){
                        $message = '';
                        foreach ($apiRes['error'] as $error) {
                            $message .= $error['errorCode'].':'.$error['errorMsg'];
                        }
                        $orderData['state'] = 0;
                        $orderData['data'] = array();
                        $orderData['msg'] = $message;
                    }else {
                        $orderData = $this->getOrderRow($orderCode);
                    }
                }
            //订单已支付
            }else {
                $orderData['state'] = 0;
                $orderData['data'] = array();
                $orderData['msg'] = sprintf(Ec_Lang::getInstance()->getTranslate('orderPaied'), $orderCode);
            }
            */
        }
        $this->view->return = $orderData;
        //菜单样式
        $this->_layoutObj->activeMenu = 'menu_order_list';
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
        //支付金额-币种
        $orderRow['pay_amount'] = $orderRow['order_amount'];
        $orderRow['pay_currency'] = $orderRow['order_currency'];
        //临时生成，后续需修改
        $orderRow['pay_no'] = 'PAY'.time().uniqid();
        $apiObj = new Api_Order( array( 'refcode' => $orderRow['order_code'] ) );
        $return = $apiObj->payOrder($orderRow, $maps);
        if($return['state'] == 1){
            $return['backUrl'] = '/buyer/order/list';
            $return['message'] = Ec_Lang::getInstance()->getTranslate('success');
        }
        die(Zend_Json::encode($return));
    }

    /**
     * [cancleOrderAction 取消订单]
     *
     * @return [type] [description]
     */
    public function cancleOrderAction(){
        $return = array('state'=>0, 'data'=> '', 'msg'=> '');
        $orderCode = $this->_request->getParam('orderCode', '');
        $this->view->cancelNotice = sprintf(Ec_Lang::getInstance()->getTranslate('cancelOrderNotice'), $orderCode);
        $this->view->return = $this->getOrderRow($orderCode);
        //菜单样式
        $this->_layoutObj->activeMenu = 'menu_order_list';
        echo Ec::renderTpl(
            $this->tplDirectory . 'order_cancle.tpl',
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
     * [cancleOrderSubmitAction 确认取消订单]
     *
     * @return [type] [description]
     */
    public function cancleOrderSubmitAction(){
        $return = array( 'state'=>0, 'message'=>'' );
        /*
        $errorArr = Service_BuyerWithdraw::validator($data);
        if (!empty($errorArr)) {
            $return['error'] = Common_EtpCommon::transErrors($errorArr);
            die(Zend_Json::encode($return));
        }
        */
        $orderId = $this->getRequest()->getParam('orderId', '');
        $cancleReason = $this->getRequest()->getParam('cancleReason', '');
        if(empty($orderId) || empty($cancleReason)){
            $return['error'] = Common_EtpCommon::transErrors(array(Ec_Lang::getInstance()->getTranslate('paramsError')));
            die(Zend_Json::encode($return));
        }
        $orderRow = Service_Orders::getByField($orderId, 'order_id', array('order_id'));
        if(empty($orderRow)){
            $return['error'] = Common_EtpCommon::transErrors(array(Ec_Lang::getInstance()->getTranslate('unkownOrder')));
            die(Zend_Json::encode($return));
        }
        $postData = array(
            'order_id' => $orderId,
            'operator' => $this->_customerAuth['account_code'],
            'note' => $cancleReason
        );
        $maps = array(
            'order_id' => 'orderId',
            'operator' => 'operator',
            'note' => 'note'
        );
        $apiObj = new Api_Order( array( 'refcode' => $orderRow['order_code'] ) );
        $return = $apiObj->cancelOrder($postData, $maps);
        if($return['state'] == 1){
            $return['backUrl'] = '/buyer/order/list';
            $return['message'] = Ec_Lang::getInstance()->getTranslate('cancelOrder').Ec_Lang::getInstance()->getTranslate('success');
        }
        die(Zend_Json::encode($return));
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
                //已经绑定
                if(!empty($orderRow['buyer_id']) && !empty($orderRow['buyer_code'])){
                    $loginInfo = Service_Login::getLoginInfo();
                    if($orderRow['buyer_id'] != $loginInfo['account_id'] || $orderRow['buyer_code'] != $loginInfo['account_code']){
                        $return['msg'] = Ec_Lang::getInstance()->getTranslate('authFiled');
                        return $return;
                    }
                }
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
     * [checkPayPwdAction description]
     *
     * @return [type] [description]
     */
    public function checkPayPwdAction(){
        $error = '';
        $orderId = trim( $this->_request->getParam('orderId', 0));
        $checkPwd = trim( $this->_request->getParam('payPwd', ''));
        $checkPwd = Common_Common::pwdAlgorithm($checkPwd);
        if(empty($checkPwd)){
            die(Zend_Json::encode(array('error'=>Ec_Lang::getInstance()->getTranslate('payPwd').Ec_Lang::getInstance()->getTranslate('require'))));
        }
        if(empty($orderId)){
            die(Zend_Json::encode(array('error'=>Ec_Lang::getInstance()->getTranslate('paramsError'))));
        }
        /*
        $oldPwd = $oldPayPwd['pay_password'];
        if(empty($oldPwd)){
            $error = Ec_Lang::getInstance()->getTranslate('payPwd').Ec_Lang::getInstance()->getTranslate('require');
            die(Zend_Json::encode(array('error'=>$error)));
        }
        */
        $oldPayPwd = Service_Buyer::getByField($this->_customerAuth['account_code'], 'buyer_code', array('pay_password'));
        if(strcasecmp($checkPwd, $oldPayPwd['pay_password'])){
            die(Zend_Json::encode(array('error'=>Ec_Lang::getInstance()->getTranslate('payPwd').Ec_Lang::getInstance()->getTranslate('error'))));
        }
        //绑定订单
        $orderRow = Service_Orders::getByField($orderId, 'order_id');
        if(!empty($orderRow)){
            if(!($orderRow['order_status'] != 1 || $orderRow['pay_status'] == 2 )){
                //未绑定
                if(empty($orderRow['buyer_id']) && empty($orderRow['buyer_code'])){
                    //验证登陆
                    Service_Login::isLogin();
                    $loginInfo = Service_Login::getLoginInfo();
                    $orderRow['buyer_id'] = $loginInfo['account_id'];
                    $orderRow['buyer_code'] = $loginInfo['account_code'];
                    $maps = array(
                        'order_id' => 'orderId',
                        'buyer_code' => 'buyerCode'
                    );
                    $apiObj = new Api_Order(array('refcode' => $orderRow['order_code']));
                    $apiRes = $apiObj->bindOrder($orderRow, $maps);
                    if($apiRes['state'] != 1){
                        $message = '';
                        foreach ($apiRes['error'] as $error) {
                            $message .= $error['errorCode'].':'.$error['errorMsg'];
                        }
                        die(Zend_Json::encode(array('error'=>$message)));
                    }
                }
            //订单已支付
            }else {
                die(Zend_Json::encode(array('error'=>sprintf(Ec_Lang::getInstance()->getTranslate('orderPaied'), $orderRow['order_code']))));
            }
        }
        die(Zend_Json::encode(array('ok'=>Ec_Lang::getInstance()->getTranslate('success'))));
    }

    /* @desc:交易订单明细查询
     *
     */
    public function tradeDetailListAction() {
        $changeType = Common_DataCache::getBusinessStatus('buyer_balance_log', 'change_type', 1, 0, $this->language);
        if( $this->_request->isPost() ) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['buyer_id'] = $this->_customerAuth['account_id'];
            $tradeListCondition = new Zend_Session_Namespace('tradeListCondition');
            $tradeListCondition->condition = $condition;
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
                $obj = new Service_BuyerBalanceLog();
                $alias = $obj->getFieldsAlias( $showFields );
                $rows = Service_BuyerBalanceLog::getByCondition($condition, $alias, $pageSize, $page, array('buyer_balance_log_id desc'));
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['changeType'] = $changeType;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }
        $this->_layoutObj->activeMenu = 'menu_buyer_trade_order';
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
        $fileName = 'buyerBalance'.uniqid().'.xls';
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
        $html.="<td>".$ecLangObj->getTranslate('frozenValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('frozenValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('logisticsChangeValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('logisticsChangeValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('preFrozenValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('preFrozenValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('foreignEdValue').$ecLangObj->getTranslate('changeBeforeExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('foreignEdValue').$ecLangObj->getTranslate('changeAfterExport')."</td>";
        $html.="<td>".$ecLangObj->getTranslate('changeTime')."</td>";
        $html.="</tr>";
        $changeType = Common_DataCache::getBusinessStatus('buyer_balance_log', 'change_type', 1, 0, $this->language);
        if($exportType=="1"){
            foreach($cblidArr as $val){
                $balanceLog = Service_BuyerBalanceLog::getByField($val, 'buyer_balance_log_id', "*");
                $changeTypeText = isset($changeType[$balanceLog['change_type']]) ? $changeType[$balanceLog['change_type']] : $ecLangObj->getTranslate('undefine');
                $html.='<tr>';
                $html.="<td>".$balanceLog['reference_code']."</td>";
                $html.="<td>".$changeTypeText."</td>";
                $html.="<td>".$balanceLog['cb_value']."</td>";
                $html.="<td>".$balanceLog['cb_value_change']."</td>";
                $html.="<td>".$balanceLog['cb_hold_value']."</td>";
                $html.="<td>".$balanceLog['cb_hold_value_change']."</td>";
                $html.="<td>".$balanceLog['cb_debit_value']."</td>";
                $html.="<td>".$balanceLog['cb_debit_value_change']."</td>";
                $html.="<td>".$balanceLog['cb_withdraw_hold_value']."</td>";
                $html.="<td>".$balanceLog['cb_withdraw_hold_value_change']."</td>";
                $html.="<td>".$balanceLog['cb_withdraw_value']."</td>";
                $html.="<td>".$balanceLog['cb_withdraw_value_change']."</td>";
                $html.="<td>".$balanceLog['add_time']."</td>";
                $html.="</tr>";
            }
            $html.="</table>";
            echo $html;
            exit;
        }else {
            $tradeListCondition = new Zend_Session_Namespace('tradeListCondition');
            $condition = $tradeListCondition->condition;
            $count = Service_BuyerBalanceLog::getByCondition($condition, "count(*)");
            $pageSize = 20;
            $totalPage = ceil($count/$pageSize);
            for($i=1; $i<=$totalPage; $i++){
                $BalanceList = Service_BuyerBalanceLog::getByCondition($condition, "*", $pageSize, $i, "buyer_balance_log_id DESC");
                foreach($BalanceList as $balanceLog){
                    $changeTypeText = isset($changeType[$balanceLog['change_type']]) ? $changeType[$balanceLog['change_type']] : $ecLangObj->getTranslate('undefine');
                    $html.='<tr>';
                    $html.="<td>".$balanceLog['reference_code']."</td>";
                    $html.="<td>".$changeTypeText."</td>";
                    $html.="<td>".$balanceLog['cb_value']."</td>";
                    $html.="<td>".$balanceLog['cb_value_change']."</td>";
                    $html.="<td>".$balanceLog['cb_hold_value']."</td>";
                    $html.="<td>".$balanceLog['cb_hold_value_change']."</td>";
                    $html.="<td>".$balanceLog['cb_debit_value']."</td>";
                    $html.="<td>".$balanceLog['cb_debit_value_change']."</td>";
                    $html.="<td>".$balanceLog['cb_withdraw_hold_value']."</td>";
                    $html.="<td>".$balanceLog['cb_withdraw_hold_value_change']."</td>";
                    $html.="<td>".$balanceLog['cb_withdraw_value']."</td>";
                    $html.="<td>".$balanceLog['cb_withdraw_value_change']."</td>";
                    $html.="<td>".$balanceLog['add_time']."</td>";
                    $html.="</tr>";
                }
            }
            $html.="</table>";
            echo $html;
            exit;
        }
    }
}