<?php
/* @desc；供应商日志管理器
 * @date:2016-10-27
 */
class Seller_WithdrawRecordController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->_layoutObj        = Zend_Registry::get('layout');
        $this->tplDirectory     = "seller/views/withdraw_record/";
        $this->_layoutFile      = 'supplier-left-widget';
        $this->_topTpl          = 'seller/views/layout/top.tpl';
        $this->_innerHeaderTpl  = 'seller/views/layout/header-inner.tpl';
        $this->_leftTpl         = 'seller/views/layout/left.tpl';
        $this->_footerTpl       = 'seller/views/layout/footer.tpl';
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
            $withdrawType   = trim( $this->_request->getParam( 'withdrawType', '' ) );
            $status         = trim( $this->_request->getParam( 'status', '' ) );
            $sDate          = trim( $this->_request->getParam( 'cDateStart', '' ) );
            $eDate          = trim( $this->_request->getParam( 'cDateEnd', '' ) );
            $status          = trim( $this->_request->getParam( 'status', '' ) );
            $accountId      = $this->_customerAuth['account_id'];

            $addDate = Common_Common::getStartAndEndTime( $sDate, $eDate );

            $serviceObj = new Service_SellerWithdraw();
            $tmpFields = array(
                'withdraw_code',
                'withdraw_type',
                'add_time',
                'currency',
                'amount',
                'status'
            );
            $fields = $serviceObj->getFieldsAlias( $tmpFields );

            $condition['seller_id']         = $accountId;
            $condition['add_time_start']   = $addDate[0];
            $condition['add_time_end']      = $addDate[1];
            $condition['withdraw_type']     = $withdrawType;
            //$condition['status']             = $status == 2 ? array(1,2,3) : $status;
            if(!empty($status)){
                $condition['status'] = explode(',', $status);
            }
            $total = Service_SellerWithdraw::getByCondition( $condition, 'count(*)' );
            if( $total > 0 ) {
                $return['state'] = 1;
                $return['data'] = Service_SellerWithdraw::getByCondition( $condition, $fields, $pageSize, $page, 'seller_withdraw_id desc' );
            }

            $return['total'] = $total;

            $currency =  Common_DataCache::getCurrencyMaps();
            $tags = Common_DataCache::getBusinessStatusMap( 'seller_withdraw', 'status', '', true );
            foreach( $return['data'] as $key=>$value ) {
                $return['data'][$key]['E3'] = $value['E3'] == 1 ?  Ec_Lang::getInstance()->getTranslate('localWithdraw') : Ec_Lang::getInstance()->getTranslate('overseaWithdraw');
                $return['data'][$key]['E11'] = $currency[$value['E11']]['currency_symbol_left'];
                if( $value['E5'] == 1 || $value['E5'] == 2 || $value['E5'] == 3 ) {
                    $return['data'][$key]['E5'] = Ec_Lang::getInstance()->getTranslate('withdrawing');
                } else {
                    $return['data'][$key]['E5'] = isset( $tags[ $value['E5'] ] ) ? ( $this->language == 'zh_CN' ? $tags[ $value['E5'] ]['bussiness_value_name'] : $tags[ $value['E5'] ]['bussiness_value_en']) : '';
                }
            }
            $return['pageTotal'] = ceil( $return['total'] / $pageSize);
            die( json_encode( $return ) );
        }

        $this->_layoutObj->activeMenu          = 'menu_withdraw';
        $this->_layoutObj->includeBsDate       = true;
        $this->_layoutObj->includeBsPage       = true;

        $withdrawType     = array(1=>Ec_Lang::getInstance()->getTranslate('localWithdraw'),2=>Ec_Lang::getInstance()->getTranslate('overseaWithdraw'));

        //$tags = Common_DataCache::getBusinessStatusMap( 'seller_withdraw', 'status', '', true );
        //特殊处理
        $tags = array(
            0 => array(
                'bussiness_value' => '1,3,5',
                'bussiness_value_name' => '提现中',
                'bussiness_value_en' => 'In summary',
            ),
            1 => array(
                'bussiness_value' => '7',
                'bussiness_value_name' => '成功',
                'bussiness_value_en' => 'Success',
            ),
            2 => array(
                'bussiness_value' => '9',
                'bussiness_value_name' => '失败',
                'bussiness_value_en' => 'Failed',
            ),
        );
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

    /* @desc:查看提现明细
     *
     */
    public function viewDetailAction() {
        $withdrawCode = trim( $this->_request->getParam( 'paramId', '' ) ) ;
        $withdraw = $currency = array();
        if( $withdrawCode ) {
            $tmpRow = Service_SellerWithdraw::getByCondition(
                array(
                    'seller_id'=>$this->_customerAuth['account_id'],
                    'withdraw_code'=> $withdrawCode
                )
            );
            if( !empty( $tmpRow ) ) {
                $withdraw                        = $tmpRow[0];
                $status                          =  Common_DataCache::getBusinessStatusMap( 'seller_withdraw', 'status', '', true );
                $withdraw['status']            = isset( $status[ $withdraw['status'] ] ) ? ( $this->language == 'zh_CN' ? $status[ $withdraw['status'] ]['bussiness_value_name'] : $status[ $withdraw['status'] ]['bussiness_value_en']) : '';
                $withdraw['withdraw_type']    = $withdraw['withdraw_type'] == 1 ? Ec_Lang::getInstance()->getTranslate('localWithdraw') : Ec_Lang::getInstance()->getTranslate('overseaWithdraw');

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