<?php

class Default_ErrorController extends Zend_Controller_Action
{
    public function init()
    {
        $this->view = Zend_Registry::get('EcView');
    }

    /**
     * [preDispatch description]
     *
     * @return [type] [description]
     */
    public function preDispatch()
    {
        $language = Ec_Lang::getInstance()->getCurrentLanguage();
        $this->language = empty($language) ? 'zh_CN' : $language;
        $this->tplDirectory = "default/views/error/";
    }
    /**
     * [errorAction description]
     *
     * @return [type] [description]
     */
    public function errorAction()
    {
        $params = $this->_request->getParams();
        $this->view->visit_url = $params['module'].DIRECTORY_SEPARATOR.$params['controller'].DIRECTORY_SEPARATOR.$params['action'];
        $errorType = isset($params['error_type']) ? $params['error_type'] : '';
        switch ($errorType) {
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER:
            case Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_ACTION:
                $this->getResponse()->setHttpResponseCode(404);
                $this->view->code = '404';
                $this->view->message = 'The page you requested was not found.';
                break;
            default:
                $this->view->code = '500';
                $this->getResponse()->setHttpResponseCode(500);
                $this->view->message = 'The page you visit is denied access.';
                break;
        }
        $this->view->languageTpl = $this->language;
        echo Ec::renderTpl($this->tplDirectory . "error.tpl", "layout-etp");
    }

    /**
     * [denyAction description]
     *
     * @return [type] [description]
     */
    public function denyAction()
    {
        echo Ec::renderTpl($this->tplDirectory . "deny.tpl", "layout-etp");
    }

    /**
     * [__call description]
     *
     * @param  [type] $methodName [description]
     * @param  [type] $args       [description]
     *
     * @return [type]             [description]
     */
    public function __call($methodName, $args)
    {
        $error_handler = array(
            'error_type' => Zend_Controller_Plugin_ErrorHandler::EXCEPTION_NO_CONTROLLER,
        );
        $this->_forward('error', 'error', 'default', $error_handler);
    }

}