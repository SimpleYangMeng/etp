<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 2016-11-02
 * Time: 17:03
 * todo etp api对接类
 */
class Common_EtpApiProcess{
    private $website='http://10.24.230.55';
    private $port=8060;//接口地址
    private $apiKey='17F96064551CCFDDE050007F0100760A';
    private $url = '';
    private $scheme = 'http';
    private $timeout = 500;
    private $module;
    private $fun;
    private $requestArr;//请求数组
    private $reponse;//返回的参数
    private $refcode=''; //参考单号
    private $selfArr=array(); //程序使用的自定义的一些参数数组
    private $isConfig = true;//是否在数据库里配置了API相关参数

    private $urlMap = array(
        'buyer'=>array(
            'regist'=>'/rs/buyer/regist',###注册
            'activeAccount'=>'/rs/buyer/activeAccount',##激活
            'modifyAccount'=>'/rs/buyer/modifyAccount',##修改账户
            'auditAccount'=>'/rs/buyer/auditAccount',##买家审核接口
            'buyerRecharge'=>'/rs/recharge/buyerRecharge',##买家充值
            'dealRecharge'=>'/rs/recharge/dealRecharge',##买家充值异常处理
            'modifyLoginPwd'=>'/rs/buyer/modifyLoginPwd',
            'modifyPayPwd'=>'/rs/buyer/modifyPayPwd',
            'auditAccount'=>'/rs/buyer/auditAccount',
        ),
        'seller'=>array(
            'regist'=>'/rs/seller/regist',
            'activeAccount'=>'/rs/seller/activeAccount',
            'modifyAccount'=>'/rs/seller/modifyAccount',
            'modifyLoginPwd'=>'/rs/seller/modifyLoginPwd',
            'auditAccount'=>'/rs/seller/auditAccount',##卖家审核接口
            'applySubAccount'=>'/rs/seller/applySubAccount',
            'bindBankCard'=>'/rs/seller/bindBankCard',
            'validateBankCard'=>'/rs/seller/validateBankCard',
            'modifyPayPwd'=>'/rs/seller/modifyPayPwd',
        ),
        'order'=>array(
            'payOrder' => '/rs/order/payOrder',
            'cancelOrder' => '/rs/order/cancelOrder',
            'bindOrder' => '/rs/order/bindOrder',
        ),
        'withdraw'=>array(
            'apply'=>'/rs/withdraw/apply',
        ),
        'settlement'=>array(
            'apply'=>'/rs/settlement/apply',##结汇申请
        ),
    );

    public function __construct($modular,$function,$selfarr=array()) {
        /*
        if(!isset($this->urlMap[$modular][$function])){
            throw new Exception(Ec_Lang::getInstance()->getTranslate('paramsError'), 6000);
        }
        */
        try {
            $this->initApi();
        } catch( Exception $e ) {
            $this->isConfig = false;
        }
        $this->url=$this->website.'/'.$this->urlMap[$modular][$function];
        if(strtolower(substr($this->website,0,5))=='https'){
            $this->scheme = 'https';
        }else{
            if($this->port!=80){
                $this->url=$this->website.':'.$this->port.$this->urlMap[$modular][$function];
            }else{
                $this->url=$this->website.$this->urlMap[$modular][$function];
            }
        }
        $this->module=$modular;
        $this->fun=$function;
        $this->selfArr=$selfarr;
    }

    private function initApi() {
        $api = Common_DataCache::getEtpApiParam();
        if( !isset( $api['front_api_scheme'] ) || $api['front_api_scheme']['config_value'] == '' ) {
            throw new Exception('API is not config');
        }
        if( !isset( $api['front_api_host'] ) || $api['front_api_host']['config_value'] == '' ) {
            throw new Exception('API is not config');
        }
        if( !isset( $api['front_api_port'] ) || $api['front_api_port']['config_value'] == '' ) {
            throw new Exception('API is not config');
        }
        if( !isset( $api['front_api_key'] ) || $api['front_api_key']['config_value'] == '' ) {
            throw new Exception('API is not config');
        }
        $this->website  = $api['front_api_scheme']['config_value'].'://'.$api['front_api_host']['config_value'];
        $this->port     = $api['front_api_port']['config_value'];
        $this->apiKey   = $api['front_api_key']['config_value'];
    }

    /**
     * @author william-fan
     * 用于设置标准的post参数
     */
    private function setPost($arr){
        $content = json_encode($arr);
        $postArr = array(
            'appKey'=>$this->apiKey,
            'timestamp'=>time(),
            'version'=>'1.0',
            'content'=>$content
        );
        $this->requestArr=$postArr;
    }

    /***
     * @arr 是请求etp后台参数的数组
     */
    public function doRequest($arr){
        if( $this->isConfig == false ) {
            $msg = '{"ack": "Failure", "errorCode":"10001", "errorMsg":"'.Ec_Lang::getInstance()->getTranslate('serviceNotAvailable').'"}';
            return $this->getResult($msg,'0');
        }
        $this->setPost($arr);
        if(!$this->module){
            $msg = '{"ack": "Failure", "errorCode":"10001", "errorMsg":"'.Ec_Lang::getInstance()->getTranslate('moduleLost').'"}';
            return $this->getResult($msg,'0');
        }
        if(!$this->fun){
            $msg = '{"ack": "Failure", "errorCode":"10001", "errorMsg":"'.Ec_Lang::getInstance()->getTranslate('functionLost').'"}';
            return $this->getResult($msg,'0');
        }

        if($this->scheme=='https'){
            $data = Common_Common::https_post($this->url,$this->timeout,$this->requestArr);
        }else{
            $data = Common_Common::http_post($this->url,$this->timeout,$this->requestArr);
        }
        //$this->requestArr=$arr;
        $this->reponse=$data;
        if(isset($this->selfArr['refcode'])){
            $this->refcode=$this->selfArr['refcode'];
        }
        return $this->getResult($data);
    }
    /**
     * @将数据处理成统一的格式
     *  $mark =1记录到api访问请求的日志中.否则不记录
     */
    private function getResult($data, $mark='1'){
        $result = array(
            'state'=>'0',
            'message'=>'',
            'error'=>array(
            )
        );
        $info = json_decode($data,true);
        if(!empty($info) && is_array($info)){
            if($info['ack'] == 'Success'){
                $result['state'] = '1';
                $result['reference'] = isset($info['reference']) && !empty($info['reference']) ? $info['reference'] : '';
                $result['message'] = $info['ack'];
            }else if($info['ack'] == 'Failure'){
                $error = array(
                    'errorCode'=>$info['errorCode'],
                    'errorMsg'=>$info['errorMsg'].( isset( $info['reference'] ) ? $info['reference'] : '')
                );
                $result['error'][]=$error;
            }else{
                $result['message'] = Ec_Lang::getInstance()->getTranslate('systemStatus').$info['ack'];
            }
        }else{
            $result['message'] = Ec_Lang::getInstance()->getTranslate('serviceNotAvailable').'.'.$data;
        }
        if($mark){
            $this->recordApi($result);
        }
        return $result;
    }
    /**
     * @todo 记录api请求
     */
     private function recordApi($result){
        $requestRow = array(
            'api_type'=>'send',
            'api_name'=>$this->module.$this->fun,
            'api_url'=>$this->url,
            'refer_code'=>$this->refcode,
            'module'=>$this->module,
            'sub_module'=>$this->fun,
            'add_date'=>date("Y-m-d H:i:s",time()),
            'paramer_request'=>json_encode($this->requestArr),
            'paramer_response'=>$this->reponse,
            'am_message'=>$result['message'],
            'update_date'=>date("Y-m-d H:i:s",time()),
        );
        $res = Service_ApiMessage::createApiMessageProcess($requestRow);
     }

     /**
      * [convertArr 格式化数组]
      *
      * @param  [type] $params [description]
      * @param  array  $maps   [description]
      *
      * @return [type]         [description]
      */
    protected function convertArr($params,$maps=array()){
        if(empty($maps)){
            return $params;
        }
        $convertFieldsArr = array();
        foreach ($maps as $key => $val) {
            if (isset($params[$key])) {
                $convertFieldsArr[$val] = $params[$key];
            }
        }
        return $convertFieldsArr;
    }
}