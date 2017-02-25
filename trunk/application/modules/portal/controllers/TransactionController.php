<?php
/* @desc；交易控制器(提现之类的)
 * @date:2016-10-27
 */
class Portal_TransactionController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->tplDirectory = "portal/views/transaction/";
        $this->includeTplForLayout = "portal/views/default/";
        $this->layoutObj = Zend_Registry::get('layout');
        $this->menuPurchaserPayOrder = 'menu_purchaser_pay_order';
        $this->_layoutFile = '';
        $this->_leftTpl = '';
        if( $this->_customerAuth['account_type'] == 1 ) {
            $this->_layoutFile     = 'purchaser-left-widget';
            $this->_leftTpl = 'left_buyer.tpl';
        } else {
            $this->_layoutFile     = 'supplier-left-widget';
            $this->_leftTpl = 'left.tpl';
        }
    }

    /* @desc:境内提现申请
     *
     */
    public function withdrawAction() {

        echo Ec::renderTpl(
            $this->tplDirectory . 'withdraw.tpl',
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top' => $this->includeTplForLayout.'top.tpl',
                'innerHeader' => $this->includeTplForLayout.'header-inner.tpl',
                'left' => $this->includeTplForLayout.$this->_leftTpl,
                'footer' => $this->includeTplForLayout.'footer.tpl',
            )
        );
    }

    /* @desc:境外提现申请
     *
     */
    public function oWithdrawAction() {

    }

    /* @desc:处理提现申请
     *
     */
    public function submitApplicationAction() {
        $bankName               = trim( $this->_request->getParam( 'bankName', '' ) );//银行名字
        $bankAccountName        = trim( $this->_request->getParam( 'bankAccountName', '' ) );//银行账号开户名
        $bankAccount            = trim( $this->_request->getParam( 'bankAccount', '' ) );//银行账号
        $amount                 = trim( $this->_request->getParam( 'amount', '' ) );//提现金额

        $param = array(
            'bankName'              => $bankName,
            'bankAccountName'      => $bankAccountName,
            'bankAccount'           => $bankAccount,
            'amount'                 => $amount,
        );
        $obj            = new Service_WithdrawProcess();
        $result         = $obj->dealWithdraw( $param );
        die( json_encode( $result ) );
    }

    /* @desc；账户充值
     *
     */
    public function creditAction() {

    }

    /* @desc；订单支付
     *
     */
    public function orderPaymentAction() {

    }


    /**
     * [purchaserPayOrderDetailAction 支付单详情]
     *
     * @return [type] [description]
     */
    public function purchaserPayOrderDetailAction(){
        $return = array('state'=>0, 'data'=> '', 'message'=> 'No data');
        $payStatus = Common_DataCache::getBusinessStatus('order_pay', 'status', 1, 0, $this->language);
        $parmId = $this->_request->getParam('parmId', 0);
        if(!empty($parmId)){
            $orderPayRow = Service_OrderPay::getByField($parmId, 'order_pay_id');
            if(!empty($orderPayRow)){
                $return['state'] = 1;
                $orderPayRow['status_text'] = isset($payStatus[$orderPayRow['status']]) ? $payStatus[$orderPayRow['status']] : Ec_Lang::getInstance()->getTranslate('undefine');;
                $return['data'] = $orderPayRow;
            }else {
                $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            }
        }else {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        //菜单样式
        $this->layoutObj->activeMenu = $this->menuPurchaserPayOrder;
        $this->view->return = $return;
        echo Ec::renderTpl(
            $this->tplDirectory . 'purchaser_pay_order_detail.tpl',
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