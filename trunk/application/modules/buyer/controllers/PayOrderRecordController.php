<?php
/* @desc；交易控制器(提现之类的)
 * @date:2016-10-27
 */
class Buyer_PayOrderRecordController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->layoutObj = Zend_Registry::get('layout');

        $this->tplDirectory     = "buyer/views/pay_order_record/";
        $this->_layoutFile      = 'purchaser-left-widget';
        $this->_topTpl          = 'buyer/views/layout/top.tpl';
        $this->_innerHeaderTpl  = 'buyer/views/layout/header-inner.tpl';
        $this->_leftTpl         = 'buyer/views/layout/left.tpl';
        $this->_footerTpl       = 'buyer/views/layout/footer.tpl';
    }

    /**
     * [purchaserPayOrderListAction 买家支付订单列表]
     *
     * @return [type] [description]
     */
    public function payOrderListAction(){
        $payStatus = Common_DataCache::getBusinessStatus('order_pay', 'status', 1, 0, $this->language);
        //请求数据
        if ($this->_request->isPost()) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['buyer_id'] = $this->_customerAuth['account_id'];
            $count = Service_OrderPay::getByCondition($condition, 'count(*)');
            if($count){
                $pageTotal = ceil($count / $pageSize);
                $showFields = array(
                    'order_pay_id',
                    'buyer_code',
                    'seller_code',
                    'pay_no',
                    'pay_amount',
                    'pay_currency',
                    'order_code',
                    'add_time',
                    'pay_time',
                );
                $obj = new Service_OrderPay();
                $alias = $obj->getFieldsAlias( $showFields );
                $rows = Service_OrderPay::getByCondition($condition,$alias, $pageSize, $page, array('order_pay_id desc'));
                $currency =  Common_DataCache::getCurrencyMaps();
                foreach( $rows as $key=>$value ) {
                    $rows[$key]['E8'] = $currency[$value['E8']]['currency_symbol_left'];
                }
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['payStatus'] = $payStatus;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }
        $this->view->languageTpl = $this->language;
        $this->view->payStatus = $payStatus;

        //菜单样式
        $this->layoutObj->includeBsPage = true;
        $this->layoutObj->includeBsDate = true;
        $this->layoutObj->activeMenu = 'menu_purchaser_pay_order';

        echo Ec::renderTpl(
            $this->tplDirectory . 'purchaser_pay_order_list.tpl',
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
     * [purchaserPayOrderDetailAction 支付单详情]
     *
     * @return [type] [description]
     */
    public function payOrderDetailAction(){
        $return = array('state'=>0, 'data'=> '', 'message'=> 'No data');
        $payStatus = Common_DataCache::getBusinessStatus('order_pay', 'status', 1, 0, $this->language);
        $parmId = $this->_request->getParam('parmId', 0);
        if(!empty($parmId)){
            $orderPayRow = Service_OrderPay::getByField($parmId, 'order_pay_id');
            if(!empty($orderPayRow)){
                $return['state'] = 1;
                $orderPayRow['status_text'] = isset($payStatus[$orderPayRow['status']]) ? $payStatus[$orderPayRow['status']] : Ec_Lang::getInstance()->getTranslate('undefine');;
                $return['data'] = $orderPayRow;
            }else {
                $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            }
        }else {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        //菜单样式
        $this->layoutObj->activeMenu = 'menu_purchaser_pay_order';
        $this->layoutObj->includeBsPage = true;
        $this->view->return = $return;
        echo Ec::renderTpl(
            $this->tplDirectory . 'purchaser_pay_order_detail.tpl',
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
     * [getOrderLogAction 日志]
     *
     * @return [type] [description]
     */
    public function getLogAction(){
        $condition = $this->_request->getParam('condition', array());
        $page = $this->_request->getParam('page', 1);
        $pageSize = $this->_request->getParam('pageSize', 10);
        $page = $page ? $page : 1;
        $pageSize = $pageSize ? $pageSize : 10;
        $count = Service_OrderPayLog::getByCondition($condition, 'count(*)');
        if($count){
            $pageTotal = ceil($count / $pageSize);
            $showFields = array(
                'status_from',
                'status_to',
                'note',
                'add_time'
            );
            $rows = Service_OrderPayLog::getByCondition($condition,$showFields, $pageSize, $page, array('order_pay_log_id desc'));
            $orderPayStatus = Common_DataCache::getBusinessStatus('order_pay', 'status', 1, 0, $this->language);
            foreach ($rows as $key => $value) {
                $rows[$key]['status_from'] = isset($orderPayStatus[$value['status_from']]) ? $orderPayStatus[$value['status_from']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $rows[$key]['status_to'] = isset($orderPayStatus[$value['status_to']]) ? $orderPayStatus[$value['status_to']] : Ec_Lang::getInstance()->getTranslate('undefine');
            }
            $return['data'] = $rows;
            $return['state'] = 1;
            $return['pageTotal'] = $pageTotal;
        }
        $return['total'] = $count;
        die(Zend_Json::encode($return));
    }
}