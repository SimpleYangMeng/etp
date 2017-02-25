<?php
/* @desc；供应商（卖家）控制器
 * @date:2016-10-27
 */
class Portal_SupplierController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->tplDirectory = "portal/views/supplier/";
        $this->includeTplForLayout = "portal/views/default/";
        //非买家不能进入这里
        if( $this->_customerAuth['account_type'] != 2 ) {
            $this->_redirect('/portal/purchaser');
            exit;
        }
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
            'supplier-left-widget',
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.'left.tpl',
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
        exit;
    }

    /**
     * [supplierDetailAction 卖家详情]
     *
     * @return [type] [description]
     */
    public function supplierDetailAction(){
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
     * [getPurchaserLogAction 卖家日志]
     *
     * @return [type] [description]
     */
    public function getPurchaserLogAction(){
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