<?php
class Default_ForgetPasswordController extends Ec_Controller_DefaultAction
{
	// --------------------------------------------------------------------
	public function preDispatch()
    {
        $this->tplDirectory	= "default/views/forgetpassword/";
    }

    /**
     * 忘记密码首页
     * @access  public
     * @return  resource
     */
    public function indexAction()
    {
        $this->view->visitor_type = $this->getRequest()->getParam('visitor_type', 1);
        echo Ec::renderTpl($this->tplDirectory . "index.tpl", 'layout-etp');
    }

	/**
     * 忘记密码验证用户名【即邮箱】和验证码的正确性
     *
     */
    public function confirmUserAction()
    {
        $result = array("state"=>0, "message"=>"", 'error'=>array());
		$data = $this->getRequest()->getParam('data');
        if(empty($data) || !is_array($data)){
            $result['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            die(json_encode($result));
        }
        $verify = new Common_Verifycode();
		$verifyState	= $verify->is_true($data['verify']);
        if(!$verifyState){
           $result['message'] = Ec_Lang::getInstance()->getTranslate('VerifyCode').Ec_Lang::getInstance()->getTranslate('error');
           die(json_encode($result));
        }
        $accountType = $data['visitor_type'];
        $accountCode = $data['accountCode'];
        $email = $data['email'];
		if(empty($accountType) || empty($accountCode) || empty($email)){
            $result['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            die(json_encode($result));
        }
        switch ($accountType) {
            case '1':
                $accountRow = Service_Buyer::getByWhere(array('buyer_code' => $accountCode, 'email' => $email));
                break;
            case '2':
                $accountRow = Service_Seller::getByWhere(array('seller_code' => $accountCode, 'email' => $email));
                break;
            default:
                $accountRow = array();
                break;
        }
		if(!$accountRow){
			$result['message'] = Ec_Lang::getInstance()->getTranslate('accountNotExist');
		}else{
            //发送验证邮件
            $sendRes = $this->sendEmail($accountType, $accountRow);
            if($sendRes){
                $result['state'] = 1;
                $result['message'] = Ec_Lang::getInstance()->getTranslate('sendEmailSuccess');
            }else {
                $result['message'] = Ec_Lang::getInstance()->getTranslate('sendEmailFile');
            }
		}
		die(json_encode($result));
    }

   /**
    * [sendEmail 发送邮件]
    *
    * @return [type] [description]
    */
	private function sendEmail($accountType, $accountRow)
	{
        //记录日志
        switch ($accountType) {
            case '1':
                $accountId = $accountRow['buyer_id'];
                $accountCode = $accountRow['buyer_code'];
                $buyerLogRow = array(
                    'buyer_id' => $accountRow['buyer_id'],
                    'buyer_code' => $accountRow['buyer_code'],
                    'operate_code' => $accountRow['buyer_code'],
                    'bl_note' => Ec_Lang::getInstance()->getTranslate('findPassword'),
                    'add_time' => date('Y-m-d H:i:s'),
                );
                Service_BuyerLog::add($buyerLogRow);
                break;
            case '2':
                $accountId = $accountRow['seller_id'];
                $accountCode = $accountRow['seller_code'];
                $sellerLogRow = array(
                    'seller_id' => $accountRow['seller_id'],
                    'seller_code' => $accountRow['seller_code'],
                    'operate_code' => $accountRow['seller_code'],
                    'sl_note' => Ec_Lang::getInstance()->getTranslate('findPassword'),
                    'add_time' => date('Y-m-d H:i:s'),
                );
                Service_SellerLog::add($sellerLogRow);
                break;
            default:
                die("<script>alert('".Ec_Lang::getInstance()->getTranslate('sendEmailFile')."');window.history.back();</script>");
                break;
        }
        //$activeurl = 'http://'.$_SERVER['HTTP_HOST'].'/register/activate?code='.$code.'&time='.time().'&visitor_type='.$visitor_type.'&visitor_id='.$id;
        //echo $activeurl;
        //die();
        $str = 'code='.$accountCode.'&time='.time().'&visitor_type='.$accountType.'&visitor_id='.$accountId;
        $sign = Common_Common::pwdAlgorithm($str);
        $encryptionCode = base64_encode($str.'&sign='.$sign);
        $activeurl = 'http://'.$_SERVER['HTTP_HOST'].'/forget-password/activate?code='.$encryptionCode;
        $activeHtml = "<a href='$activeurl' target='_blank'>{$activeurl}</a>";
        $emailContent = sprintf(Ec_Lang::getInstance()->getTranslate('forgetEmailContent'), $activeHtml);
        $params = array(
            'bodyType' => 'html',
            'email' => array($accountRow['email']),
            'subject' => Ec_Lang::getInstance()->getTranslate('forgetEmailSubject'),
            'body' => $emailContent,
        );
        $state = Common_Email::sendMail($params);
        if (empty($state)) {
            return false;
        } else {
            return true;
        }
	}

    /**
     * [activeAction 验证邮箱]
     *
     * @return [type] [description]
     */
    public function activateAction(){
        $encryptionCode = trim($this->getRequest()->getParam('code', ''));
        $parmsArr = array();
        if(!empty($encryptionCode)){
            parse_str(base64_decode($encryptionCode), $parmsArr);
        }
        $this->view->is_show_next = 0;
        if(empty($parmsArr) || !is_array($parmsArr)){
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('paramsError');
            die(Ec::renderTpl($this->tplDirectory . "notice.tpl", 'layout-etp'));
        }
        $code = isset($parmsArr['code']) && !empty($parmsArr['code']) ? $parmsArr['code'] : '';
        $time = isset($parmsArr['time']) && !empty($parmsArr['time']) ? $parmsArr['time'] : '';
        $visitor_type = isset($parmsArr['visitor_type']) && !empty($parmsArr['visitor_type']) ? $parmsArr['visitor_type'] : '';
        $visitor_id = isset($parmsArr['visitor_id']) && !empty($parmsArr['visitor_id']) ? $parmsArr['visitor_id'] : '';
        if (empty($visitor_id) || empty($visitor_type)) {
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('paramsError');
            die(Ec::renderTpl($this->tplDirectory . "notice.tpl", 'layout-etp'));
        }
        // 5 分钟失效
        if((time() - $parmsArr['time'] > 600)){
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('forgetPasswordLinkTimeOut');
            die(Ec::renderTpl($this->tplDirectory . "notice.tpl", 'layout-etp'));
        }

        //验证签名
        if(!$this->checkSign($parmsArr)){
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('forgetSignError');
            die(Ec::renderTpl($this->tplDirectory . "notice.tpl", 'layout-etp'));
        }
        $this->view->data = $parmsArr;
        $this->view->is_show_next = 1;
        $this->view->notice = Ec_Lang::getInstance()->getTranslate('forgetActiveSuccess');
        die(Ec::renderTpl($this->tplDirectory . "notice.tpl", 'layout-etp'));
    }

    /**
     * [checkSign 验证签名]
     *
     * @param  [type] $parmsArr [description]
     *
     * @return [type]           [description]
     */
    private function checkSign($parmsArr){
        $signStr = $parmsArr['sign'];
        unset($parmsArr['sign']);
        $temArr = array();
        foreach ($parmsArr as $key => $value) {
            $temArr[] = $key.'='.$value;
        }
        $temstr = join('&', $temArr);
        $trueSign = Common_Common::pwdAlgorithm( $temstr );
        if (strcasecmp($signStr, $trueSign)){
            return false;
        }
        return true;
    }

    /**
     * [resetPwdAction 重置登陆密码]
     *
     * @return [type] [description]
     */
    public function resetPwdAction(){
        $result = array( 'state'=>0, 'message'=>Ec_Lang::getInstance()->getTranslate('submit').Ec_Lang::getInstance()->getTranslate('fail'));
        $verifyCode = $this->getRequest()->getParam('verify', '');
        $verify = new Common_Verifycode();
        $verifyState = $verify->is_true($verifyCode);
        if(!$verifyState){
           $result['message'] = Ec_Lang::getInstance()->getTranslate('VerifyCode').Ec_Lang::getInstance()->getTranslate('error');
           die(json_encode($result));
        }
        $accountType = $this->getRequest()->getParam('accountType', '');
        $accountId = $this->getRequest()->getParam('accountId', '');
        if(empty($accountId) || empty($accountType)){
            $result['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            die(json_encode($result));
        }
        switch ($accountType) {
            case '1':
                $accountRow = Service_Buyer::getByField($accountId, 'buyer_id', array('buyer_id', 'password'));
                break;
            case '2':
                $accountRow = Service_Seller::getByField($accountId, 'seller_id', array('seller_id', 'password'));
                break;
            default:
                $accountRow = array();
                break;
        }
        if(empty($accountRow)){
            $result['message'] = Ec_Lang::getInstance()->getTranslate('accountNotExist');
            die(json_encode($result));
        }
        $oldLoginPwd = $accountRow['password'];
        $newLoginPwd = $this->getRequest()->getParam('newLoginPwd', '');
        $reLoginNewPwd = $this->getRequest()->getParam('reLoginPwd', '');
        if(empty($newLoginPwd) || empty($reLoginNewPwd)){
            $result['message'] = Ec_Lang::getInstance()->getTranslate('newLoginPwd').Ec_Lang::getInstance()->getTranslate('require');
            die(json_encode($result));
        }
        if(strcasecmp($newLoginPwd, $reLoginNewPwd)){
            $result['message'] = Ec_Lang::getInstance()->getTranslate('TwoPass');
            die(json_encode($result));
        }
        $data = array(
            'account_id' => '',
            'oldLoginPwd' => $oldLoginPwd,
            'newLoginPwd' => Common_Common::pwdAlgorithm($newLoginPwd),
            'reLoginPwd' => Common_Common::pwdAlgorithm($reLoginNewPwd),
        );
        $maps = array(
            'account_id' => 'buyerId',
            'oldLoginPwd' => 'oldPassword',
            'newLoginPwd' => 'newPassword'
        );
        // buyer
        if($accountType == '1'){
            $data['account_id'] = $accountRow['buyer_id'];
            $maps['account_id'] = 'buyerId';
            $apiObj = new Api_Buyer(array());
        //seller
        }else {
            $data['account_id'] = $accountRow['seller_id'];
            $maps['account_id'] = 'sellerId';
            $apiObj = new Api_Seller(array());
        }
        $result = $apiObj->modifyLoginPwd($data, $maps);
        $result['visitor_type'] = $accountType;
        die(json_encode($result));
    }
	/**
     * [verifyCodeAction 验证码]
     *
     * @return [type] [description]
     */
    public function verifyCodeAction()
    {
    	$verify	= new Common_Verifycode();
    	$verify->set_img_size(85,20);
    	echo $verify->render();
    }
}