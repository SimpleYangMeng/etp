<?php
class Default_RegisterController extends Ec_Controller_DefaultAction
{
	public function preDispatch()
    {
        $this->tplDirectory	= "default/views/register/";
    }

    /**
     * 注册首页
     * @access  public
     * @return  resource
     */
    public function indexAction()
    {
        $this->checkIsLogin();
    	$language = Ec_Lang::getInstance()->getCurrentLanguage();
        $language = empty($language) ? 'zh_CN' : $language;
        $session = new Zend_Session_Namespace('RegisterStep');
        $session->step = '0';
        $visitor_type = $this->_request->getParam("visitor_type", 1);
		$this->view->languageTpl = $language;
        $this->view->visitor_type = $visitor_type;
    	echo Ec::renderTpl($this->tplDirectory . "index.tpl", 'layout-etp');
    }

    /**
     * [stepAction 注册步骤]
     *
     * @return [type] [description]
     */
    public function stepAction()
    {
        $this->checkIsLogin();
        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        $language = empty($language) ? 'zh_CN' : $language;
        $this->view->languageTpl = $language;
    	$current = $this->getRequest()->getParam('current');
    	$visitor_type = $this->_request->getParam('visitor_type', 1);
    	$session = new Zend_Session_Namespace('register');
    	if (empty($session->data)) {
    		$this->_redirect('/login');
    	}
    	$this->view->data = $session->data;
    	$sessioCurrentStep = $session->data['current'];
    	if ($current != $sessioCurrentStep) {
    		$this->_redirect('/register/step?current='.$sessioCurrentStep.'&visitor_type='.$visitor_type);
    	}
    	switch ($visitor_type) {
    		case '1':
    			$goUrl = '/buyer/portal';
    			$visitorText = Ec_Lang::getInstance()->getTranslate('buyer');
    			$visitor = Service_Buyer::getByField($session->data['code'], "buyer_code", "*");
    			break;
    		case '2':
    			$goUrl = '/buyer/portal';
    			$visitorText = Ec_Lang::getInstance()->getTranslate('seller');
    			$visitor = Service_Seller::getByField($session->data['code'], "seller_code", "*");
    			break;
    		default:
    			$visitor = Service_Buyer::getByField($session->data['code'], "buyer_code", "*");
    			break;
    	}
    	if(empty($visitor)){
    		$this->_redirect('/register/step?current='.$sessioCurrentStep.'&visitor_type='.$visitor_type);
    	}

    	$this->view->visitor_type = $visitor_type;
        $this->view->visitor = $visitor;
    	switch ($current) {
    		case '2':
    			$mailExtArr = explode('@', strtolower($visitor['email']));
    			$maileLoginLink = $this->getEmailLinkArr($mailExtArr[1]);
    			$this->view->maileLoginLink = $maileLoginLink;
				echo Ec::renderTpl($this->tplDirectory . "step2.tpl", 'layout-etp');
    		break;
    		case '3':
    			echo Ec::renderTpl($this->tplDirectory . "step3.tpl", 'layout-etp');
    		break;
    		case '3_1':
    			if(!($this->getRequest()->isPost() && $this->getRequest()->getParam('is_agree'))){
    				$this->_redirect('/register/step?current=3&visitor_type='.$visitor_type);
    			}
                $currency = Common_DataCache::getCurrencyMaps( 'USD' );
    			$this->view->currencys = !empty( $currency ) ? array( $currency ) : array();
    			$this->view->visitorText = $visitorText;
    			//买家
    			//if($visitor_type == 1){
    			//	echo Ec::renderTpl($this->tplDirectory . "step3_1_1.tpl", 'layout-etp');
    			//卖家
    			//}else if($visitor_type == 2){
    			//	echo Ec::renderTpl($this->tplDirectory . "step3_1_2.tpl", 'layout-etp');
    			//}else {
    				echo Ec::renderTpl($this->tplDirectory . "step3_1_1.tpl", 'layout-etp');
    			//}
    			break;
    		case '4':
                //买家
                if($visitor_type == 1 ){
				    $this->view->setPasswordUrl = '/portal/purchaser/set-paypwd';
                }
    			$this->view->indexUrl = $goUrl;
    			echo Ec::renderTpl($this->tplDirectory . "step4.tpl", 'layout-etp');
    		break;
    	}
    }

    /**
     * [activateAction 邮件激活]
     *
     * @return [type] [description]
     */
	public	function activateAction()
	{
		$encryptionCode = trim($this->getRequest()->getParam('code', ''));
        $parmsArr = array();
        if(!empty($encryptionCode)){
            parse_str(base64_decode($encryptionCode), $parmsArr);
        }
        if(empty($parmsArr) || !is_array($parmsArr)){
            $this->view->is_show_resend = 0;
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('regCodeError');
            die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
        }
        $code = isset($parmsArr['code']) && !empty($parmsArr['code']) ? $parmsArr['code'] : '';
        $time = isset($parmsArr['time']) && !empty($parmsArr['time']) ? $parmsArr['time'] : '';
		$visitor_type = isset($parmsArr['visitor_type']) && !empty($parmsArr['visitor_type']) ? $parmsArr['visitor_type'] : '';
		$visitor_id = isset($parmsArr['visitor_id']) && !empty($parmsArr['visitor_id']) ? $parmsArr['visitor_id'] : '';
        if (empty($visitor_id) || empty($visitor_type)) {
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('regCodeError');
            $this->view->is_show_resend = 0;
            die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
        }
        //重发邮件
        $this->view->is_show_resend = 1;
        if($visitor_type == 1){
            $accountInfo = Service_Buyer::getByField($visitor_id, 'buyer_id');
            $visitor_code = $accountInfo['buyer_code'];
        }else {
            $accountInfo = Service_Seller::getByField($visitor_id, 'seller_id');
            $visitor_code = $accountInfo['seller_code'];
        }
        $regSession = new Zend_Session_Namespace('register');
        $regSession->data = array(
            'id' => $visitor_id,
            'email' => $accountInfo['email'],
            'code' => $visitor_code,
            'visitor_type' => $visitor_type,
        );
    	if (empty($code)) {
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('regCodeError');
            die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
    	}
    	//一天失效
		if (empty($time) || time() - $time > 3600 * 24 ) {
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('regCodeTimeError');
            die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
		}

    	switch ($visitor_type) {
    		case '1':
    			$result	= Service_Buyer::getByField($visitor_id, 'buyer_id');
    			$visitor['id'] = $result['buyer_id'];
    			$visitor['code'] = $result['buyer_code'];
    		//	$visitor['username'] = $result['buyer_name'];
    			break;
    		case '2':
    			$result	= Service_Seller::getByField($visitor_id, 'seller_id');
    			$visitor['id'] = $result['seller_id'];
    			$visitor['code'] = $result['seller_code'];
    		//	$visitor['username'] = $result['seller_name'];
    			break;
    		default:
                $this->view->notice = Ec_Lang::getInstance()->getTranslate('regCodeError');
                die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
    			break;
    	}

		if(!$result){
            $this->view->notice = Ec_Lang::getInstance()->getTranslate('regCodeError');
            die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
			//die("<script>alert('".Ec_Lang::getInstance()->getTranslate('regCodeError')."');window.history.back();</script>");
		}
        $session= new Zend_Session_Namespace('register');
    	if (!empty($result['activate_code']) && ($result['activate_code'] == $code) && ($result['reg_step'] == 1)) {
            //更新为第二步
    		$update = array(
    			'reg_step' => 2,
                'update_time' => date('Y-m-d H:i:s'),
    		);
    		switch ($visitor_type) {
	    		case '1':
                    if($result['is_active'] == 1){
                        $obj = new Api_Buyer(array());
                        $activeApiresult = $obj->activeAccount(array('email'=>$result['email']), array('email' => 'email'));
                        if($activeApiresult['state'] == 0 ){
                            $this->view->notice = $activeApiresult['error'][0]['errorCode'].':'.$activeApiresult['error'][0]['errorMsg'];
                            die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
                        }
                    }
	    			$state = Service_Buyer::update($update, $result['buyer_id'], 'buyer_id');
	    			break;
	    		case '2':
                    if($result['is_active'] == 1){
                        $obj = new Api_Seller(array());
                        $activeApiresult = $obj->activeAccount(array('email'=>$result['email']), array('email' => 'email'));
                        if($activeApiresult['state'] == 0 ){
                            $this->view->notice = $activeApiresult['error'][0]['errorCode'].':'.$activeApiresult['error'][0]['errorMsg'];
                            die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
                        }
                    }
	    			$state = Service_Seller::update($update, $result['seller_id'], 'seller_id');
	    			break;
	    		default:
	    			$state = false;
	    			break;
	    	}
    		if ($state) {
    			$session->data	= array(
    				'id' => $visitor['id'],
    				'code' => $visitor['code'],
    			//	'username' => $visitor['username'],
    				'email'	=> $result['email'],
					'visitor_type' => $visitor_type,
					'current'=> 3
    			);
    			$this->_redirect('/register/step?current=3&visitor_type='.$visitor_type);
    		}
    	}else {
    		if (!empty($result['activate_code']) && ($result['activate_code'] == $code) && ($result['reg_step'] > 1)){
    			if($result['reg_step'] == '3'){
    				//unset($session);
    				$session->unsetAll();
    				$this->_redirect('/login');
    			}
    			$session->data	= array(
					'id' => $visitor['id'],
    				'code' => $visitor['code'],
    			//	'username' => $visitor['username'],
    				'email'	=> $result['email'],
    				'visitor_type' => $visitor_type,
					'current'	=> 3
    			);
    			$this->_redirect('/register/step?current='.$result['reg_step'].'&visitor_type='.$visitor_type);
    		}
    	}
        $this->view->notice = Ec_Lang::getInstance()->getTranslate('regCodeError');
        die(Ec::renderTpl($this->tplDirectory . "active_code_error.tpl", 'layout-etp'));
    }

    /**
     * [saveAction 保存注册账号]
     * @return [type] [description]
     */
	public function saveAction()
	{
		$time	= date('Y-m-d H:i:s');
	//	$username = $this->_request->getParam('username','');
		$email	= $this->_request->getParam('email', '');
		$pwd	= $this->_request->getParam('userpwd', '');
		$repwd	= $this->_request->getParam('repwd', '');
        $visitor_type = $this->_request->getParam("visitor_type", '');
		$registerRow=array(
	//		'username' => $username,
			'pwd' => $pwd,
			'repwd' => $repwd,
			'email' => $email,
			'activate_code' => substr(md5($time),0,12),
			'reg_step' => 1,
			'verify' => $this->_request->getParam('verify',''),
            'visitor_type' => $visitor_type,
            'check_verify' => 1
		);
		$process = new Service_RegProcess();
		$result = $process->createTransaction($registerRow);
		if($result['state']=='0'){
            die(json_encode($result));
		}else{
			$session = new Zend_Session_Namespace('register');
			$session->data = array(
				'id' => $result['visitor_id'],
			//	'username' => $result['visitor_name'],
				'code' => $result['visit_code'],
				'email' => $email,
				'visitor_type' => $result['visitor_type'],
				'current' => 2
			);
			//$this->_redirect('/register/step?current=2');
		}
		die(json_encode($result));
	}

	/**
	 * 重发验证邮箱
	 */
	public function resendAction()
	{
		$session = new Zend_Session_Namespace('register');
		if (empty($session)) {
			$this->_redirect('/login');
		}
		$id	 = $session->data['id'];
		$email = $session->data['email'];
		$visitor_code = $session->data['code'];
	//	$visitor_name = $session->data['username'];
		$visitor_type = $session->data['visitor_type'];
		$code = uniqid();
		switch ($visitor_type) {
			case '1':
				$state = Service_Buyer::update(array('activate_code'=>$code, 'update_time' => date('Y-m-d H:i:s')), $id, 'buyer_id');
				$buyerLogRow = array(
					'buyer_id' => $id,
					'buyer_code' => $visitor_code,
					'operate_code' => $visitor_code,
					'bl_note' => '重发激活邮件',
					'add_time' => date('Y-m-d H:i:s'),
				);
				//记录日志
				Service_BuyerLog::add($buyerLogRow);
				break;
			case '2':
				$state = Service_Seller::update(array('activate_code'=>$code, 'update_time' => date('Y-m-d H:i:s')), $id, 'seller_id');
				$sellerLogRow = array(
					'seller_id' => $id,
					'seller_code' => $visitor_code,
					'operate_code' => $visitor_code,
					'sl_note' => '重发激活邮件',
					'add_time' => date('Y-m-d H:i:s'),
				);
				//记录日志
				Service_SellerLog::add($sellerLogRow);
				break;
			default:
				die("<script>alert('".Ec_Lang::getInstance()->getTranslate('sendEmailFile')."');window.history.back();</script>");
				break;
		}
		if (!empty($state)) {
			//$activeurl = 'http://'.$_SERVER['HTTP_HOST'].'/register/activate?code='.$code.'&time='.time().'&visitor_type='.$visitor_type.'&visitor_id='.$id;
		//echo $activeurl;
		//die();
            $encryptionCode = base64_encode('code='.$code.'&time='.time().'&visitor_type='.$visitor_type.'&visitor_id='.$id);
            $activeurl = 'http://'.$_SERVER['HTTP_HOST'].'/register/activate?code='.$encryptionCode;
			$activeHtml = "<a href='$activeurl' target='_blank'>{$activeurl}</a>";
            $emailContent = sprintf(Ec_Lang::getInstance()->getTranslate('regEmailContent'), $visitor_code, $code, $activeHtml);
			$params = array(
				'bodyType' => 'html',
				'email' => array($email),
				'subject' => Ec_Lang::getInstance()->getTranslate('regEmailSubject'),
				'body' => $emailContent,
			);
			$state = Common_Email::sendMail($params);
			/*
			$state	= Common_Email::send(array(
				'email'		=> $email,
				'subject'	=> '注册账户验证--OMS',
				'bodyType'	=> 'html',
				'body'		=> '请复制该链URL接至浏览器进行访问激活账户<br/>链接地址：http://192.168.25.128:6666/register/activate?code='.$code
			));
			*/
		}
		if (empty($state)) {
			die("<script>alert('".Ec_Lang::getInstance()->getTranslate('sendEmailFile')."');window.history.back();</script>");
		} else {
			die("<script>alert('".Ec_Lang::getInstance()->getTranslate('sendEmailSuccess')."');window.history.back();</script>");
		}
	}

	/**
	 * [completeAction 完善资料]
	 * @return [type] [description]
	 */
	public function completeAction()
	{
		$session = new Zend_Session_Namespace('register');
		if ($this->getRequest()->isPost() && !empty($session->data)) {
			$parms	= $this->getRequest()->getParams();
			unset($parms['controller']);
			unset($parms['action']);
			unset($parms['module']);
			$process = new Service_RegProcess();
			$result = $process->completeTransaction($parms);
			die(Zend_Json::encode($result));
		}
		$this->_redirect('/register');
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

    /**
     * [getEmailLinkArr 获取邮件访问地址]
     *
     * @param  [type] $mailExt [description]
     *
     * @return [type]          [description]
     */
    private function getEmailLinkArr ($mailExt) {
    	$mailLinkArr = array(
    		'qq.com'=>'https://mail.qq.com',
		    'gmail.com'=>'http://mail.google.com',
		    'sina.com'=>'http://mail.sina.com.cn',
		    '163.com'=>'http://mail.163.com',
		    '126.com'=>'http://mail.126.com',
		    'yeah.net'=>'http://www.yeah.net',
		    'sohu.com'=>'http://mail.sohu.com',
		    'tom.com'=>'http://mail.tom.com',
		    'sogou.com'=>'http://mail.sogou.com',
		    '139.com'=>'http://mail.10086.cn',
		    'hotmail.com'=>'http://www.hotmail.com',
		    'live.com'=>'http://login.live.com',
		    'live.cn'=>'http://login.live.cn',
		    'live.com.cn'=>'http://login.live.com.cn',
		    '189.com'=>'http://webmail16.189.cn/webmail',
		    'yahoo.com.cn'=>'http://mail.cn.yahoo.com',
		    'yahoo.cn'=>'http://mail.cn.yahoo.com',
		    'eyou.com'=>'http://www.eyou.com',
		    '21cn.com'=>'http://mail.21cn.com',
		    '188.com'=>'http://www.188.com',
		    'foxmail.coom'=>'http://www.foxmail.com'
    	);
    	if(isset($mailLinkArr[$mailExt])){
    		return $mailLinkArr[$mailExt];
    	}else {
    		return 'http://mail.'.$mailExt;
    	}
    }

    /**
     * [checkEmailExistsAction 验证邮箱是否存在]
     *
     * @return [type] [description]
     */
    public function checkEmailExistsAction(){
    	die(json_encode(array('success'=>'1111')));
    }

    /**
     * [checkIsLogin 验证是否已经登陆]
     *
     * @return [type] [description]
     */
    private function checkIsLogin(){
        //已经有账号登陆
        $_customerAuth = Service_Login::getLoginInfo();
        if(isset($_customerAuth['account_id']) && !empty($_customerAuth['account_id'])){
            if($_customerAuth['account_type'] == 1 ){
                $this->_redirect('/buyer/portal/index');
                exit();
            }else {
                $this->_redirect('/seller/portal/index');
                exit();
            }
        }
    }

    /**
     * [uplodeimgAction 上传图片]
     * @return [type] [description]
     */
	public function uplodeimgAction() {
		$return = array(
			'state' => 0,
			'msg' => '',
		);
		$session = new Zend_Session_Namespace('register');
		if (empty($session->data)) {
    		$return['msg'] = Ec_Lang::getInstance()->getTranslate('linkFailure');
    		die(Zend_Json::encode($return));
    	}
		$id		= $session->data['id'];
		$code	= $session->data['code'];
		$visitor_type = $session->data['visitor_type'];
		$process = new Service_RegProcess();
		$result = $process->uploadImage($_FILES['file'], $code, $visitor_type);
		$type = explode('.', $_FILES["file"]['name']);
		$extend = end($type);
		//$data = base64_encode(file_get_contents($result['file_path']));
		//获取文件名方式修改
		$fileName = date('YmdHis').uniqid().'.'.$extend;
		$return = array(
            'state' => 1,
			'jsonrpc' => '2.0',
			'result' => '',
			'atname' => $fileName,
			'type' => $extend,
			//'imgData' => $data,
			'imgUrl' => $result['url'],
			'imgFilePath' => $result['file_path']
		);
		die(Zend_Json::encode($return));
		//die('{"jsonrpc" : "2.0", "result" : null, "atname" : "' . $name . '", "type" : "' . $type[1] . '", "id" : "' . $data . '"}');
	}
}