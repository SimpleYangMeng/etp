<?php
/* @desc；采购商（买家）日志管理器
 * @date:2016-10-27
 */
class Buyer_WithdrawRecordController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        //不是对应买家的请跳转或抛出页面不存在的异常
        $this->_layoutObj       = Zend_Registry::get('layout');
        $this->tplDirectory     = "buyer/views/withdraw_record/";

        $this->_layoutFile      = 'purchaser-left-widget';
        $this->_topTpl          = 'buyer/views/layout/top.tpl';
        $this->_innerHeaderTpl  = 'buyer/views/layout/header-inner.tpl';
        $this->_leftTpl         = 'buyer/views/layout/left.tpl';
        $this->_footerTpl       = 'buyer/views/layout/footer.tpl';
    }

    /* @desc:提现状态管理
     *
     */
    public function withdrawListAction() {
        $withdrawType = Common_DataCache::getBusinessStatus('buyer_withdraw', 'withdraw_type', 1, 0, $this->language);
        //获取登录账户的转账信息
        if( $this->_request->isPost() ) {
            $return = array( 'state' => 0, 'data' => array(), 'msg' => '', 'total' => 0 );

            $page           = trim( $this->_request->getParam( 'page', 1 ) );
            $pageSize       = trim( $this->_request->getParam( 'pageSize', 20 ) );
            $bankAccount    = trim( $this->_request->getParam( 'cardNo', '' ) );
            $sDate          = trim( $this->_request->getParam( 'cDateStart', '' ) );
            $eDate          = trim( $this->_request->getParam( 'cDateEnd', '' ) );
            $status          = trim( $this->_request->getParam( 'status', '' ) );
            $withdraw_type = $this->_request->getParam( 'withdrawType', '' );
            $accountId = $this->_customerAuth['account_id'];

            $addDate = Common_Common::getStartAndEndTime( $sDate, $eDate );

            $condition = array();
            $serviceObj = new Service_BuyerWithdraw();
            $tmpFields = array(
                'withdraw_code',
                'add_time',
                'amount',
                'status',
                'currency',
                'withdraw_type'
            );
            $fields = $serviceObj->getFieldsAlias( $tmpFields );
            $condition['buyer_id'] = $accountId;
            $condition['bank_buyer_name'] = $bankAccount;
            $condition['add_time_start'] = $addDate[0];
            $condition['add_time_end'] = $addDate[1];
            if(!empty($status)){
                $condition['status'] = explode(',', $status);
            }
            $condition['withdraw_type'] = $withdraw_type;
            $total = Service_BuyerWithdraw::getByCondition( $condition, 'count(*)' );
            if( $total > 0 ) {
                $return['state'] = 1;
                $return['data'] = Service_BuyerWithdraw::getByCondition( $condition, $fields, $pageSize, $page, 'buyer_withdraw_id desc' );
            }
            $return['total'] = $total;
            $currency =  Common_DataCache::getCurrencyMaps();
            $tags = Common_DataCache::getBusinessStatusMap( 'buyer_withdraw', 'status', '', true );
            foreach( $return['data'] as $key => $value ) {
                $return['data'][$key]['E8'] = $currency[$value['E8']]['currency_symbol_left'];
                $return['data'][$key]['E3'] = isset( $tags[ $value['E3'] ] ) ? ( $this->language == 'zh_CN' ? $tags[ $value['E3'] ]['bussiness_value_name'] : $tags[ $value['E3'] ]['bussiness_value_en']) : '';
                $return['data'][$key]['E12'] = isset($withdrawType[$value['E12']]) ? $withdrawType[$value['E12']] : Ec_Lang::getInstance()->getTranslate('undefine');
            }
            $return['pageTotal'] = ceil( $return['total'] / $pageSize);
            die( json_encode( $return ) );
        }
        $this->_layoutObj->activeMenu          = 'menu_cash_list';
        $this->_layoutObj->includeBsDate       = true;
        $this->_layoutObj->includeBsPage       = true;
        //$tags = Common_DataCache::getBusinessStatusMap( 'buyer_withdraw', 'status', array(1,2), true );
        //特殊处理
        $tags = array(
            0 => array(
                'bussiness_value' => '1,2,3',
                'bussiness_value_name' => '汇总中',
                'bussiness_value_en' => 'In summary',
            ),
            1 => array(
                'bussiness_value' => '4',
                'bussiness_value_name' => '成功',
                'bussiness_value_en' => 'Success',
            ),
            2 => array(
                'bussiness_value' => '5,6',
                'bussiness_value_name' => '失败',
                'bussiness_value_en' => 'Failed',
            ),
        );
        $this->view->withdrawType = $withdrawType;
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

    /* @desc:查看提现明细
     *
     */
    public function viewDetailAction() {
        $withdrawCode = trim( $this->_request->getParam( 'paramId', '' ) ) ;
        $withdraw  = $currency = array();
        if( $withdrawCode ) {
            $tmpRow = Service_BuyerWithdraw::getByCondition(
                array(
                    'buyer_id'=>$this->_customerAuth['account_id'],
                    'withdraw_code'=> $withdrawCode
                )
            );
            if( !empty( $tmpRow ) ) {
                $withdraw                       = $tmpRow[0];
                $status                         =  Common_DataCache::getBusinessStatusMap( 'buyer_withdraw', 'status', '', true );
                $withdraw['status']            = isset( $status[ $withdraw['status'] ] ) ? ( $this->language == 'zh_CN' ? $status[ $withdraw['status'] ]['bussiness_value_name'] : $status[ $withdraw['status'] ]['bussiness_value_en']) : '';
                $withdraw['withdraw_type']    = Ec_Lang::getInstance()->getTranslate('overseasWithdraw');
                $currency = Common_DataCache::getCurrencyMaps( $withdraw['currency'] );
            }
        }
        $this->view->withdraw       = $withdraw;
        $this->view->currency = $currency;
        $this->_layoutObj->activeMenu          = 'menu_cash_list';

        echo Ec::renderTpl(
            $this->tplDirectory . 'withdraw_detail.tpl',
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