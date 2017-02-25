<?php
/* @desc；采购商控制器
 * @date:2016-10-27
 */
class Portal_PurchaserWithdrawController extends Ec_Controller_Action
{
    public function preDispatch()
    {
        $this->layoutObj = Zend_Registry::get('layout');

        $this->tplDirectory     = "portal/views/purchaser_withdraw/";
        $this->_layoutFile      = 'purchaser-left-widget';
        $this->_topTpl          = 'portal/views/default/top.tpl';
        $this->_innerHeaderTpl  = 'portal/views/default/header-inner.tpl';
        $this->_leftTpl         = 'portal/views/default/left_buyer.tpl';
        $this->_footerTpl       = 'portal/views/default/footer.tpl';
    }


}