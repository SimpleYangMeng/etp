<?php
/**
 * @todo 订单 API Order
 */
class Api_Order extends Common_EtpApiProcess {
	//调用模块名称
	private $modules = 'order';
	private $fun = '';
	private $defaultMaps = array();
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
	 * [bindOrder 绑定订单]
	 *
	 * @param  [type] $postArr [description]
	 * @param  array  $maps    [description]
	 *
	 * @return [type]          [description]
	 */
	public function bindOrder($postArr, $maps=array()){
		$this->fun='bindOrder';
		//$this->getdefaultMap('buyerRecharge');
		//将参数转成etp后台调用的参数
		$converArr = $this->convertArr($postArr, $maps);
		$obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
		$result = $obj->doRequest($converArr);
		return $result;
	}

	/**
	 * [apply 支付订单]
	 *
	 * @param  [type] $postArr [传递数组]
	 * @param  array  $maps    [参数转换数组]
	 *
	 * @return [type]          [接口返回数据]
	 */
	public function payOrder($postArr, $maps=array()){
		$this->fun='payOrder';
		//$this->getdefaultMap('buyerRecharge');
		//将参数转成etp后台调用的参数
		$converArr = $this->convertArr($postArr, $maps);
		$obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
		$result =  $obj->doRequest($converArr);
		return $result;
	}

	/**
	 * [apply 取消订单]
	 *
	 * @param  [type] $postArr [传递数组]
	 * @param  array  $maps    [参数转换数组]
	 *
	 * @return [type]          [接口返回数据]
	 */
	public function cancelOrder($postArr, $maps=array()){
		$this->fun='cancelOrder';
		//$this->getdefaultMap('buyerRecharge');
		//将参数转成etp后台调用的参数
		$converArr = $this->convertArr($postArr, $maps);
		$obj = new Common_EtpApiProcess($this->modules, $this->fun, $this->selfArr);
		$result =  $obj->doRequest($converArr);
		return $result;
	}
}