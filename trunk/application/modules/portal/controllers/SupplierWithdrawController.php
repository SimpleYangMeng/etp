<?php
/* @desc；供应商 卖家 国内 国外提现 提现申请列表 提现查看
 * @date:2016-10-27
 */
class Portal_SupplierWithdrawController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory     = "portal/views/supplier_withdraw/";
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
                'add_time',
                'amount',
                'status',
                'currency',
                'withdraw_type'
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
                if( isset( $value['C5'] ) ) {
                    $return['data'][$key]['C5'] = $value['C5'] == 1 ?  Ec_Lang::getInstance()->getTranslate('localWithdraw') : Ec_Lang::getInstance()->getTranslate('overseaWithdraw');
                }
                $return['data'][$key]['C4'] = $currency[$value['C4']]['currency_symbol_left'];
            }
            $return['pageTotal'] = ceil( $return['total'] / $pageSize);
            die( json_encode( $return ) );
        }

        $layoutObj                      = Zend_Registry::get('layout');
        $layoutObj->activeMenu          = 'menu_withdraw';
        $layoutObj->includeBsDate       = true;
        $layoutObj->includeBsPage       = true;

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
    public function viewWithdrawAction() {

    }
    /**
     * @todo 境内提现申请
     */
    public function internalWithDrawAction(){
        echo '境内提现申请';

        echo Ec::renderTpl(
            $this->tplDirectory . 'withdraw.tpl',
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
     * @todo 境外提现申请
     */
    public function foreignWithDrawAction(){
        $this->view->languageTpl = $this->language;
        $this->view->country = Common_DataCache::getCountry();
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_cash';
        $balance = Service_SellerBalance::getByField($this->_customerAuth['account_id'], 'seller_id');
        $this->view->currency = $this->_customerAuth['currency'];
        $this->view->cBalance = $balance['foreign_value'];
        if( $this->_request->isPost() ) {
            $return = array('state'=>0, 'message' => Ec_Lang::getInstance()->getTranslate('appOWithdraw').Ec_Lang::getInstance()->getTranslate('fail'), 'error'=>array());
            $data = $this->getRequest()->getParam('data', '');

            $data['visitor_type'] = $this->_customerAuth['account_type'];
            $data['account_id'] = $this->_customerAuth['account_id'];
            $data['withdraw_code'] = Common_GetNumbers::getCode('buyer_withdraw', 10, 'BW', '提现申请流水号');
            //买家默认境外 提现区域：境内1，境外2
            $data['areaType'] = 2;
            $data['currency'] = 'USD';

            $errorArr = Service_BuyerWithdraw::validatorforeignwithdraw($data);
            if (!empty($errorArr)) {
                $return['error'] = Common_EtpCommon::transErrors($errorArr);
                die(Zend_Json::encode($return));
            }
            $maps = array(
                'visitor_type' => 'userType',
                'areaType' => 'areaType',
                'account_id' => 'userId',
                'bank_card'=>'bankCardNo',
                'bank_name'=>'bankName',
                'bank_buyer_name'=>'bankCustomerName',
                'country_id'=>'countryId',
                'withdraw_code' => 'withdrawCode',
                'currency' => 'currency',
                'amount'=>'amount',
                'note'=>'note'
            );




            $apiObj = new Api_Withdraw(array());
            $return = $apiObj->apply($data, $maps);
            if($return['state'] == 1){
                $return['message'] = Ec_Lang::getInstance()->getTranslate('appOWithdraw').Ec_Lang::getInstance()->getTranslate('success');
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl(
            $this->tplDirectory . 'foreigin_withdraw.tpl',
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