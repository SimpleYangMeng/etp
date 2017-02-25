<?php
class Default_LoadjsController extends Zend_Controller_Action{
	public function init()
	{
		$this->view = Zend_Registry::get('EcView');
	}
	
	public function preDispatch()
	{
		$this->tplDirectory = "default/views/js/";
	}
	public function loadJsAction(){
        $jsName = $this->_request->getParam('name','');
        switch($jsName){
            case 'language':
                echo $this->view->render($this->tplDirectory . "language_zh.tpl");
                echo $this->view->render($this->tplDirectory . "language_en.tpl");
                break;
        }
        exit;
    }
}