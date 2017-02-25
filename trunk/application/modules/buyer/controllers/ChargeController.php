<?php
/* @desc；采购商充值相关控制器
 * @date:2016-10-27
 */
class Buyer_ChargeController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "buyer/views/charge/";

        $this->_layoutObj           = Zend_Registry::get('layout');
        $this->_layoutFile          = 'purchaser-left-widget';

        $this->_topTpl              = 'buyer/views/layout/top.tpl';
        $this->_innerHeaderTpl      = 'buyer/views/layout/header-inner.tpl';
        $this->_footerTpl           = 'buyer/views/layout/footer.tpl';
        $this->_leftTpl             = 'buyer/views/layout/left.tpl';
    }
    /**
     * @author william-fan
     * @todo 买家充值列表
     */
    public function rechargeListAction(){
        $type = Common_DataCache::getBusinessStatus('buyer_recharge', 'charge_type', 1, 0, $this->language);
        $status = Common_DataCache::getBusinessStatus('buyer_recharge', 'status', 1, 0, $this->language);
        if ($this->_request->isPost()) {
            $condition = $this->_request->getParam('condition', array());
            $page = $this->_request->getParam('page', 1);
            $pageSize = $this->_request->getParam('pageSize', 10);
            $page = $page ? $page : 1;
            $pageSize = $pageSize ? $pageSize : 10;
            $condition['buyer_id'] = $this->_customerAuth['account_id'];
            /*print_r($condition);
            exit;*/
            $count = Service_BuyerRecharge::getByCondition($condition, 'count(*)');
            if($count){
                $pageTotal = ceil($count / $pageSize);
                $showFields=array(
                    'buyer_recharge_id',
                    'recharge_code',
                    'charge_type',
                    'status',
                    'charge_bank_name',
                    'charge_bank_card',
                    'charge_bank_card_name',
                    'charge_value',
                    'actual_charge_value',
                    'charge_currency',
                    'note',
                    'add_time',
                );
                $obj = new Service_BuyerRecharge();
                $alias = $obj->getFieldsAlias( $showFields );

                //$status = Common_DataCache::getBusinessStatusMap('buyer_recharge', 'status', array(1,2) );
                //$type = Common_DataCache::getBusinessStatusMap('buyer_recharge', 'charge_type', array(1,2) );
                $rows = Service_BuyerRecharge::getByCondition($condition,$alias, $pageSize, $page, array('buyer_recharge_id desc'));
                foreach( $rows as $key => $value ) {
                    $s2 = substr( $value['E6'],-4 );
                    $s3 = str_pad( $s2, strlen($value['E6']), '*', STR_PAD_LEFT );
                    $rows[$key]['E6'] = implode(' ', str_split( $s3, 4 ) );
                    //$rows[ $key ][ 'E3_0' ] = isset( $type[ $value['E3'] ] ) ? ( $this->language == 'zh_CN' ? $type[ $value['E3'] ]['bussiness_value_name'] : $type[ $value['E3'] ]['bussiness_value_en'] ) : '-';
                    $rows[ $key ][ 'E3_0' ] = isset($type[$value['E3']]) ? $type[$value['E3']] : Ec_Lang::getInstance()->getTranslate('undefine');
                    //$rows[ $key ][ 'E4_0' ] = isset( $status[ $value['E4'] ] ) ? ( $this->language == 'zh_CN' ? $status[ $value['E4'] ]['bussiness_value_name'] : $status[ $value['E4'] ]['bussiness_value_en'] ) : '-';
                    $rows[ $key ][ 'E4_0' ] = isset($status[$value['E4']]) ? $status[$value['E4']] : Ec_Lang::getInstance()->getTranslate('undefine');
                }
                $return['data'] = $rows;
                $return['state'] = 1;
                $return['pageTotal'] = $pageTotal;
                $return['status'] = $status;
                $return['type'] = $type;
            }
            $return['total'] = $count;
            die(Zend_Json::encode($return));
        }
        //$status = Common_DataCache::getBusinessStatusMap('buyer_recharge', 'status', array(1,2) );
        //$type = Common_DataCache::getBusinessStatusMap('buyer_recharge', 'charge_type', array(1,2) );
        $this->view->type = $type;
        $this->view->status = $status;
        //菜单样式
        $this->_layoutObj->activeMenu = 'rechargeList';
        $this->_layoutObj->includeBsPage = true;
        $this->_layoutObj->includeBsDate = true;
        $this->view->account = $this->_customerAuth;
        echo Ec::renderTpl(
            $this->tplDirectory . 'recharge_list.tpl',
            'purchaser-left-widget',
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
    /**
     * @author william-fan
     * @todo 用于买家充值
     */
    public function rechargeAction(){
        $this->_layoutObj->activeMenu = 'recharge';
        echo Ec::renderTpl(
            $this->tplDirectory . 'recharge.tpl',
            'purchaser-left-widget',
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
     * @author william-fan
     * @todo 买家平安充值
     */
    public function parechargeAction(){
        $this->_layoutObj->activeMenu = 'recharge';
        if($this->_request->isPost()) {
            //平安充值申请提交
            $param = $this->_request->getParams();
            //$charge_bank_name           = $param['charge_bank_name'];//转出银行
            //$charge_bank_card_name      = $param['charge_bank_card_name'];//转出账户名
            $recharge_code              = $param['recharge_code'];//充值流水号
            $charge_bank_card           = $param['charge_bank_card'];//转出账号
            $charge_value               = $param['charge_value'];//充值金额
            $charge_currency            = $param['charge_currency'];//交易币种
            $note                       = $param['note'];//备注

            $charge_type = '1'; //通过平安充值默认为1

            $maps = array(
                'buyer_id'=>'buyerId',
                'recharge_code'=>'rechargeCode',
                'charge_type'=>'chargeType',
                'charge_bank_card'=>'chargeBankCard',
                'charge_value'=>'chargeValue',
                'charge_currency'=>'chargeCurrency',
                'note'=>'note'
            );

            $buy_id = $this->_customerAuth['account_id'];

            $postArr = array(
                'buyer_id'=>$buy_id,
                'charge_type'=>$charge_type,
                'recharge_code'=>$recharge_code,
                'charge_bank_card'=>$charge_bank_card,
                'charge_value'=>$charge_value,
                'charge_currency'=>$charge_currency,
                'note'=>$note,
            );
            //print_r($postArr);

            $obj = new Service_BuyerRecharge();

            $errorArr = $obj->validatorRechargepa($postArr);

            if (!empty($errorArr)) {
                $errorArr=Common_EtpCommon::transErrors($errorArr);
                //print_r($errorArr);
                $return = array(
                    'state' => 0,
                    'message'=>'',
                    'error' => $errorArr
                );
                die(Zend_Json::encode($return));
            }
            $refArr = array(
                'refcode'=>$recharge_code
            );
            //Api_Buyer::check($postArr,$maps);
            $obj = new Api_Buyer($refArr);
            $result = $obj->recharge($postArr,$maps);
            //print_r($result);
            die(Zend_Json::encode($result));
            //print_r($param);
        }

        echo Ec::renderTpl(
            $this->tplDirectory . 'parecharge.tpl',
            'purchaser-left-widget',
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
     * @author william-fan
     * @todo 买家渣打充值
     */
    public function zdrechargeAction(){
        $this->_layoutObj->activeMenu = 'recharge';
        if($this->_request->isPost()) {
            //渣打申请提交
            $param = $this->_request->getParams();
            //$charge_bank_name           = $param['charge_bank_name'];//转出银行
            //$charge_bank_card_name      = $param['charge_bank_card_name'];//转出账户名
            $recharge_code              = $param['recharge_code'];//充值流水号
            $charge_bank_card           = $param['charge_bank_card'];//转出账号
            $charge_value               = $param['charge_value'];//充值金额
            $charge_currency            = $param['charge_currency'];//交易币种
            $note                       = $param['note'];//备注

            $charge_type = '3'; //通过渣打默认为3

            $maps = array(
                'buyer_id'=>'buyerId',
                //'recharge_code'=>'rechargeCode',
                'charge_type'=>'chargeType',
                /*'charge_bank_card'=>'chargeBankCard',
                'charge_value'=>'chargeValue',
                'charge_currency'=>'chargeCurrency',
                'note'=>'note'*/
            );

            $buy_id = $this->_customerAuth['account_id'];

            $postArr = array(
                'buyer_id'=>$buy_id,
                'charge_type'=>$charge_type,
               /* 'recharge_code'=>$recharge_code,
                'charge_bank_card'=>$charge_bank_card,
                'charge_value'=>$charge_value,
                'charge_currency'=>$charge_currency,
                'note'=>$note,*/
            );
            //print_r($postArr);

            $obj =new Service_BuyerRecharge();

            $errorArr = $obj->validatorRechargezd($postArr);

            if (!empty($errorArr)) {
                $errorArr=Common_EtpCommon::transErrors($errorArr);
                //print_r($errorArr);
                $return = array(
                    'state' => 0,
                    'message'=>'',
                    'error' => $errorArr
                );
                die(Zend_Json::encode($return));
            }
            $refArr = array(
                'refcode'=>$recharge_code
            );
            //Api_Buyer::check($postArr,$maps);
            $obj = new Api_Buyer($refArr);
            $result = $obj->recharge($postArr,$maps);
            //print_r($result);
            die(Zend_Json::encode($result));
            //print_r($param);
        }
        echo Ec::renderTpl(
            $this->tplDirectory . 'zdrecharge.tpl',
            'purchaser-left-widget',
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
     * @author william-fan
     * @todo 用于买家充值详情
     */
    public function rechargeViewAction(){
        $return = array('state'=>0, 'data'=> '', 'message'=> '');
        $status = Common_DataCache::getBusinessStatus('buyer_recharge', 'status', 1, 0, $this->language);
        $type = Common_DataCache::getBusinessStatus('buyer_recharge', 'charge_type', 1, 0, $this->language);

        $buyer_recharge_id = $this->_request->getParam('parmId', 0);
        if(!empty($buyer_recharge_id)){
            $row = Service_BuyerRecharge::getByField($buyer_recharge_id, 'buyer_recharge_id');
            if(!empty($row)){
                $return['state'] = 1;
                $row['status_text'] = isset($status[$row['status']]) ? $status[$row['status']] : Ec_Lang::getInstance()->getTranslate('undefine');
                $return['data'] = $row;
            }else {
                $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
            }
        }else {
            $return['message'] = Ec_Lang::getInstance()->getTranslate('paramsError');
        }
        //print_r($return);
        //菜单样式
        $this->_layoutObj->activeMenu = 'rechargeList';
        $this->view->return = $return;
        $this->view->type = $type;
        echo Ec::renderTpl(
            $this->tplDirectory . 'buyer_recharge_view_detail.tpl',
            'purchaser-left-widget',
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
    
}