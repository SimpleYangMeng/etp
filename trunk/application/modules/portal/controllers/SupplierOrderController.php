<?php
/* @desc；采购商(卖家)订单控制器
 * @date:2016-10-27
 */
class Portal_SupplierOrderController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        //不是对应买家的请跳转或抛出页面不存在的异常
        if( $this->_customerAuth['account_type'] != 2 ) {
            $this->_redirect('/portal/purchaser');
            exit;
        }
        $this->tplDirectory     = "portal/views/supplier_order/";
        $this->_layoutFile      = 'purchaser-left-widget';
        $this->_topTpl          = 'portal/views/default/top.tpl';
        $this->_innerHeaderTpl  = 'portal/views/default/header-inner.tpl';
        $this->_leftTpl         = 'portal/views/default/left.tpl';
        $this->_footerTpl       = 'portal/views/default/footer.tpl';
    }

    /**
     * [sellerTradeOrderAction 卖家交易订单查询]
     *
     * @return [type] [description]
     */
    public function tradeRecordAction(){
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
                'top'           => $this->_topTpl,
                'innerHeader'   => $this->_innerHeaderTpl,
                'left'          => $this->_leftTpl,
                'footer'        => $this->_footerTpl,
            )
        );
        exit;
    }
}