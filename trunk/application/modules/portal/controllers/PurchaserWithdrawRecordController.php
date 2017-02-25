<?php
/* @desc；采购商（买家）日志管理器
 * @date:2016-10-27
 */
class Portal_PurchaserWithdrawRecordController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        //不是对应买家的请跳转或抛出页面不存在的异常

        $this->tplDirectory     = "portal/views/purchaser_withdraw_record/";
        $this->_layoutFile      = 'purchaser-left-widget';
        $this->_topTpl          = 'portal/views/default/top.tpl';
        $this->_innerHeaderTpl  = 'portal/views/default/header-inner.tpl';
        $this->_leftTpl         = 'portal/views/default/left_buyer.tpl';
        $this->_footerTpl       = 'portal/views/default/footer.tpl';
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
            $sDate          = trim( $this->_request->getParam( 'cDateStart', '' ) );
            $eDate          = trim( $this->_request->getParam( 'cDateEnd', '' ) );
            $accountId = $this->_customerAuth['account_id'];

            $condition = array();
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
            $currency =  Common_DataCache::getCurrencyMaps();
            foreach( $return['data'] as $key=>$value ) {
                $return['data'][$key]['C4'] = $currency[$value['C4']]['currency_symbol_left'];
            }
            $return['pageTotal'] = ceil( $return['total'] / $pageSize);
            die( json_encode( $return ) );
        }

        $layoutObj                      = Zend_Registry::get('layout');
        $layoutObj->activeMenu          = 'menu_withdraw';
        $layoutObj->includeBsDate       = true;
        $layoutObj->includeBsPage       = true;

        $condition              =  array( 'bussiness_table'=>'buyer_withdraw ','bussiness_column'=>'status' );
        $tags                   = Service_BussinessStatus::getByCondition( $condition );
        $this->view->tags       = $tags;

        echo Ec::renderTpl(
            $this->tplDirectory . 'withdraw-list.tpl',
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

    /* @desc:汇总提现明细
     *
     */
    public function withdrawSumDetailAction() {

    }

    /* @desc:查看提现明细
     *
     */
    public function viewWithdrawAction() {

    }

}