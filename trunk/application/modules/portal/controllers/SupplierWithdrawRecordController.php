<?php
/* @desc；供应商日志管理器
 * @date:2016-10-27
 */
class Portal_SupplierWithdrawRecordController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->_layoutObj        = Zend_Registry::get('layout');
        $this->tplDirectory     = "portal/views/supplier_withdraw_record/";
        $this->_layoutFile      = 'supplier-left-widget';
        $this->_topTpl          = 'portal/views/default/top.tpl';
        $this->_innerHeaderTpl  = 'portal/views/default/header-inner.tpl';
        $this->_leftTpl         = 'portal/views/default/left.tpl';
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
            $withdrawType   = trim( $this->_request->getParam( 'withdrawType', '' ) );
            $status         = trim( $this->_request->getParam( 'status', '' ) );
            $sDate          = trim( $this->_request->getParam( 'cDateStart', '' ) );
            $eDate          = trim( $this->_request->getParam( 'cDateEnd', '' ) );
            $accountId      = $this->_customerAuth['account_id'];

            $serviceObj = new Service_SellerWithdraw();
            $tmpFields = array(
                'withdraw_code',
                'withdraw_type',
                'add_time',
                'currency',
                'amount',
                'status'
            );
            $fields = $serviceObj->getYourFieldsAlias( $tmpFields );

            $condition['seller_id']         = $accountId;
            $condition['bank_buyer_name']  = $bankAccount;
            $condition['add_time_start']   = $sDate;
            $condition['add_time_end']      = $eDate;
            $condition['withdraw_type']     = $withdrawType;
            $condition['status']             = $status;

            $total = Service_SellerWithdraw::getByCondition( $condition, 'count(*)' );
            if( $total > 0 ) {
                $return['state'] = 1;
                $return['data'] = Service_SellerWithdraw::getByCondition( $condition, $fields, $pageSize, $page, 'seller_withdraw_id desc' );
            }

            $return['total'] = $total;

            $currency =  Common_DataCache::getCurrencyMaps();
            foreach( $return['data'] as $key=>$value ) {
                $return['data'][$key]['C1'] = $value['C1'] == 1 ?  Ec_Lang::getInstance()->getTranslate('localWithdraw') : Ec_Lang::getInstance()->getTranslate('overseaWithdraw');
                $return['data'][$key]['C3'] = $currency[$value['C3']]['currency_symbol_left'];
            }
            $return['pageTotal'] = ceil( $return['total'] / $pageSize);
            die( json_encode( $return ) );
        }

        $this->_layoutObj->activeMenu          = 'menu_withdraw';
        $this->_layoutObj->includeBsDate       = true;
        $this->_layoutObj->includeBsPage       = true;

        $condition        =  array( 'bussiness_table'=>'seller_withdraw ','bussiness_column'=>'status' );
        $withdrawType     = array(1=>Ec_Lang::getInstance()->getTranslate('localWithdraw'),2=>Ec_Lang::getInstance()->getTranslate('overseaWithdraw'));

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
                'top'           => $this->_topTpl,
                'innerHeader'   => $this->_innerHeaderTpl,
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
    public function viewDetailAction() {
        $withdrawCode = trim( $this->_request->getParam( 'paramId', '' ) ) ;
        $withdraw = $withdrawType = $status = array();
        if( $withdrawCode ) {
            $tmpRow = Service_SellerWithdraw::getByCondition(
                array(
                    'seller_id'=>$this->_customerAuth['account_id'],
                    'withdraw_code'=> $withdrawCode
                )
            );
            if( !empty( $tmpRow ) ) {
                $withdraw = $tmpRow[0];
                $condition        =  array( 'bussiness_table'=>'seller_withdraw ','bussiness_column'=>'status','bussiness_value'=>$withdraw['status'] );
                $statusRow        = Service_BussinessStatus::getByCondition( $condition );
                $withdraw['status'] = $this->language == 'zh_CN' ? $statusRow[0]['bussiness_value_name'] : $statusRow[0]['bussiness_value_en'];
                $withdraw['withdraw_type'] = $withdraw['withdraw_type'] == 1 ? Ec_Lang::getInstance()->getTranslate('localWithdraw') : Ec_Lang::getInstance()->getTranslate('overseaWithdraw');

            }
        }
        $currency = Common_DataCache::getCurrencyMaps( $withdraw['currency'] );
        $this->view->withdraw       = $withdraw;
        $this->view->currency = $currency;
        $this->_layoutObj->activeMenu          = 'menu_withdraw';

        echo Ec::renderTpl(
            $this->tplDirectory . 'withdraw_detail.tpl',
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