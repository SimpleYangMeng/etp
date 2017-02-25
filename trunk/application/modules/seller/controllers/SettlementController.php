<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 2016-11-22
 * Time: 15:28
 */
class Seller_SettlementController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->_layoutObj       = Zend_Registry::get('layout');
        $this->tplDirectory     = "seller/views/settlement/";
        $this->_layoutFile      = 'supplier-left-widget';
        $this->_topTpl          = 'seller/views/layout/top.tpl';
        $this->_innerHeaderTpl  = 'seller/views/layout/header-inner.tpl';
        $this->_leftTpl         = 'seller/views/layout/left.tpl';
        $this->_footerTpl       = 'seller/views/layout/footer.tpl';
    }

    /**
     * @todo 结汇申请
     */
    public function settlementAction(){

        $balance = Service_SellerBalance::getByField($this->_customerAuth['account_id'], 'seller_id');
        //$this->view->currency = $this->_customerAuth['currency'];
        $this->view->cBalance = $balance['settling_value'];

        $currency = Service_Currency::getByField('USD','currency_code');

        $this->view->currency=$currency;
        $this->_layoutObj->activeMenu = 'menu_app_settlement';

        if( $this->_request->isPost() ) {

            $return = array('state'=>0, 'message' => Ec_Lang::getInstance()->getTranslate('fail'), 'error'=>array());
            $data = $this->getRequest()->getParam('data', '');



            /*print_r($data);
            exit;*/

            $data['seller_id'] = $this->_customerAuth['account_id'];
            $errorArr = Service_Settlement::validatorSettlement($data);
            if (!empty($errorArr)) {
                $return['error'] = Common_EtpCommon::transErrors($errorArr);
                die(Zend_Json::encode($return));
            }
            $maps = array(
                'seller_id'=>'sellerId',
                'needsettlingValue' => 'amount',
            );
            $apiObj = new Api_Settlement(array());
            $return = $apiObj->apply($data, $maps);
            if($return['state'] == 1){
                $return['message'] = Ec_Lang::getInstance()->getTranslate('success');
                $balance = Service_SellerBalance::getByField($this->_customerAuth['account_id'], 'seller_id');
                $return['balance'] = $balance['settling_value'];
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl(
            $this->tplDirectory . 'settlement.tpl',
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
     * @todo 结汇列表
     */
    public function listAction(){
        $this->_layoutObj->activeMenu = 'menu_settlement';
        if( $this->_request->isPost() ) {
            $return = array( 'state' => 0, 'data' => array(), 'msg' => '', 'total' => 0 );

            $page           = trim( $this->_request->getParam( 'page', 1 ) );
            $pageSize       = trim( $this->_request->getParam( 'pageSize', 20 ) );
            $sDate          = trim( $this->_request->getParam( 'cDateStart', '' ) );
            $eDate          = trim( $this->_request->getParam( 'cDateEnd', '' ) );
            $status          = trim( $this->_request->getParam( 'status', '' ) );
            $accountId      = $this->_customerAuth['account_id'];

            $addDate = Common_Common::getStartAndEndTime( $sDate, $eDate );

            $serviceObj = new Service_Settlement();
            $tmpFields = array(
                'settlement_id',
                'settlement_code',
                'status',
                'seller_id',
                'declare_comp_code',
                'declare_comp_name',
                'actual_settling_value',
                'actual_settling_currency',
                'settling_value',
                'settling_currency',
                'expect_settling_value',
                'expect_settling_currency',
                'handling_fee',
                'handling_fee_currency',
                'exchange_rate',
                'actual_exchange_rate',
                'note',
                'add_time',
                'update_time',
            );
            //$fields = $serviceObj->getYourFieldsAlias( $tmpFields );
            $fields = $serviceObj->getFieldsAlias($tmpFields);
            $condition['seller_id']         = $accountId;
            $condition['add_time_start']   = $addDate[0];
            $condition['add_time_end']      = $addDate[1];
            $condition['status']             = $status;

            $total = Service_Settlement::getByCondition( $condition, 'count(*)' );
            if( $total > 0 ) {
                $return['state'] = 1;
                $return['data'] = Service_Settlement::getByCondition( $condition, $fields, $pageSize, $page, 'settlement_id desc' );

                $currency =  Common_DataCache::getCurrencyMaps();
                $status = Common_DataCache::getBusinessStatusMap('settlement', 'status', array(1,2), true );
                //print_r($currency['CNY']);
                foreach( $return['data'] as $key => $value ) {
                    $return['data'][ $key ][ 'E2_0' ] = isset( $status[ $value['E2'] ] ) ? ( $this->language == 'zh_CN' ? $status[ $value['E2'] ]['bussiness_value_name'] :  $status[ $value['E2'] ]['bussiness_value_en'] ) : '-';
                    $return['data'][ $key ][ 'E7_0' ] = isset( $currency[ $value['E7'] ] ) ? ( $this->language == 'zh_CN' ? $currency[ $value['E7'] ]['currency_name'] :  $currency[ $value['E7'] ]['currency_name_en'] ) : '-';
                    $return['data'][ $key ][ 'E9_0' ] = isset( $currency[ $value['E9'] ] ) ? ( $this->language == 'zh_CN' ? $currency[ $value['E9'] ]['currency_name'] :  $currency[ $value['E9'] ]['currency_name_en'] ) : '-';
                    $return['data'][ $key ][ 'E11_0' ] = isset( $currency[ $value['E11'] ] ) ? ( $this->language == 'zh_CN' ? $currency[ $value['E11'] ]['currency_name'] :  $currency[ $value['E11'] ]['currency_name_en'] ) : '-';
                    $return['data'][ $key ][ 'E13_0' ] = isset( $currency[ $value['E13'] ] ) ? ( $this->language == 'zh_CN' ? $currency[ $value['E13'] ]['currency_name'] :  $currency[ $value['E13'] ]['currency_name_en'] ) : '-';
                }
            }

            $return['total'] = $total;


            /*foreach( $return['data'] as $key=>$value ) {
                $return['data'][$key]['C1'] = $value['C1'] == 1 ?  Ec_Lang::getInstance()->getTranslate('localWithdraw') : Ec_Lang::getInstance()->getTranslate('overseaWithdraw');
                $return['data'][$key]['C3'] = $currency[$value['C3']]['currency_symbol_left'];
            }*/
            $return['pageTotal'] = ceil( $return['total'] / $pageSize);
            die( json_encode( $return ) );
        }

        $this->_layoutObj->includeBsDate       = true;
        $this->_layoutObj->includeBsPage       = true;

        $status = Common_DataCache::getBusinessStatusMap('settlement', 'status', array(1,2), true );
        $this->view->status = $status;

        echo Ec::renderTpl(
            $this->tplDirectory . 'settlement-list.tpl',
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
     * @todo 结汇查看
     */
    public function viewDetailAction(){
        $settlement_id = trim( $this->_request->getParam( 'paramId', '' ) ) ;
        $settlement = array();
        $return = array('state'=>0, 'data'=> '', 'message'=> '');
        if( $settlement_id ) {
            $settlement = Service_Settlement::getByField($settlement_id);
            if( !empty( $settlement ) ) {
                $return['state'] = 1;
                $return['data'] = $settlement;
            }else{
                $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            }
        }
        $this->view->return = $return;
        $this->_layoutObj->activeMenu = 'menu_settlement';
        echo Ec::renderTpl(
            $this->tplDirectory . 'settlement_detail.tpl',
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
}