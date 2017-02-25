<?php
class Default_MenuController extends Ec_Controller_DefaultAction
{


    public function preDispatch()
    {
        $this->view->errMsg = '';
        $this->tplDirectory = "default/views/default/";
    }   

    public function headerInnerAction(){
        echo $this->view->render($this->tplDirectory . 'header-menu-inner.tpl');
    }
    public function footerInnerAction() {
        echo $this->view->render($this->tplDirectory . 'footer-menu-inner.tpl');
    }
    public function headerAction(){
        $session			= new Zend_Session_Namespace('RegisterStep');
        $session->step = '4';
        $this->view->step = $session->step;
        //echo $this->view->render($this->tplDirectory ."header.tpl");
    }
}