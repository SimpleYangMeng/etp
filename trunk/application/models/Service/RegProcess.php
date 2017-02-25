<?php
class Service_RegProcess
{
	/**
	 * 生成料件号
	 * @author solar
	 * @param int $customer_id
	 * @return string
	 */
	public static function generateGoodsId($customer_id, $has_invoice=1) {
        $customer = Service_Customer::getByField($customer_id,'customer_id',"*");
        $aCustomer = Service_Customer::getCustomerByShortCode($customer['customer_short']);
		//$aCustomer = Service_Customer::getLockInShareMode($customer_id);
		$goods_serial = ++$aCustomer['goods_serial'];
		Service_Customer::update(array('goods_serial'=>$goods_serial), $aCustomer['customer_id']);
		$customer_short = $has_invoice==2 ? substr($aCustomer['customer_short'], 0, 2).'B' : $aCustomer['customer_short'];
		return $customer_short.str_pad($goods_serial, 6, '0', STR_PAD_LEFT);
	}

	/**
	 * @author william-fan
	 * @todo 用于检测输入
	 */
	private function validator($row){
		$error = array();
		/*
		if(strlen($row['username']) < 8){
			$error[] = Ec_Lang::getInstance()->getTranslate('UserName').Ec_Lang::getInstance()->getTranslate('Gtsix');
		}
		if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $row['username'])){
			$error[] = Ec_Lang::getInstance()->getTranslate('UserName').Ec_Lang::getInstance()->getTranslate('special');
		}
		*/
		if($row['email']==''){
			$error[] = Ec_Lang::getInstance()->getTranslate('emailRequired');;
		//}else if(!preg_match("/^([\.a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+(\.[a-zA-Z0-9_-])+/",$row['email'])){
		}else if(!Common_Common::checkEmail($row['email'])){
			$error[] = Ec_Lang::getInstance()->getTranslate('wrongEmail');
		}else {
			//买家
			if(isset($row['visitor_type']) && $row['visitor_type'] == 1){
				$checkEmail = Service_Buyer::getByField($row['email'], 'email');
				if(!empty($checkEmail)){
					$error[] = Ec_Lang::getInstance()->getTranslate('emailExisted');
				}
			//卖家
			}else if(isset($row['visitor_type']) && $row['visitor_type'] == 2){
				$checkEmail = Service_Seller::getByField($row['email'], 'email');
				if(!empty($checkEmail)){
					$error[] = Ec_Lang::getInstance()->getTranslate('emailExisted');
				}
			}
		}
		if(strlen($row['pwd']) < 6 || strlen($row['pwd']) > 16){
			$error[] = Ec_Lang::getInstance()->getTranslate('password').Ec_Lang::getInstance()->getTranslate('Gtsix');
		}
		if($row['pwd']!=$row['repwd']){
			$error[] = Ec_Lang::getInstance()->getTranslate('TwoPass');
		}
        if($row['check_verify']){
            if($row['verify']==''){
                $error[] = Ec_Lang::getInstance()->getTranslate('VerifyCode').Ec_Lang::getInstance()->getTranslate('require');
            } else {
                if (! $this->Verifycode ( $row ['verify'] )) {
                    $error[] = Ec_Lang::getInstance()->getTranslate('VerifyCode').Ec_Lang::getInstance()->getTranslate('error');
                    //刷新验证码标示
                    $error['authcodeError'] = 1;
                }
            }
        }
		return $error;
	}

	/**
	 *
	 * @author william-fan
	 * @todo 用于检测验证码
	 */
	public function Verifycode($verifyCode) {
		$verify = new Common_Verifycode ();
		return $verify->is_true ( $verifyCode );
	}

	/**
	 * [createTransaction 注册保存]
	 * @param  [type] $row [description]
	 * @return [type]      [description]
	 */
	public function createTransaction($row) {
		$result = array("state"=>0, "message"=>Ec_Lang::getInstance()->getTranslate('register').Ec_Lang::getInstance()->getTranslate('error'), 'error'=>array());
		$error = $this->validator($row);
		if(!empty($error)){
			if(isset($error['authcodeError']) && $error['authcodeError'] == 1 ){
				$result['authcodeError'] = 1;
				unset($error['authcodeError']);
			}
			$result['error'] = $error;
			return $result;
		}
		$mark = new Common_Customer();
		$row['activate_code'] = uniqid();
		switch ($row['visitor_type']) {
			case '1':
				$prefix = 'BE';
				$row['code'] = $mark->markCustomCode('buyer_register', 4, $prefix);
			//	$visiterId = $this->addBuyer($row);
				$apiResult = $this->addBuyerByApi($row);
				break;
			case '2':
				$prefix = 'SE';
				$row['code'] = $mark->markCustomCode('seller_register', 4, $prefix);
			//	$visiterId = $this->addSeller($row);
				$apiResult = $this->addSellerByApi($row);
				break;
			default:
				$result['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
				return $result;
				break;
		}
		if(!isset($apiResult['state']) || $apiResult['state'] == 0){
			//throw new Exception($apiResult['error'][0]['errorCode'].':'.$apiResult['message'].$apiResult['error'][0]['errorMsg'], $apiResult['error'][0]['errorCode']);
			$result['message'] = $apiResult['error'][0]['errorCode'].':'.$apiResult['message'].$apiResult['error'][0]['errorMsg'];
			return $result;
		}else {
			if(empty($apiResult['reference'])){
				//throw new Exception(Ec_Lang::getInstance()->getTranslate('paramsError'));
				$result['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
				return $result;
			}
			$visiterId = $apiResult['reference'];

			// 验证码写入到数据表 - 接口未写入，如果改为接口需添加对应字段
			if( $row['visitor_type'] == 1 ){
				Service_Buyer::update(array('activate_code'=>$row['activate_code']), $visiterId, 'buyer_id');
			}else {
				Service_Seller::update(array('activate_code'=>$row['activate_code']), $visiterId, 'seller_id');
			}
		}
		/*
		$row['code'] = 'SE0001';
		$row['activate_code'] = '12345678';
		*/
		//$activeurl = 'http://'.$_SERVER['HTTP_HOST'].'/register/activate?code='.$row['activate_code'].'&time='.time().'&visitor_type='.$row['visitor_type'].'&visitor_id='.$visiterId;
		//参数加密
		$encryptionCode = base64_encode('code='.$row['activate_code'].'&time='.time().'&visitor_type='.$row['visitor_type'].'&visitor_id='.$visiterId);
		$activeurl = 'http://'.$_SERVER['HTTP_HOST'].'/register/activate?code='.$encryptionCode;
		$activeHtml = "<a href='$activeurl' target='_blank'>{$activeurl}</a>";
		$emailContent = sprintf(Ec_Lang::getInstance()->getTranslate('regEmailContent'), $row['code'], $row['activate_code'], $activeHtml);
		$params = array(
       		'bodyType' => 'html',
        	'email' => array($row['email']),
        	'subject' => Ec_Lang::getInstance()->getTranslate('regEmailSubject'),
        	'body' => $emailContent,
    	);
        if(!Common_Email::sendMail($params)){
            //throw new Exception(Ec_Lang::getInstance()->getTranslate('sendEmailFile'));
            $result['message'] = Ec_Lang::getInstance()->getTranslate('sendEmailFile');
			return $result;
        }
		$result['state'] = '1';
		$result['message'] = Ec_Lang::getInstance()->getTranslate('regSuccess');
		$result['visitor_id'] = $visiterId;
		$result['visit_code'] = $row['code'];
		$result['visitor_type'] = $row['visitor_type'];
		return $result;
	}

	/**
	 * [addBuyer 初始化买家信息]
	 * @param [type] $row [description]
	 */
	private function addBuyer($row){
		$buyerRow = array(
			'buyer_code' => $row['code'],
			'buyer_name' => '',
			'email' => $row['email'],
			'password' => Common_Common::pwdAlgorithm($row['pwd']),
			'status' => 1,
			'reg_step' => 1,
			'activate_code' => $row['activate_code'],
			'add_time' => date('Y-m-d H:i:s'),
			'update_time' => date('Y-m-d H:i:s'),
		);
		$buyerId = Service_Buyer::add($buyerRow);
		if(!$buyerId){
			throw new Exception("注册失败，数据录入错误");
		}
		$buyerLogRow = array(
			'buyer_id' => $buyerId,
			'buyer_code' => $row['code'],
			'operate_code' => 0,
			'bl_note' => Ec_Lang::getInstance()->getTranslate('BuyerReg'),
			'add_time' => date('Y-m-d H:i:s'),
		);
		//记录日志
		if( Service_BuyerLog::add($buyerLogRow) === false ){
			throw new Exception("注册失败，注册日志录入错误");
		}
		return $buyerId;
	}

	/**
	 * [addBuyerByApi buyer通过接口]
	 *
	 * @param [type] $row [description]
	 */
	private function addBuyerByApi($row){
		//密码加密
		$row['repwd'] = Common_Common::pwdAlgorithm($row['repwd']);
		$maps = array(
			'repwd' => 'password',
			'code' => 'buyerCode',
			'email' => 'email',
		);
		$obj = new Api_Buyer(array());
        $result = $obj->regist($row, $maps);
        return $result;
	}

	/**
	 * [addSeller 初始化卖家信息]
	 * @param [type] $row [description]
	 */
	private function addSeller($row){
		$sellerRow = array(
			'seller_code' => $row['code'],
			'seller_name' => '',
			'email' => $row['email'],
			'password' => Common_Common::pwdAlgorithm($row['pwd']),
			'status' => 1,
			'reg_step' => 1,
			'activate_code' => $row['activate_code'],
			'add_time' => date('Y-m-d H:i:s'),
			'update_time' => date('Y-m-d H:i:s'),
		);
		$sellerId = Service_Seller::add($sellerRow);
		if(!$sellerId){
			throw new Exception("注册失败，数据录入错误");
		}
		$sellerLogRow = array(
			'seller_id' => $sellerId,
			'seller_code' => $row['code'],
			'operate_code' => 0,
			'sl_note' => Ec_Lang::getInstance()->getTranslate('SellerReg'),
			'add_time' => date('Y-m-d H:i:s'),
		);
		//记录日志
		if( Service_SellerLog::add($sellerLogRow) === false ){
			throw new Exception("注册失败，注册日志录入错误");
		}
		return $sellerId;
	}

	/**
	 * [addSellerByApi seller通过接口]
	 */
	private function addSellerByApi($row){
		//密码加密
		$row['repwd'] = Common_Common::pwdAlgorithm($row['repwd']);
		$maps = array(
			'repwd' => 'password',
			'code' => 'sellerCode',
			'email' => 'email',
		);
		$obj = new Api_Seller(array());
        $result = $obj->regist($row, $maps);
        return $result;
	}

	/**
	 * @todo 完善资料验证
	 */
	private function completestepvalidator($row){
		$error = array();
		if(!isset($row['visitor_type']) || empty($row['visitor_type']) || !isset($row['complereData']) || empty($row['complereData'])){
			$error[] = Ec_Lang::getInstance()->getTranslate('paramsError');
		}
		//完善资料数组
		$complereData = $row['complereData'];

		$keyArr = array(
			'company_name' => Ec_Lang::getInstance()->getTranslate('companyName'),
			'contact_name' => Ec_Lang::getInstance()->getTranslate('contactName'),
			'contact_telphone' => Ec_Lang::getInstance()->getTranslate('contactPhone'),
			'email' => Ec_Lang::getInstance()->getTranslate('contactEmail'),
			'currency' => Ec_Lang::getInstance()->getTranslate('currency'),
		);
		//验证是否为空
		foreach ($complereData as $comEmpKey => $comEmpValue) {
			if(empty($comEmpValue)){
				$error[] = $keyArr[$comEmpKey].Ec_Lang::getInstance()->getTranslate('require');
			}
		}
		/*if(!isset($row['businessLicense']) || empty($row['businessLicense'])){
			$error[] = Ec_Lang::getInstance()->getTranslate('businessLicenseNotice');
		}
		if(!isset($row['cardFront']) || empty($row['cardFront'])){
			$error[] = Ec_Lang::getInstance()->getTranslate('cardNotice');
		}
		if(!isset($row['cardBack']) || empty($row['cardBack'])){
			$error[] = Ec_Lang::getInstance()->getTranslate('cardNotice');
		}*/

		if(!empty($error)){
			return $error;
		}

		//验证是否含有特殊字符
		foreach ($complereData as $comKey => $comValue) {
			if(preg_match("/[\'.,:;*?~`!@#$%^&+=)(<>{}]|\]|\[|\/|\\\|\"|\|/", $comValue) && $comKey != 'email'){
				$error[] = $keyArr[$comKey].Ec_Lang::getInstance()->getTranslate('special');
			}
		}
        $len = mb_strlen( $complereData['company_name'] );
        if( $len < 6 || $len > 120 ) {
            $error[] = Ec_Lang::getInstance()->getTranslate('commpanyNameLengthError');
        }
		//验证企业是否已存在
		if($row['visitor_type'] == 1){
			if(Service_Buyer::getByField($complereData['company_name'], 'company_name', array('buyer_id'))){
				$error[] = Ec_Lang::getInstance()->getTranslate('commpanyExist');
			}
		}else if($row['visitor_type'] == 2 ){
			if(Service_Seller::getByField($complereData['company_name'], 'company_name', array('seller_id'))){
				$error[] = Ec_Lang::getInstance()->getTranslate('commpanyExist');
			}
		}
		//验证联系电话号码
		if(!preg_match('/(\d{11})|^((\d{7,8})|(\d{4}|\d{3})-(\d{7,8})|(\d{4}|\d{3})-(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1})|(\d{7,8})-(\d{4}|\d{3}|\d{2}|\d{1}))$/', $complereData['contact_telphone'])){
			$error[] = Ec_Lang::getInstance()->getTranslate('contactPhoneFormatError');
		}
        if( $complereData['currency'] != 'USD') {
            $error[] =  Ec_Lang::getInstance()->getTranslate('onlyUSDIsAllowed');
        }
		return $error;
	}
	/**
	 * @author william-fan
	 * @todo 完成注册
	 */
	public function completeTransaction($row){
		$session = new Zend_Session_Namespace('register');
		$result = array("state"=>0, "message"=>Ec_Lang::getInstance()->getTranslate('updateFailed'), 'error'=>array());
		$db = Common_Common::getAdapter();
		$db->beginTransaction();
		try{
			$session = new Zend_Session_Namespace('register');
			if (empty($session)) {
				$result['state'] = '-1';
				$result['message'] = Ec_Lang::getInstance()->getTranslate('linkFailure');
				return $result;
				//throw new Exception(Ec_Lang::getInstance()->getTranslate('linkFailure'));
			}
			if($row['visitor_type'] != $session->data['visitor_type']){
				throw new Exception(Ec_Lang::getInstance()->getTranslate('linkFailure'));
			}

			$id	 = $session->data['id'];
			$email = $session->data['email'];
			$code = $session->data['code'];
			$visitor_type = $session->data['visitor_type'];

			$error = $this->completestepvalidator($row);
			if(!empty($error)){
				$result['state'] = 0;
				$result['error'] = Common_EtpCommon::transErrors($error);
				return $result;
			}

			//基础信息
			$complereData = $row['complereData'];
			$baseUpdateRow = array(
				//注册步骤
				'reg_step' => 3,
				//邮件激活状态 - 改为接口
				//'is_active' => 1,
				//待审核状态
				'status' => 4,
				'company_name' => $complereData['company_name'],
				'register_address' => $complereData['register_address'],
				'contact_name' => $complereData['contact_name'],
				'contact_telphone' => $complereData['contact_telphone'],
				'currency' => $complereData['currency']
			);

			switch ($visitor_type) {
				case '1':
					$buyerRow = Service_Buyer::getByField($id, 'buyer_id');
					/*
					if($buyerRow['is_active'] == 1){
						$obj = new Api_Buyer(array());
				        $activeApiresult = $obj->activeAccount(array('email'=>$email), array('email' => 'email'));
				        if($activeApiresult['state'] == 0 ){
				        	throw new Exception($activeApiresult['error'][0]['errorCode'].':'.$activeApiresult['error'][0]['errorMsg']);
				        }
					}
					if(strcmp($row['email_verify'], $buyerRow['activate_code']) != 0){
						throw new Exception(Ec_Lang::getInstance()->getTranslate('activeCode').Ec_Lang::getInstance()->getTranslate('error'));
					}
					*/
					//采购商信息
					$buyerUpdateRow = array();
					$updateRow = array_merge($baseUpdateRow, $buyerUpdateRow);
					if(Service_Buyer::update($updateRow, $id, 'buyer_id') === false){
						throw new Exception(Ec_Lang::getInstance()->getTranslate('updateFailed'));
					}
					$accountInfo = array(
		                'account_id' => $buyerRow['buyer_id'],
		                'account_code' => $buyerRow['buyer_code'],
		                'account_type' => $visitor_type,
		                'account_name' => $buyerRow['buyer_name'],
		                'email' => $buyerRow['email'],
		                'status' => $buyerRow['status'],
		                'is_active' => $buyerRow['is_active'],
		                'reg_step' => $buyerRow['reg_step'],
		                'currency' => $buyerRow['currency'],
		                'last_login_time'  => $buyerRow['login_time'],
		                'has_pay_password' => !empty ( $buyerRow['pay_password'] ) ? 1 : 0 ,//判断是否设置了支付密码
		            );
					break;
				case '2':
			        /*if($activeApiresult['state'] == 0 ){
			        	throw new Exception($activeApiresult['errorCode'].':'.$activeApiresult['']);
			        }*/
					$sellerRow = Service_Seller::getByField($id, 'seller_id');
					/*
					if($sellerRow['is_active'] == 1){
						$obj = new Api_Seller(array());
				        $activeApiresult = $obj->activeAccount(array('email'=>$email), array('email' => 'email'));
				        if($activeApiresult['state'] == 0 ){
				        	throw new Exception($activeApiresult['error'][0]['errorCode'].':'.$activeApiresult['error'][0]['errorMsg']);
				        }
					}
					if(strcmp($row['email_verify'], $sellerRow['activate_code']) != 0){
						throw new Exception(Ec_Lang::getInstance()->getTranslate('activeCode').Ec_Lang::getInstance()->getTranslate('error'));
					}
					*/
					//供应商信息
					$sellerUpdateRow = array();
					$updateRow = array_merge($baseUpdateRow, $sellerUpdateRow);
					if(Service_Seller::update($updateRow, $id, 'seller_id') === false ) {
						throw new Exception(Ec_Lang::getInstance()->getTranslate('updateFailed'));
					}
					$accountInfo = array(
		                'account_id' => $sellerRow['seller_id'],
		                'account_code' => $sellerRow['seller_code'],
		                'account_type' => $visitor_type,
		                'account_name' => $sellerRow['seller_name'],
		                'email' => $sellerRow['email'],
		                'status' => $sellerRow['status'],
		                'is_active' => $sellerRow['is_active'],
		                'reg_step' => $sellerRow['reg_step'],
		                'currency' => $sellerRow['currency'],
		                'last_login_time' => $sellerRow['login_time'],
		                'has_pay_password' => !empty ( $sellerRow['pay_password'] ) ? 1 : 0 ,//判断是否设置了支付密码
		            );
					break;
				default:
					throw new Exception(Ec_Lang::getInstance()->getTranslate('paramsError'));
					break;
			}
			//插入附件
			$businessLicense = isset( $row['businessLicense'] ) ? $row['businessLicense'] : array() ;
			$cardFront = isset( $row['cardFront'] ) ? $row['cardFront'] : array() ;
			$cardBack = isset( $row['cardBack'] ) ? $row['cardBack'] : array() ;
			//营业执照信息
            if( !empty( $businessLicense ) && isset( $businessLicense['imgFilePath'] ) && $businessLicense['imgFilePath'] !== '' ) {
                $businessRow = $this->createAttchRow($id, $visitor_type, $businessLicense, 1);
                if(Service_CustomerAttach::add($businessRow) === false){
                    throw new Exception(Ec_Lang::getInstance()->getTranslate('create').Ec_Lang::getInstance()->getTranslate('fail'));
                }
            }
			//身份证正面
            if( !empty( $cardFront ) && isset( $cardFront['imgFilePath'] ) && $cardFront['imgFilePath'] !== '' ) {
                $cardFrontRow = $this->createAttchRow($id, $visitor_type, $cardFront, 2);
                if(Service_CustomerAttach::add($cardFrontRow) === false){
                    throw new Exception(Ec_Lang::getInstance()->getTranslate('create').Ec_Lang::getInstance()->getTranslate('fail'));
                }
            }
			//身份证反面
            if( !empty( $cardBack ) && isset( $cardBack['imgFilePath'] ) && $cardBack['imgFilePath'] !== '' ) {
                $cardBackRow = $this->createAttchRow($id, $visitor_type, $cardBack, 3);
                if(Service_CustomerAttach::add($cardBackRow) === false){
                    throw new Exception(Ec_Lang::getInstance()->getTranslate('create').Ec_Lang::getInstance()->getTranslate('fail'));
                }
            }
			//第四步 设置登陆 session
			$loginSession = new Zend_Session_Namespace('customerAuth');
	    	$loginSession->account = array(
	    		'account_id' => $accountInfo['account_id'],
	    		'account_code' => $accountInfo['account_code'],
	    		'account_name' => $accountInfo['account_name'],
	            'account_type' => $accountInfo['account_type'],
	    		'email' => $accountInfo['email'],
	    		'status'  => $accountInfo['status'],
	    		'is_active' => $accountInfo['is_active'],
	    		'reg_step' => $accountInfo['reg_step'],
	            'currency' => $accountInfo['currency'],
	            'last_login_time' => $accountInfo['last_login_time'],
	            'has_pay_password' => $accountInfo['has_pay_password'],
	    	);
			$session->data	= array(
				'id' => $id,
				'email' => $email,
				'code' => $code,
				'visitor_type' => $visitor_type,
				'current'	=> 4
			);
			//$db->rollback();
			$db->commit();
			$result['state'] = '1';
			$result['visitor_type'] = $visitor_type;
			$result['message'] = Ec_Lang::getInstance()->getTranslate('updateSuccessfully');
		}catch(Exception $e){
			$db->rollback();
			$result = array("state" => 0, "message" => $e->getMessage(), 'errorCode' => $e->getCode());
		}
		return $result;
	}

	/**
	 * [createAttchRow 构建附件数组]
	 * @param  [type] $accountId   [description]
	 * @param  [type] $accountType [description]
	 * @param  [type] $attactRow   [description]
	 * @param  [type] $type        [description]
	 * @return [type]              [description]
	 */
	private function createAttchRow ($accountId, $accountType, $attactRow, $type){
		$attchRow = array(
			'customer_id' => $accountId,
			'type' => $accountType,
			'attach_name' => $attactRow['atname'],
			'attach_path' => $attactRow['imgFilePath'],
			'attach_type' => $attactRow['type'],
			'attach_img_type' => $type,
			'add_time' => date('Y-m-d H:i:s')
		);
		return $attchRow;
	}

	/**
	 * @author william-fan
	 * @todo 用于更新客户信息
	 */
	public static function updateCustomerTransaction($data,$customerId){
		$result = array("state"=>0,"message"=>"更改信息失败",'error'=>array());
		$db = Common_Common::getAdapter();
		$db->beginTransaction();
		try{
				$cab_id	= $data['cab_id'];
				$customerAddress = Service_CustomerAddressBook::getByField($cab_id);
				if(empty($customerAddress)){
					$result['message'] = '地址无效';
					return $result;
				}
				if($customerAddress['customer_id']!=$customerId){
					$result['message'] = '无权操作';
					$db->rollback();
					return $result;
				}
				$addressBook['cab_firstname']		= $data['cab_firstname'];
				$addressBook['cab_lastname']		= $data['cab_lastname'];
				$addressBook['cab_phone']			= $data['cab_phone'];
				$addressBook['cab_fax']				= $data['cab_fax'];
				$addressBook['cab_state']			= $data['cab_state'];
				$addressBook['cab_city']			= $data['cab_city'];
				$addressBook['cab_postcode']		= $data['postcode'];
				$addressBook['cab_street_address1']	= $data['cab_street_address1'];
				/* echo $cab_id;
				print_r($addressBook);
				exit; */
				Service_CustomerAddressBook::update($addressBook, $cab_id);
				$customerRow = array();
				if(isset($data['customer_logo']) && $data['customer_logo']!=''){
					$customerRow['customer_logo'] = $data['customer_logo'];
				}
				if(isset($data['customer_license']) && $data['customer_license']!=''){
					$customerRow['customer_license'] = $data['customer_license'];
				}
				if(isset($data['customer_idcard']) && $data['customer_idcard']!=''){
					$customerRow['customer_idcard'] = $data['customer_idcard'];
				}
				$customerRow['customer_firstname'] = $data['cab_firstname'];
				$customerRow['customer_lastname'] = $data['cab_lastname'];
				$customerRow['customer_telephone'] = $data['cab_phone'];
				$customerRow['customer_country'] = $data['cab_country'];
				$customerRow['customer_fax'] = $data['cab_fax'];
				$customerRow['customer_province'] = $data['cab_state'];
				$customerRow['customer_city'] = $data['cab_city'];
				$customerRow['customer_postno'] = $data['postcode'];
				$customerRow['customer_address'] = $data['cab_street_address1'];

				if(!empty($customerRow)){
				//print_r($customerRow);
					Service_Customer::update($customerRow, $data['customer_id']);
				}

				$db->commit();
				$result['state']='1';
				$result['message']='更新资料成功';
				return $result;
			}catch(Exception $e){
				$db->rollback();
				$result = array("state"=>0,"message"=>$e->getMessage(),'errorCode'=>$e->getCode());
			}
		return $result;
	}

	/**
	 * [uploadImage 上传图片信息]
	 * @param  [type] $file         [description]
	 * @param  [type] $accountCode  [description]
	 * @param  [type] $visitor_type [description]
	 * @return [type]               [description]
	 */
	public function uploadImage($file, $accountCode, $visitor_type){
    	$return = array( 'state' => 0, 'message' => '');
    	if(empty($file) || empty($accountCode) || empty($visitor_type)){
    		return false;
    	}
    	$upload = new Ec_Upload($file);
    	$fileName = date('Ymdhis')."_".Common_Common::random(5);
    	//买家
    	if($visitor_type == 1){
    		$dirname = 'buyer'.DIRECTORY_SEPARATOR.$accountCode.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR;
    	//卖家
    	}else if($visitor_type == 2){
    		$dirname = 'seller'.DIRECTORY_SEPARATOR.$accountCode.DIRECTORY_SEPARATOR.date('Ymd').DIRECTORY_SEPARATOR;
    	}
    	$file_path = $upload->upload($fileName, $dirname, '');
    	$fullFileName = $dirname.$fileName.".".$upload->getStuffix();
    	//图片查看链接
    	$return['url'] =  "http://".$_SERVER['HTTP_HOST']."/default/view-image/view-upload-image?fileName=".$fullFileName;
    	$return['file_path'] =  APPLICATION_PATH . "/../data/images/" . $fullFileName;
    	//die( json_encode( $return ) );
    	return $return;
    }

}