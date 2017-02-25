<?php
class Portal_IndexController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->tplDirectory = "portal/views/default/";
    }

	public function globalAction(){
   		$this->view->aBalance = Service_CustomerBalance::getByField($this->_customerAuth['id'], 'customer_id');
        $customerAPIArray = Service_CustomerApi::getByField($this->_customerAuth['id'],'customer_id');
        $this->view->customerAPIArray = $customerAPIArray;
    	$this->view->currency = $this->_customerAuth['customer_currency'];
    	/* $warehouse = Common_DataCache::getWarehouse();
    	$this->view->warehouse = $warehouse; */
    	//ASN备货
    	$warehouseBH = Common_DataCache::getWarehousebh();
    	$this->view->warehouseBH = $warehouseBH;
    	$warehouseBH_ids = array();
    	foreach($warehouseBH as $row) $warehouseBH_ids[] = $row['warehouse_id'];
    	$asnStatBH = Service_AsnProccess::statStatus($this->_customerAuth['id'], 0, $warehouseBH_ids);
    	$this->view->asnStatBHAll = $asnStatBH[0];
    	$this->view->asnStatBH = json_encode($asnStatBH);
    	//ASN集货
    	$warehouseJH = Common_DataCache::getWarehousejh();
    	$this->view->warehouseJH = $warehouseJH;
    	$warehouseJH_ids = array();
    	foreach($warehouseJH as $row) $warehouseJH_ids[] = $row['warehouse_id'];
    	$asnStatJH = Service_AsnProccess::statStatus($this->_customerAuth['id'], 1, $warehouseJH_ids);
    	$this->view->asnStatJHAll = $asnStatJH[0];
    	$this->view->asnStatJH = json_encode($asnStatJH);
    	//Order备货
    	$orderStatBH = Service_OrderProcess::statStatus($this->_customerAuth['id'], 0);
    	$this->view->orderStatBH = $orderStatBH;
    	//Order集货
    	$orderStatJH = Service_OrderProcess::statStatus($this->_customerAuth['id'], 1);
    	$this->view->orderStatJH = $orderStatJH;
        $this->view->customer_id = $this->_customerAuth['id'];
        $session = new Zend_Session_Namespace('customerAuth');
        $customer_type = $session->data['customer_type'];
        $this->view->customer_type = $customer_type;
		echo Ec::renderTpl($this->tplDirectory . "global.tpl", 'noleftlayout');
	}
    public function indexAction()
    {  	
    	echo Ec::renderTpl($this->tplDirectory . "index.tpl", 'layout');
    }
	
	
    
    /**
     * @author william-fan
     * @todo 用于输出header
     */
    public function headerAction(){
    	$this->view->user	= $this->_customerAuth;
    	$lang=Ec_Lang::getInstance()->getCurrentLanguage();
    	if($lang==''){
    		$lang='zh_CN'; //默认为中文
    	}
    	$this->view->lang = $lang;
    	echo $this->view->render($this->tplDirectory . 'header.tpl');
    	//echo Ec::renderTpl($this->tplDirectory . "header.tpl", 'layout-index');
    }
    /**
     * @author william-fan
     * @todo 用于left
     */
    public function leftMenuAction(){
      $user = $this->_customerAuth;
      $isMaster = isset($user['is_master']) ? $user['is_master'] : FALSE;

      if ($isMaster) {
        $this->view->menu = Service_AccountPrivilege::getDefaultPrivilege(TRUE);
        //print_r(Service_AccountPrivilege::getDefaultPrivilege(TRUE));exit();
      }
      else {
        $this->view->menu = Service_AccountPrivilege::getAccountPrivilege($user['account_id']);
        //print_r(Service_AccountPrivilege::getAccountPrivilege($user['account_id']));exit();
      }
    	//Ec::renderTpl($this->tplDirectory . 'left-menu.tpl', 'layoutn');
    	echo $this->view->render($this->tplDirectory . 'left-menu.tpl');
    }
    /**
     * @author william-fan
     * @todo header-inner
     */
    public function headerInnerAction(){
    	echo $this->view->render($this->tplDirectory . 'header-inner.tpl');
    }
}