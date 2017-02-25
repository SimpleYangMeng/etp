<?php
/* @desc；采购商控制器
 * @date:2016-10-27
 */
class Buyer_WithdrawController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->_layoutFile      = 'purchaser-left-widget';
        $this->layoutObj = Zend_Registry::get('layout');

        $this->tplDirectory     = "buyer/views/withdraw/";

        $this->_topTpl          = 'buyer/views/layout/top.tpl';
        $this->_innerHeaderTpl  = 'buyer/views/layout/header-inner.tpl';
        $this->_leftTpl         = 'buyer/views/layout/left.tpl';
        $this->_footerTpl       = 'buyer/views/layout/footer.tpl';
    }

    /**
     * [foreignCashAction 申请境外提现]
     * @return [type] [description]
     */
    public function foreignWithdrawAction(){
        if(!$this->_customerAuth['has_pay_password']){
            $this->_redirect('/seller/portal/set-paypwd-notice');
            exit;
        }
        $this->view->languageTpl = $this->language;
        $this->view->country = Common_DataCache::getCountry();
        $layoutObj = Zend_Registry::get('layout');
        $layoutObj->activeMenu = 'menu_cash';
        $purchaserBalance = Service_BuyerBalance::getByField($this->_customerAuth['account_id'], 'buyer_id', array('cb_value'));
        $this->view->currency = $this->_customerAuth['currency'];
        $this->view->cBalance = $purchaserBalance['cb_value'];
        echo Ec::renderTpl(
            $this->tplDirectory . 'foreign_cash.tpl',
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
    }

    /**
     * [cashSubmitAction 提交申请]
     *
     * @return [type] [description]
     */
    public function cashSubmitAction(){
        $return = array('state'=>0, 'message' => Ec_Lang::getInstance()->getTranslate('appOWithdraw').Ec_Lang::getInstance()->getTranslate('fail'), 'error'=>array());
        $data = $this->getRequest()->getParam('data', '');
        $errorArr = Service_BuyerWithdraw::validator($data);
        if (!empty($errorArr)) {
            $return['error'] = Common_EtpCommon::transErrors($errorArr);
            die(Zend_Json::encode($return));
        }
        $data['visitor_type'] = $this->_customerAuth['account_type'];
        $data['account_id'] = $this->_customerAuth['account_id'];
        $data['withdraw_code'] = Common_GetNumbers::getCode('buyer_withdraw', 10, 'BW', '提现申请流水号');
        //买家默认境外 提现区域：境内1，境外2
        $data['areaType'] = 1;
        $data['currency'] = 'USD';

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

}