<?php
/* @desc 账号相关处理
 *
 */
class Service_AccountProcess {

    protected static $class = null;
    protected $_customerAuth = null;

    /* @desc；
     * @param $params 参数 暂时没用
     */
    public function __construct( $params = array() ) {
        $this->_customerAuth = Service_Login::getLoginInfo();
    }

    public static function getInstance() {
        if (!isset(self::$class)) {
            $c = __CLASS__;
            self::$class = new $c;
        }
        return self::$class;
    }

    public function getCompanyInfo() {
        $companyInfo = array();
        if( $this->_customerAuth['account_type'] == 1 ) {//买家
            $buyer = Service_Buyer::getByField( $this->_customerAuth['account_id'], 'buyer_id' );
            if( $buyer ) {
                $companyInfo = array(
                    'company_name'          => $buyer['company_name'] ,
                    'register_address'     => $buyer['register_address'] ,
                    'contact_name'          => $buyer['contact_name'] ,
                    'contact_telphone'     => $buyer['contact_telphone'] ,
                    'currency'              => $buyer['currency'] ,
                    'register_address'     => $buyer['register_address'],
                    'email'                 => $buyer['email'] ,
                );
            }
        } else {
            $seller = Service_Seller::getByField( $this->_customerAuth['account_id'], 'seller_id' );
            if( $seller ) {
                $companyInfo = array(
                    'company_name'         => $seller['company_name'] ,
                    'register_address'    => $seller['register_address'] ,
                    'contact_name'         => $seller['contact_name'] ,
                    'contact_telphone'    => $seller['contact_telphone'] ,
                    'currency'             => $seller['currency'] ,
                    'register_address'    => $seller['register_address'],
                    'email'                => $seller['email'] ,
                );
            }
        }
        return $companyInfo;
    }

    /* @desc 编辑用户企业资料
     * @param array $param 企业资料数组
     * @reurn array
     */
    public function editAccountCompanyInfo( $param ) {

        $return  = array('state'=>0,'message'=>'','errors'=>'');
        $error = $this->checkCompanyInfo( $param );
        if( !empty ( $error ) ) {
            $return['errors'] = $error;
            return $return;
        }

        $adapter = Common_Common::getAdapter();
        $adapter->beginTransaction();
        try{
            $this->updateCompanyInfo( $param );
            $this->addLog( '更新企业资料' );
            $this->updateCompanyPaperImage( $param['file'] );

            $adapter->commit();
            $return['state'] = 1;
            $return['message'] = Ec_Lang::getInstance()->getTranslate('updateSuccessfully');
        } catch( Exception $e ) {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('updateFailed');
            $adapter->rollBack();
        }
        return $return;
    }

    protected function updateCompanyInfo( $param ) {
        $update = array(
            'company_name'          => $param['companyName'],
            'contact_name'          => $param['contacts'],
            'contact_telphone'     => $param['contactNumber'],
            'currency'              => $param['currency'],
            'email'                  => $param['email'],
            'register_address'     => $param['register_address'],
            'update_time'           => date('Y-m-d H:i:s'),
        );
        $result = false;
        if( $this->_customerAuth['account_type'] == 1 ) {
            $result = Service_Buyer::update( $update, $this->_customerAuth['account_id'], 'buyer_id' );
        } else {
            $result = Service_Seller::update( $update, $this->_customerAuth['account_id'], 'seller_id' );
        }
        if( !$result )
            throw new Exception( '更新失败' );
    }

    protected function addLog( $remark ) {
        if( $this->_customerAuth['account_type'] == 1 ) {
            $log = array(
                'buyer_id'              => $this->_customerAuth['account_id'],
                'buyer_code'            => $this->_customerAuth['account_code'],
                'operate_code'          => 0,
                'bl_note'                => $remark,
                'add_time'               => date('Y-m-d H:i:s'),
            );
            $result = Service_BuyerLog::add( $log );
        } else {
            $log = array(
                'seller_id'              => $this->_customerAuth['account_id'],
                'seller_code'            => $this->_customerAuth['account_code'],
                'operate_code'          => 0,
                'sl_note'                => $remark,
                'add_time'               => date('Y-m-d H:i:s'),
            );
            $result = Service_SellerLog::add( $log );
        }
        if( !$result )
            throw new Exception( '更新失败' );
    }

    /* @desc 更新企业证件照
     *
     */
    protected function updateCompanyPaperImage( $file ) {
        if( empty( $file ) )
            return;

        $tempDireName = '';
        if( $this->_customerAuth['account_type'] == 1 )
            $tempDireName = 'buyer';
        else
            $tempDireName = 'seller';

        $filePath = dirname(APPLICATION_PATH) . DIRECTORY_SEPARATOR .implode( DIRECTORY_SEPARATOR, array('data','images',$tempDireName,$this->_customerAuth['account_code'],date('Ymd')));

        $attachRows = Service_CustomerAttach::getByCondition(
            array(
                'customer_id'   => $this->_customerAuth['account_id'],
                'type'           => $this->_customerAuth['account_type']
            )
        );
        $attach = array();
        foreach( $attachRows as $value ) {
            $attach[ $value['attach_img_type'] ] = $value;
        }

        $hasBlImage = $hasIdFrontImage = $hasIdBackImage = false;
        $blTargetPath = $idFrontTargetPath = $idBackTargetPath = '';
        $blTargetFile = $idFrontTargetFile = $idBackTargetFile = '';

        if( isset( $file['businessLicense'] ) && $file['businessLicense'] !== '' ) {
            $tmpPathInfo = pathinfo( $file['businessLicense'] );
            $blTargetFile = date('YmdHis')."_".Common_Common::random(5). '.' .$tmpPathInfo['extension'];
            $blTargetPath = $filePath . DIRECTORY_SEPARATOR .$blTargetFile;
            $hasBlImage = true;

            if( isset( $attach[ 1 ] ) ) {
                $result = Service_CustomerAttach::update( array(
                    'attach_name'=>$blTargetFile,
                    'attach_path' => $blTargetPath
                ), $attach[ 1 ]['customer_attach_id'], 'customer_attach_id' );

                if( !$result )
                    throw new Exception( Ec_Lang::getInstance()->getTranslate('updateFailed') );

            } else {
                $add = array(
                    'customer_id'           =>  $this->_customerAuth['account_id'],
                    'type'                   => $this->_customerAuth['account_type'],
                    'attach_name'           => $blTargetFile,
                    'attach_path'           => $blTargetPath,
                    'attach_type'           => '',
                    'attach_img_type'      => 1,
                    'add_time'              => date('Y-m-d H:i:s'),
                );
                $result = Service_CustomerAttach::add( $add );
                if( !$result )
                    throw new Exception( Ec_Lang::getInstance()->getTranslate('updateFailed') );
            }
        }
        if( isset( $file['idCardFront'] ) && $file['idCardFront'] !== '') {
            $tmpPathInfo = pathinfo( $file['idCardFront'] );
            $idFrontTargetFile = date('YmdHis')."_".Common_Common::random(5). '.' .$tmpPathInfo['extension'];
            $idFrontTargetPath = $filePath . DIRECTORY_SEPARATOR . $idFrontTargetFile;
            $hasIdFrontImage = true;

            if( isset( $attach[ 2 ] ) ) {
                $result = Service_CustomerAttach::update( array(
                    'attach_name'=>$idFrontTargetFile,
                    'attach_path' => $idFrontTargetPath
                ), $attach[ 2 ]['customer_attach_id'], 'customer_attach_id' );

                if( !$result )
                    throw new Exception( Ec_Lang::getInstance()->getTranslate('updateFailed') );

            } else {
                $add = array(
                    'customer_id'           =>  $this->_customerAuth['account_id'],
                    'type'                   => $this->_customerAuth['account_type'],
                    'attach_name'           => $idFrontTargetFile,
                    'attach_path'           => $idFrontTargetPath,
                    'attach_type'           => '',
                    'attach_img_type'      => 2,
                    'add_time'              => date('Y-m-d H:i:s'),
                );
                $result = Service_CustomerAttach::add( $add );
                if( !$result )
                    throw new Exception( Ec_Lang::getInstance()->getTranslate('updateFailed') );
            }
        }
        if( isset( $file['idCardBack'] )  && $file['idCardBack'] !== '' ) {
            $tmpPathInfo = pathinfo( $file['idCardBack'] );
            $idBackTargetFile = date('YmdHis')."_".Common_Common::random(5). '.' .$tmpPathInfo['extension'];
            $idBackTargetPath = $filePath . DIRECTORY_SEPARATOR . $idBackTargetFile;
            $hasIdBackImage = true;

            if( isset( $attach[ 3 ] ) ) {
                $result = Service_CustomerAttach::update( array(
                    'attach_name'=>$idBackTargetFile,
                    'attach_path' => $idBackTargetPath
                ), $attach[ 3 ]['customer_attach_id'], 'customer_attach_id' );
                if( !$result )
                    throw new Exception( Ec_Lang::getInstance()->getTranslate('updateFailed') );

            } else {
                $add = array(
                    'customer_id'           =>  $this->_customerAuth['account_id'],
                    'type'                   => $this->_customerAuth['account_type'],
                    'attach_name'           => $idBackTargetFile,
                    'attach_path'           => $idBackTargetPath,
                    'attach_type'           => '',
                    'attach_img_type'      => 3,
                    'add_time'              => date('Y-m-d H:i:s'),
                );
                $result = Service_CustomerAttach::add( $add );
                if( !$result )
                    throw new Exception( Ec_Lang::getInstance()->getTranslate('updateFailed') );
            }
        }
        $tempPath = Service_Resource::getInstance()->getUploadImageSavePath();
        if( $hasBlImage || $hasIdFrontImage || $hasIdBackImage ) {
            if( !file_exists( $filePath ) )
                if( false === mkdir( $filePath, 0766, true ) )
                    throw new Exception( '更新失败' );

        }
        //更新完再移动文件
        if( $hasBlImage ) {
            if( false === copy ( $tempPath . DIRECTORY_SEPARATOR . $file['businessLicense'] , $blTargetPath ) )
                throw new Exception( '更新失败' );

            @unlink( $tempPath . DIRECTORY_SEPARATOR . $file['businessLicense'] );
        }
        if( $hasIdFrontImage ) {
            if( false === copy ( $tempPath . DIRECTORY_SEPARATOR . $file['idCardFront'] ,  $idFrontTargetPath ) )
                throw new Exception( '更新失败' );

            @unlink( $tempPath . DIRECTORY_SEPARATOR . $file['idCardFront'] );
        }
        if( $hasIdBackImage ) {
            if( false === copy ( $tempPath . DIRECTORY_SEPARATOR . $file['idCardBack'] , $idBackTargetPath) )
                throw new Exception( '更新失败' );

            @unlink( $tempPath . DIRECTORY_SEPARATOR . $file['idCardBack'] );
        }
    }

    public function checkCompanyInfo( $params ) {
        $error = array();

        if( $params['companyName'] === '' ) {
            $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('enterpriseNameRequired') );
        } else {
            $len = mb_strlen( $params['companyName'] );
            if( $len < 6 || $len > 120 ) {
                $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('commpanyNameLengthError') );
            }
        }
        if( $params['register_address'] === '' ) {
            $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('addressRequired') );
        }
        if( $params['contacts'] === '' ) {
            $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('contactsRequired') );
        }
        if( $params['contactNumber'] === '' ) {
            $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('contactsNumberRequired') );
        }
        if( $params['email'] === '' ) {
            $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('emailRequired') );
        } else {
            if( false === Common_Common::checkEmail( $params['email'] ) ) {
                $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('wrongEmail') );
            }
        }
        if( $params['currency'] === '' ) {
            $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('currencyRequired') );
        //限制只能取美元
        } else if( $params['currency'] != 'USD') {
            $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('onlyUSDIsAllowed') );
        } else {
            /*$currency = strtoupper( $params['currency'] );
            $currencyRow = Service_Currency::getByField( $currency, 'currency_code');
            if( empty( $currencyRow ) ) {
                $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('currencyNotExisted') );
            }*/
        }

        $accountCode = strtoupper( $this->_customerAuth['account_code'] );
        $tempFilePath = dirname( APPLICATION_PATH ) . DIRECTORY_SEPARATOR. implode( DIRECTORY_SEPARATOR, array('data','images','temp') );

        if( $params['file']['businessLicense'] ) {
            $blImgArr = explode( '_', $params['file']['businessLicense'] );
            //判断图片开头的客户代码，防止图片名字呗修改
            if( $blImgArr[0] !== $accountCode || !file_exists( $tempFilePath . DIRECTORY_SEPARATOR . $params['file']['businessLicense'] )  ) {
                $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('businessLicenseImgExpired') );
            }

        }
        if( $params['file']['idCardFront'] ){
            $cfImgArr = explode( '_', $params['file']['idCardFront'] );
            //判断图片开头的客户代码，防止图片名字呗修改
            if( $cfImgArr[0] !== $accountCode || !file_exists( $tempFilePath . DIRECTORY_SEPARATOR . $params['file']['idCardFront'] ) ) {
                $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('frontIdCardImgExpired') );
            }
        }
        if( $params['file']['idCardBack'] ) {
            $cbImgArr = explode( '_', $params['file']['idCardBack'] );
            //判断图片开头的客户代码，防止图片名字呗修改
            if( $cbImgArr[0] !== $accountCode || !file_exists( $tempFilePath . DIRECTORY_SEPARATOR . $params['file']['idCardBack'] ) ) {
                $error[] = array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' =>  Ec_Lang::getInstance()->getTranslate('backIdCardImgRequired') );
            }
        }

        return $error;
    }
}