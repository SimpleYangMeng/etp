<?php
/**
 * @todo 校验设置API传过订单数据
 */
class Api_Seller extends Common_EtpApiProcess {
	private $modules='seller';
	private $fun='';
	private $defaultMaps=array();
	private $selfArr;
	/***
	 * 覆盖父类构造方法
	 * $selfArr=>自定义的一些参数
	 * 类似
	 * $selfArr = array(
	 * 'refcode'=>'***'//参考单号,有别的扩展在增加
	 * );
	 */
	public function __construct($selfArr){
		$this->selfArr=$selfArr;
	}

	private function getdefaultMap($fun){
		switch($fun){
			case "auditAccount":
				//卖家审核
				return $this->checkMaps();
				break;

		}
	}

	/**
	 * 买家审核默认传递参数的地图
	 */
	private function checkMaps(){
		$maps = array(
				'sellerId',
				'verifyCode',
				'verifyStatus',
				'verifyNote'
		);
		$this->defaultMaps=$maps;
	}

	/**
	 * @author william-fan
	 * @todo 用于买家审核接口
	 * $arr 提交的参数数组
	 * $maps 默认我们提交的参数名字和etp的名字的对应关系，如果和etp后台参数完全一致就不用传
	 */
	public function check($arr,$maps=array()){
		$this->fun='auditAccount';
		$this->getdefaultMap('auditAccount');
		//将参数转成etp后台调用的参数
		$converArr = $this->convertArr($arr,$maps);
		$obj = new Common_EtpApiProcess($this->modules,$this->fun,$this->selfArr);
		$result =  $obj->doRequest($converArr);
		return $result;
	}

	/**
	 * [regist 卖家注册]
	 *
	 * @return [type] [description]
	 */
	public function regist($postArr, $maps=array()){
		$this->fun='regist';
		//$this->getdefaultMap('buyerRecharge');
		//将参数转成etp后台调用的参数
		$converArr = $this->convertArr($postArr,$maps);
		/*
		print_r($converArr);
		print_r($this->modules);
		print_r($this->fun);
		exit;
		*/
		$obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
		$result =  $obj->doRequest($converArr);
		return $result;
	}

    /**
     * [activeAccount 买家账号激活接口]
     *
     * @param  [type] $postArr [description]
     * @param  array  $maps    [description]
     *
     * @return [type]          [description]
     */
    public function activeAccount($postArr, $maps=array()){
        $this->fun='activeAccount';
        $converArr = $this->convertArr($postArr, $maps);
        $obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
        $result =  $obj->doRequest($converArr);
        return $result;
    }

    /* @todo:绑定银行卡
     *
     */
    public function bindBankCard( $postArr, $maps=array() ) {
        $this->fun = 'bindBankCard';
        //$this->getdefaultMap('buyerRecharge');
        //将参数转成etp后台调用的参数
        $convertArr = $this->convertArr($postArr,$maps);
        /*
        print_r($converArr);
        print_r($this->modules);
        print_r($this->fun);
        exit;
        */
        $obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
        $result =  $obj->doRequest( $convertArr );
        return $result;
    }

	/**
	 * [modifyLoginPwd 卖家家修改登陆密码]
	 *
	 * @return [type] [description]
	 */
	public function modifyLoginPwd($postArr, $maps=array()){
		$this->fun = 'modifyLoginPwd';
		//$this->getdefaultMap('buyerRecharge');
		//将参数转成etp后台调用的参数
		$converArr = $this->convertArr($postArr,$maps);
		$obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
		$result =  $obj->doRequest($converArr);
		return $result;
	}

    /**
     * [modifyLoginPwd 修改支付密码
     *
     * @return [type] [description]
     */
    public function modifyPayPwd($postArr, $maps=array()){
        $this->fun = 'modifyPayPwd';
        //$this->getdefaultMap('buyerRecharge');
        //将参数转成etp后台调用的参数
        $converArr = $this->convertArr($postArr,$maps);
        $obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
        $result =  $obj->doRequest($converArr);
        return $result;
    }

    /* @todo:申请平安子账号
     *
     */
    public function applySubAccount($postArr,$maps) {
        $this->fun = 'applySubAccount';
        //$this->getdefaultMap('buyerRecharge');
        //将参数转成etp后台调用的参数
        $convertArr = $this->convertArr($postArr,$maps);
        /*
        print_r($converArr);
        print_r($this->modules);
        print_r($this->fun);
        exit;
        */
        $obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
        $result =  $obj->doRequest( $convertArr );
        return $result;
    }
    /* @desc:验证银行账号
     *
     */
    public function confirmBankCard( $postArr, $maps ) {
        $this->fun = 'validateBankCard';
        //$this->getdefaultMap('buyerRecharge');
        //将参数转成etp后台调用的参数
        $convertArr = $this->convertArr($postArr,$maps);
        /*
        print_r($converArr);
        print_r($this->modules);
        print_r($this->fun);
        exit;
        */
        $obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
        $result =  $obj->doRequest( $convertArr );
        return $result;
    }
}