<?php
/* @desc；日志管理器
 * @date:2016-10-27
 */
class Portal_BankController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->_layoutObj           = Zend_Registry::get('layout');
        $this->tplDirectory         = "portal/views/bank/";
        $this->_topTpl              = 'portal/views/default/top.tpl';
        $this->_innerHeaderTpl      = 'portal/views/default/header-inner.tpl';
        $this->_footerTpl           = 'portal/views/default/footer.tpl';
        if( $this->_customerAuth['account_type'] == 1 ){
            $this->_layoutFile      = 'purchaser-left-widget';
            $this->_leftTpl         = 'portal/views/default/left_buyer.tpl';
        } else {
            $this->_layoutFile      = 'supplier-left-widget';
            $this->_leftTpl         = 'portal/views/default/left.tpl';
        }
    }

    /* @desc:提现账户管理
     *
     */
    public function cardAction() {
        //买家没有绑定页面，直接跳回到登录首页
        if( $this->_customerAuth['account_type'] != 2 ) {
            $this->_redirect('/portal/purchaser/index');
            exit;
        }

        $bankAccount = $accountNo = $accountNoId = array();
        $accountRows = Service_PaJzbAccount::getByCondition( array( 'seller_id' => $this->_customerAuth['account_id'] ), array('account_id','account_no') );
        foreach( $accountRows as $value ) {
            if( $value['account_no'] == '' ) continue;
            if( in_array( $value['account_no'], $accountNo ) ) continue;
            $bankAccountRow = Service_PaJzbBankCard::getByCondition( array( 'account_no' => $value['account_no'] ) );
            $accountNoId[$value['account_no']] = $value['account_id'];
            $bankAccount = array_merge( $bankAccount, $bankAccountRow );
            $accountNo[] = $value['account_no'];
        }

        $this->_layoutObj->activeMenu = 'menu_bankaccount';

        $this->view->bankAccount = $bankAccount;
        $this->view->accountNoId = $accountNoId;
        $this->view->hasSubAccount = empty( $accountNo ) ? false : true ;
        echo Ec::renderTpl(
            $this->tplDirectory . 'bank-account-list.tpl',
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
        exit;
    }

    /* @desc:添加银行账号
     *
     */
    public function addBankCardAction() {
        //买家没有绑定页面，直接跳回到登录首页
        if( $this->_customerAuth['account_type'] == 1 ) {
            echo $this->_redirect('/portal/purchaser/index');
            exit;
        }
        $this->view->accountType = array (
             '1'=>Ec_Lang::getInstance()->getTranslate('insideAccount'),
             '2'=>Ec_Lang::getInstance()->getTranslate('outsideAccount'),
        );
        //获取省份
        $provinces = Service_PaJzbProvince::getByCondition(
            array(),
            array(
                'code' => 'node_nodecode',
                'name' => 'node_nodename')
        );
        //获取证件类型
        $idCardType = Service_BussinessStatus::getByCondition(
            array(
                'bussiness_table' => 'pa_jzb_bank_card',
                'bussiness_column'=>'id_card_type'
            ),
            '*'
        );
        $supperBank = Service_PaJzbSuperBankInfo::getByCondition( array( 'status'=>'ON'), array('No'=>'bankno','name'=>'bankname'));

        $this->_layoutObj->activeMenu = 'menu_bankaccount';

        $this->view->provinces = $provinces;
        $this->view->supperBank = $supperBank;
        $this->view->idCardType = $idCardType;
        echo Ec::renderTpl(
            $this->tplDirectory . 'add-bank-account.tpl',
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
            )
        );
        exit;
    }

    public function addNewOneAction() {
        if( $this->_customerAuth['account_type'] != 2 ) {
            die( json_encode( array( 'state'=>0,'message'=>Ec_Lang::getInstance()->getTranslate('buyerNoBindCardPrivilege') ) ));
            exit;
        }
        $return = array(
            'state' => 0,
            'message'=>'',
            'error' => array()
        );
        $bankAttr = trim( $this->_request->getParam( 'bankAttr', '') );
        if( $bankAttr === '' ) {
            $return['error'] = array( array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' => Ec_Lang::getInstance()->getTranslate('bankAttrRequired') ) );
            die(Zend_Json::encode($return));
        } else if( !in_array( $bankAttr, array(1,2)) ) {
            $return['error'] = array( array( 'errorCode' => Common_EtpCommon::$defaultErrorCode,'errorMsg' => Ec_Lang::getInstance()->getTranslate('bankAttrWrong') ) );
            die(Zend_Json::encode($return));
        }
        $maps = array(
            'seller_code'            => 'sellerCode',
            'bank_card_user_name'   => 'name',
            'id_card_type'           => 'idType',
            'id_card_No'             => 'idCode',
            'bank_card_no'           => 'bankCardNo',
            'phone_no'                => 'mobilePhone',
            'bank_type'               => 'bankType',
            'bank_code'               => 'bankCode',
            'super_bank_code'        => 'sBankCode',
        );
        $postArr = array(
            'seller_code'                       => $this->_customerAuth['account_code'],
            'bank_card_user_name'              => trim( $this->_request->getParam( 'cardOwner', '') ),
            'id_card_type'                      => trim( $this->_request->getParam( 'idCardType', '') ),
            'id_card_No'                        => trim( $this->_request->getParam( 'idNo', '') ),
            'bank_card_no'                      => trim( str_replace( ' ', '', $this->_request->getParam( 'bankAccountNo', '')) ),
            'phone_no'                           => trim( $this->_request->getParam( 'mobilePhone', '') ),
            'bank_type'                          => trim( $this->_request->getParam( 'bankType', '') ),
            'bank_code'                          => trim( $this->_request->getParam( 'bankNo', '') ),
            'super_bank_code'                   => trim( $this->_request->getParam( 'sBankNo2', '') ),
            'bank_attr'                          => $bankAttr,
        );
        $errorArr = Service_PaJzbBankCard::validator( $postArr );
        if (!empty( $errorArr )) {
            $return['error'] = Common_EtpCommon::transErrors($errorArr);
            die(Zend_Json::encode($return));
        }

        $obj = new Api_Seller( array() );
        $result = $obj->bindBankCard($postArr,$maps);
        if( $result['state'] == 1 ) {
            //获取最新的一条账号ID
            $account = Service_PaJzbAccount::getByCondition(
                array(
                    'seller_id'=>$this->_customerAuth['account_id'],
                    'account_phone_no'=>$postArr['phone_no']
                ),
                '*',1,1,'account_id desc');
            //获取银行卡ID
            if( $account && !empty( $account[0]['account_no'] ) ) {
                $bankCard = Service_PaJzbBankCard::getByCondition(
                    array(
                        'bank_card_no'=>$postArr['bank_card_no'],
                        'id_card_No'=>$postArr['bank_card_no'],
                        'account_no'=>$account[0]['account_no']
                    ));
                $result['bNo'] = $bankCard ? $bankCard[0]['bank_card_id'] : '';
            }
            $result['aNo'] = $account ? $account[0]['account_id'] : '';
        }
        die(Zend_Json::encode($result));
    }
    /* @desc:编辑银行账号
     *
     */
    public function editBankAccountAction() {

    }

    /* @desc:删除银行账号
     *
     */
    public function deleteBankAccountAction() {

    }

    /* @todo:申请子账号界面
     *
     */
    public function applySubAccountAction() {
        if( $this->_request->isPost() ) {
            $return = array(
                'state' => 0,
                'message'=>'',
                'error' => array()
            );
            if( $this->_customerAuth['account_type'] != 2 ) {
                $return['message'] = Ec_Lang::getInstance()->getTranslate('buyerNoBindCardPrivilege') ;
                die( json_encode( $return ) );
                exit;
            }
            //检查有没有子账号
            $accountRows = Service_PaJzbAccount::getByCondition(
                array(
                    'seller_id' => $this->_customerAuth['account_id'],
                    'account_no_not_null' => 1,
                ),
                'account_no',
                1,1);
            if( !empty( $accountRows ) ) {
                $return['message'] = '已经申请了子账号';
                die( json_encode( $return ) );
            }
            $maps = array(
                'seller_code'            => 'sellerCode',
                'account_nick_name'     => 'nickName',
                'account_phone_no'      => 'mobilePhone',
                'account_email'          => 'email',
            );
            $postArr = array(
                'seller_code'                       => $this->_customerAuth['account_code'],
                'account_nick_name'                => $this->_customerAuth['account_name'],
                'account_phone_no'                 => trim( $this->_request->getParam( 'mPhone', '') ),
                'account_email'                     => $this->_customerAuth['email'],
            );
            $error = Service_PaJzbAccount::validator( $postArr );
            if (!empty( $error )) {
                $return['error'] = Common_EtpCommon::transErrors($error);
                die(Zend_Json::encode($return));
            }

            $obj = new Api_Seller( array() );
            $return = $obj->applySubAccount($postArr,$maps);
            die( json_encode( $return ) );
        }
        if( $this->_customerAuth['account_type'] != 2 ) {
            echo $this->_redirect('/portal/purchaser/index');
            exit;
        }

        $this->_layoutObj->activeMenu = 'menu_bankaccount';

        $template = 'apply-for-sub-account.tpl';
        echo Ec::renderTpl(
            $this->tplDirectory . $template,
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
        exit;
    }

    public function confirmBankCardAction() {
        $template = 'confirm-bank-account.tpl';
        $this->view->aNo = trim( $this->_request->getParam( 'aNo', '' ) );
        $this->view->bNo = trim( $this->_request->getParam( 'bNo', '' ) );

        $this->_layoutObj->activeMenu = 'menu_bankaccount';

        echo Ec::renderTpl(
            $this->tplDirectory . $template,
            $this->_layoutFile,
            '我的ETP',
            null,
            null,
            array(
                'top'           => $this->_topTpl,
                'innerHeader'  => $this->_innerHeaderTpl,
                'footer'        => $this->_footerTpl,
            )
        );
        exit;
    }
    /* @todo:确认卡号
     *
     */
    public function doConfirmCardAction() {
        $bankCardId     = trim( $this->_request->getParam( 'bNo','') );
        $accountId     = trim( $this->_request->getParam( 'aNo','') );
        $amount = trim( $this->_request->getParam( 'amount', '' ) );

        $return = array(
            'state' => 0,
            'message'=>'',
            'error' => array()
        );

        if( $amount === '') {
            $return['error'][] = array('errorCode'=>Common_EtpCommon::$defaultErrorCode,'errorMsg'=>'金额不能为空');
        } else if( !is_numeric( $amount ) ) {
            $return['error'][] = array('errorCode'=>Common_EtpCommon::$defaultErrorCode,'errorMsg'=>'金额必须是数字');
        }
        $card = array();
        if( $bankCardId === '' || $accountId === '' ) {
            $return['error'][] = array('errorCode'=>Common_EtpCommon::$defaultErrorCode,'errorMsg'=>'银行卡信息不正确');
        } else {
            $account = Service_PaJzbAccount::getByCondition( array( 'account_id' => $accountId, 'seller_id'=>$this->_customerAuth['account_id'] ) );
            if( empty( $account ) || empty( $account[0]['account_no'] )) {
                $return['error'][] = array('errorCode'=>Common_EtpCommon::$defaultErrorCode,'errorMsg'=>'银行卡不存在');
            } else {
                $card = Service_PaJzbBankCard::getByCondition( array( 'account_no' => $account[0]['account_no'],'bank_card_id' => $bankCardId ));
                if( empty( $card ) ) {
                    $return['error'][] = array('errorCode'=>Common_EtpCommon::$defaultErrorCode,'errorMsg'=>'银行卡不存在');
                } else if( $card[0]['status'] == 2) {
                    $return['error'][] = array('errorCode'=>Common_EtpCommon::$defaultErrorCode,'errorMsg'=>'银行卡已激活');
                }
            }
        }
        if( !empty( $return['error'] ) ) {
            die( json_encode( $return ) );
        }

        $maps = array(
            'seller_code'       =>  'sellerCode',
            'bank_card_no'      => 'bankCardNo',
            'tran_amount'       => 'tranAmount',
            'currency'          => 'currency',
        );
        $postArr = array(
            'seller_code'       =>  $this->_customerAuth['account_code'],
            'bank_card_no'      => $card[0]['bank_card_no'],
            'tran_amount'       => $amount,
            'currency'          => $this->_customerAuth['currency'],
        );
        $obj = new Api_Seller( array() );
        $return = $obj->applySubAccount($postArr,$maps);
        die( json_encode( $return ) );
    }

    /* @todo:获取大小额行号
     *
     */
    public function getBankAction() {
        $province       = trim( $this->_request->getParam( 'province', '' ) );
        $city           = trim( $this->_request->getParam( 'city', '' ) );
        $district       = trim( $this->_request->getParam( 'district', '' ) );
        $keyword           = trim( $this->_request->getParam( 'keyword', '' ) );
        $condition = array();
        if( $city ) {
            $condition['citycode'] = $city;
        } else if( $province ) {
            //将省份转成城市
            $cityRows =  Service_PaJzbCity::getByCondition( array( 'city_nodecode'=>$province, 'city_areatype'=>2 ), 'city_areacode' );
            $condition['citycode'] = array();
            foreach( $cityRows as $value ) {
                $condition['citycode'][] = $value['city_areacode'];
            }
        }
        if( $district !== '' )
            $condition['bankname_like_1'] = $district;

        if( $keyword !== '' )
            $condition['bankname_like_2'] = $keyword;

        $bank = Service_PaJzbBankInfo::getByCondition( $condition, array( 'No'=>'bankno', 'Name'=>'bankname' ) );
        die( json_encode( $bank ) );
    }
}