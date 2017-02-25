<?php
/* @desc: 订单授权检测-支付
 *
 */
class Default_OrderController extends Ec_Controller_DefaultAction
{

	public function preDispatch()
    {
        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        $this->language = empty($language) ? 'zh_CN' : $language;
        $this->tplDirectory	= "default/views/order/";
    }

    /**
     * [checkAuthAction 验证授权-签名]
     *
     *      $sign = strtoupper(md5(md5('orderCode=SOTCODE161201000055&timpstamp=1482356623256&signType=MD5')));
     *      $str = 'orderCode=SOTCODE161201000055&timpstamp=1482356623256&signType=MD5&sign='.$sign;
     *      http:/www.xxx.com/order/check-auth?code=$str
     *
     * @return [type] [description]
     */
    public function checkAuthAction(){
        /*
        $orderCode = $this->_request->getParam('orderCode', '');
        $timpstamp = $this->_request->getParam('timpstamp', '');
        $signType = $this->_request->getParam('signType', 'MD5');
        $sign = $this->_request->getParam('sign', '');
        */
        $encryptionCode = trim($this->getRequest()->getParam('code', ''));
        $return = $this->checkAuthInfo($encryptionCode);
        //验证成功
        if($return['state'] == 1){
            $this->authSuccess($return['orderCode']);
        //授权失败
        }else {
            $this->authFailed($return['message']);
        }
    }

    /**
     * [checkAuthInfo 检测授权]
     *
     * @return [type] [description]
     */
    private function checkAuthInfo($encryptionCode){
        $return = array('state'=>0, 'data'=> '', 'message'=> '');
        $parmsArr = array();
        if(!empty($encryptionCode)){
            parse_str(base64_decode($encryptionCode), $parmsArr);
        }
        if(empty($parmsArr) || !is_array($parmsArr) || !isset($parmsArr['timpstamp']) || !isset($parmsArr['orderCode']) || !isset($parmsArr['signType'])){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            return $return;
        }
        //1小时失效
        if((time() - $parmsArr['timpstamp'] > 3600)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('payLinkTimeOut');
            return $return;
        }
        $signStr = $parmsArr['sign'];
        unset($parmsArr['sign']);
        $temArr = array();
        foreach ($parmsArr as $key => $value) {
            $temArr[] = $key.'='.$value;
        }
        $temstr = join('&', $temArr);
        $trueSign = Common_Common::pwdAlgorithm( $temstr );
        if (strcasecmp($signStr, $trueSign)){
            $return['message'] = Ec_Lang::getInstance()->getTranslate('signError');
            return $return;
        }
        $return['state'] = 1;
        $return['orderCode'] = $parmsArr['orderCode'];
        return $return;
    }

    /**
     * [authFailed 验证失败]
     *
     * @return [type] [description]
     */
    private function authFailed($message = ''){
        $this->view->message = empty($message) ? Ec_Lang::getInstance()->getTranslate('authFiled') : $message;
        die(Ec::renderTpl($this->tplDirectory . "order_auth_failed.tpl", "layout-etp"));
    }

    /**
     * [authSuccess 验证成功]
     *
     * @return [type] [description]
     */
    private function authSuccess($orderCode){
        $return = array('state'=>0, 'data'=> '', 'message'=> '');
        $orderData = $this->getOrderRow($orderCode);
        $loginInfo = Service_Login::getLoginInfo();
        $isLogin = empty($loginInfo) ? false : true;
        //已经登陆调用绑定订单接口
        if($isLogin){
            $orderRow = Service_Orders::getByField($orderCode, 'order_code');
            if(empty($orderRow)){
                $this->authFailed(Ec_Lang::getInstance()->getTranslate('unkownOrder'));
            }
            /*
             * 支付订单验证支付密码时绑定订单
            /*
            //未绑定买家
            if(empty($orderRow['buyer_id']) || empty($orderRow['buyer_code'])){
                $orderRow['buyer_id'] = $loginInfo['account_id'];
                $orderRow['buyer_code'] = $loginInfo['account_code'];
                $maps = array(
                    'order_id' => 'orderId',
                    'buyer_code' => 'buyerCode'
                );
                $apiObj = new Api_Order(array('refcode' => $orderRow['order_code']));
                $return = $apiObj->bindOrder($orderRow, $maps);
                if($return['state'] != 1){
                    $message = '';
                    foreach ($return['error'] as $error) {
                        $message .= $error['errorCode'].':'.$error['errorMsg'];
                    }
                    $this->authFailed($message);
                }
            //已经绑定
            }else {
                if($orderRow['buyer_id'] != $loginInfo['account_id'] || $orderRow['buyer_code'] != $loginInfo['account_code']){
                    $this->authFailed(Ec_Lang::getInstance()->getTranslate('authFiled'));
                }
            }
            */
            $this->_redirect('/buyer/order/pay-order?orderCode='.$orderCode);
        //未登录
        }else {
            $this->view->callBackUrl = '/buyer/order/pay-order?orderCode='.$orderCode;
        }
        $this->view->isLogin = $isLogin;
        $this->view->return = $orderData;
        die(Ec::renderTpl($this->tplDirectory . "order_pay.tpl", "layout-etp"));
    }

    /**
     * [getOrderRow 订单基本信息]
     *
     * @param  [type] $orderCode [description]
     *
     * @return [type]            [description]
     */
    private function getOrderRow($orderCode){
        $return = array('state'=>0, 'data'=> '', 'msg'=> '');
        $ordersStatus = Common_DataCache::getBusinessStatus('orders', 'order_status', 1, 0, $this->language);
        $ordersPayStatus = Common_DataCache::getBusinessStatus('orders', 'pay_status', 1, 0, $this->language);
        $platefromData = Common_DataCache::getPlateform();
        if(!empty($orderCode)){
            $orderRow = Service_Orders::getByField($orderCode, 'order_code');
            if(!empty($orderRow)){
                if($orderRow['order_status'] != 1 || $orderRow['pay_status'] == 2 ){
                    $return['msg'] = sprintf(Ec_Lang::getInstance()->getTranslate('orderPaied'), $orderCode);
                }else {
                    $return['state'] = 1;
                    $orderRow['status_text'] = isset($ordersStatus[$orderRow['order_status']]) ? $ordersStatus[$orderRow['order_status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                    $orderRow['pay_status_text'] = isset($ordersPayStatus[$orderRow['pay_status']]) ? $ordersPayStatus[$orderRow['pay_status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                    $orderRow['platefrom'] = $platefromData[$orderRow['plate_code']];
                    $buyerRow = Service_Buyer::getByField($orderRow['buyer_code'], 'buyer_code', array('company_name'));
                    $orderRow['buyer_name'] = $orderRow['buyer_code'].'-'.$buyerRow['company_name'];
                    $return['data'] = $orderRow;
                }
            }else {
                $return['msg'] = Ec_Lang::getInstance()->getTranslate('unkownOrder');
            }
        }else {
            $return['msg'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        return $return;
    }
}