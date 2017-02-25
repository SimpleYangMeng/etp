<?php
class Portal_MenuController extends Ec_Controller_DefaultAction
{


    public function preDispatch()
    {
        $this->view->errMsg = '';
        $this->tplDirectory = "portal/views/default/";
    }   

    public function headerInnerAction(){
        echo $this->view->render($this->tplDirectory . 'header-inner.tpl');
    }
    public function headerAction(){
        $session			= new Zend_Session_Namespace('RegisterStep');
        $session->step = '4';
        $this->view->step = $session->step;
        //echo $this->view->render($this->tplDirectory ."header.tpl");
    }
    /* PurchaserController.php 买家相关控制器
     * SupplierController.php 卖家相关控制器
     * RecordController.php    订单，提现记录，订单明细，充值记录等相关列表
     * ResourceController.php   资源控制器，比如访问图片，下载文件
     * CommonController.php     一些通用的东西  比如获取城市
     * AccountController.php    账号的相关处理器，银行账号 用户账号  用户资料相关操作等等
     * TransactionController.php  交易相关的操作 充值 提现 等事务操作
     *
     *   上面都有说明 请尽量按说明放，把action 放到对应的控制器，别分的这一块那一块。
     */
}