<?php
class Ec_Controller_DefaultAction extends Zend_Controller_Action
{

    public function init()
    {
        parent::init();
        $this->view = Zend_Registry::get('EcView');
    }

    //当不存在的方法时调用
    public function __call($methodName, $args)
    {
        $error_handler = array(
            'error_type' => Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER,
        );
        $this->_forward('error', 'error', 'default', $error_handler);
    }
}
