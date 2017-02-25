<?php
/* @desc；供应商（卖家）控制器
 * @date:2016-10-27
 */
class Seller_PortalController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->tplDirectory = "seller/views/default/";

        $this->_layoutObj           = Zend_Registry::get('layout');
        $this->_layoutFile          = 'supplier-left-widget';

        $this->_topTpl              = 'seller/views/layout/top.tpl';
        $this->_innerHeaderTpl      = 'seller/views/layout/header-inner.tpl';
        $this->_footerTpl           = 'seller/views/layout/footer.tpl';
        $this->_leftTpl             = 'seller/views/layout/left.tpl';
    }   

    /* @desc:供应商登录后的首页
     *
     */
    public function indexAction() {
        //获取采购商的余额
        $supplierBalance  = Service_SellerBalance::getByField(
            $this->_customerAuth['account_id'],
            'seller_id',
            array( 'internal_value', 'internal_value_currency', 'foreign_value', 'foreign_value_currency', 'settling_value' )
        );

        $todayIncome = Service_Orders::joinOrderPay(
            array(
                'seller_id' => $this->_customerAuth['account_id'],
                'pay_time_start'=> date('Y-m-d 00:00:00'),
                'pay_time_end'=> date('Y-m-d 23:59:59'),
                'order_status_array'=>array( 5, 9 ),
            ),
            'sum(order_pay.pay_amount) as pay_amount',
            ''
        );

        $monthIncome = Service_Orders::joinOrderPay(
            array(
                'seller_id' => $this->_customerAuth['account_id'],
                'pay_time_start'=> date('Y-m-01 00:00:00'),
                'pay_time_end'=> date('Y-m-d 23:59:59'),
                'order_status_array'=>array( 5, 9 ),
            ),
            'sum(order_pay.pay_amount) as pay_amount',
            ''
        );

        $this->view->sBalance               = $supplierBalance;
        $this->view->todayIncome            = empty( $todayIncome[0]['pay_amount'] ) ? '0.00': $todayIncome[0]['pay_amount'];
        $this->view->monthIncome            = empty( $monthIncome[0]['pay_amount'] ) ? '0.00': $monthIncome[0]['pay_amount'];;
        $this->view->account                = $this->_customerAuth;

        echo Ec::renderTpl(
            $this->tplDirectory . 'home.tpl',
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
     * [supplierDetailAction 卖家详情]
     *
     * @return [type] [description]
     */
    public function detailAction(){
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->includeBsPage = true;
        $layoutObj->activeMenu = 'menu_supplier_detail';
        $activeStatus = Common_DataCache::getBusinessStatus('buyer', 'is_active', 1, 0, $this->language);
        $status = Common_DataCache::getBusinessStatus('seller', 'status', 1, 0, $this->language);
        $sellerRow = Service_Seller::getByField($this->_customerAuth['account_id'], 'seller_id');
        $sellerRow['is_active_text'] = isset($activeStatus[$sellerRow['is_active']]) ? $activeStatus[$sellerRow['is_active']] : Ec_Lang::getInstance()->getTranslate('nodefined');
        $sellerRow['status_text'] = isset($status[$sellerRow['status']]) ? $status[$sellerRow['status']] : Ec_Lang::getInstance()->getTranslate('nodefined');
        $this->view->loginLog = Service_SellerLoginLog::getByCondition(array('seller_id'=>$sellerRow['seller_id']));
        $this->view->buerRow = $sellerRow;
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
     * [getPurchaserLogAction 卖家日志]
     *
     * @return [type] [description]
     */
    public function getLogAction(){
        $condition = $this->_request->getParam('condition', array());
        $page = $this->_request->getParam('page', 1);
        $pageSize = $this->_request->getParam('pageSize', 10);
        $page = $page ? $page : 1;
        $pageSize = $pageSize ? $pageSize : 10;
        $condition['seller_id'] = $this->_customerAuth['account_id'];
        $count = Service_SellerLog::getByCondition($condition, 'count(*)');
        if($count){
            $pageTotal = ceil($count / $pageSize);
            $showFields=array(
                'seller_id',
                'operate_code',
                'sl_note',
                'add_time'
            );
            $rows = Service_SellerLog::getByCondition($condition,$showFields, $pageSize, $page, array('seller_log_id desc'));
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

}