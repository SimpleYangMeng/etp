<?php
/* @desc；供应商 卖家 国内 国外提现 提现申请列表 提现查看
 * @date:2016-10-27
 */
class Seller_WithdrawController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->_layoutObj       = Zend_Registry::get('layout');
        $this->tplDirectory     = "seller/views/withdraw/";
        $this->_layoutFile      = 'supplier-left-widget';
        $this->_topTpl          = 'seller/views/layout/top.tpl';
        $this->_innerHeaderTpl  = 'seller/views/layout/header-inner.tpl';
        $this->_leftTpl         = 'seller/views/layout/left.tpl';
        $this->_footerTpl       = 'seller/views/layout/footer.tpl';
    }

    /**
     * @todo 境内提现申请
     */
    public function internalWithdrawAction(){
        //exit;
        //$this->tplDirectory . 'withdraw.tpl',
        //bankAccount
        $bankAccount = $accountNo = $accountNoId = array();
        $accountRows = Service_PaJzbAccount::getByCondition( array( 'seller_id' => $this->_customerAuth['account_id'] ), array('account_id','account_no') );
        foreach( $accountRows as $value ) {
            if( $value['account_no'] == '' ) continue;
            if( in_array( $value['account_no'], $accountNo ) ) continue;
            $bankAccountRow = Service_PaJzbBankCard::getByCondition( array( 'account_no' => $value['account_no'],'status'=>'2' ) );
            $accountNoId[$value['account_no']] = $value['account_id'];
            $bankAccount = array_merge( $bankAccount, $bankAccountRow );
            $accountNo[] = $value['account_no'];
        }

        $this->_layoutObj->activeMenu = 'menu_app_withdraw';

        $this->view->bankAccount = $bankAccount;
        $this->view->hasSubAccount = empty( $accountNo ) ? false : true ;
        $this->view->languageTpl = $this->language;
        $this->view->accountNoId = $accountNoId;
        $currency = Common_DataCache::getCurrencyMaps();
        $balance = Service_SellerBalance::getByField($this->_customerAuth['account_id'], 'seller_id');
        $this->view->currency = isset( $currency[$balance['internal_value_currency']] ) ? $currency[$balance['internal_value_currency']] : array();
        $this->view->cBalance = $balance['internal_value'];
        if( $this->_request->isPost() ) {
            $return = array('state'=>0, 'message' => Ec_Lang::getInstance()->getTranslate('fail'), 'error'=>array());
            $data = $this->getRequest()->getParam('data', '');

            $data['visitor_type'] = $this->_customerAuth['account_type'];
            $data['account_id'] = $this->_customerAuth['account_id'];
            $data['withdraw_code'] = Common_GetNumbers::getCode('buyer_withdraw', 10, 'SW', '提现申请流水号');
            //买家默认境外 提现区域：境内1，境外2
            $data['areaType'] = 1;
            $data['currency'] = 'CNY';
            $data['country_id'] = 49;//默认中国

            $errorArr = Service_SellerWithdraw::validatorinternalwithdraw($data);
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
                $return['message'] = Ec_Lang::getInstance()->getTranslate('success');
            }
            die(Zend_Json::encode($return));
        }
        echo Ec::renderTpl(
            $this->tplDirectory . 'internal_withdraw.tpl',
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
    public function foreignWithdrawAction(){
        if( $this->_request->isPost() ) {
            $return = array('state'=>0, 'message' => Ec_Lang::getInstance()->getTranslate('appOWithdraw').Ec_Lang::getInstance()->getTranslate('fail'), 'error'=>array());
            $data = $this->getRequest()->getParam('data', '');

            $data['visitor_type'] = $this->_customerAuth['account_type'];
            $data['account_id'] = $this->_customerAuth['account_id'];
            $data['withdraw_code'] = Common_GetNumbers::getCode('buyer_withdraw', 10, 'BW', '提现申请流水号');
            //买家默认境外 提现区域：境内1，境外2
            $data['areaType'] = 2;
            $data['currency'] = 'USD';

            $errorArr = Service_SellerWithdraw::validatorforeignwithdraw($data);
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
                $balance = Service_SellerBalance::getByField($this->_customerAuth['account_id'], 'seller_id');
                $return['balance'] = $balance['foreign_value'];
            }
            die(Zend_Json::encode($return));
        }

        $this->view->country = Common_DataCache::getCountry();
        $this->_layoutObj->activeMenu = 'menu_app_owithdraw';

        $currency = Common_DataCache::getCurrencyMaps();
        $balance = Service_SellerBalance::getByField($this->_customerAuth['account_id'], 'seller_id');
        $this->view->currency = isset( $currency[$this->_customerAuth['currency']] ) ? $currency[$this->_customerAuth['currency']] : array();
        $this->view->cBalance = $balance['foreign_value'];

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