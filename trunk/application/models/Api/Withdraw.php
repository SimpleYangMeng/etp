<?php
/**
 * @todo 提现 API withdraw
 */
class Api_Withdraw extends Common_EtpApiProcess {
	//调用模块名称
	private $modules = 'withdraw';
	//
	private $fun = '';
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
		$this->selfArr = $selfArr;
	}

	/**
	 * [apply description]
	 *
	 * @param  [type] $postArr [传递数组]
	 * @param  array  $maps    [参数转换数组]
	 *
	 * @return [type]          [接口返回数据]
	 */
	public function apply($postArr, $maps=array()){
		$this->fun='apply';
		//$this->getdefaultMap('buyerRecharge');
		//将参数转成etp后台调用的参数
		$converArr = $this->convertArr($postArr,$maps);
		$obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
		$result =  $obj->doRequest($converArr);
		// print_r($converArr);
		// print_r($this->modules);
		// print_r($this->fun);
		// exit;
		return $result;
	}
}