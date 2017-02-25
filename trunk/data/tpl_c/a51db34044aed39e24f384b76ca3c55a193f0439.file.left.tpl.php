<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 11:41:57
         compiled from "D:\www\etp\trunk\application\modules\buyer\views\layout\left.tpl" */ ?>
<?php /*%%SmartyHeaderCode:187805876fb05053816-45486690%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a51db34044aed39e24f384b76ca3c55a193f0439' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\buyer\\views\\layout\\left.tpl',
      1 => 1484188929,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '187805876fb05053816-45486690',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language' => 0,
    'account' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5876fb05117e62_59290761',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5876fb05117e62_59290761')) {function content_5876fb05117e62_59290761($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?>
<style type="text/css">
    .m_colContainer .menuList .menu-dl .p { width: 100%; }
</style>
<?php }?>
<div class="menuList">
    <p class="menu-dt clearfix">
        <i class="m_icon recharge f_left"></i>
        <span class="span f_left margin_left5"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
recharge<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/buyer/charge/recharge" class="recharge"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
rechargeApplication<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
        <p class="p">
            <a href="/buyer/charge/recharge-list" class="rechargeList"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
rechargeList<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon exchange f_left"></i>
        <span class="span f_left margin_left5"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
wantPay<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/buyer/pay-order-record/pay-order-list" class="menu_purchaser_pay_order"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
payOrder<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
        <p class="p">
            <a href="/buyer/order/list" class="menu_order_list"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
tradeOrderList<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon cash f_left"></i>
        <span class="span f_left margin_left5"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
withdraw<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/buyer/withdraw/foreign-withdraw" class="menu_cash"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
appOWithdraw<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
        <p class="p">
            <a href="/buyer/withdraw-record/withdraw-list" class="menu_cash_list"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
withdrawList<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon set3 f_left"></i>
        <span class="span f_left margin_left5"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
accountManagement<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/buyer/order/trade-detail-list" class="menu_buyer_trade_order"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
tradeOrderDetail<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
        <?php if ($_smarty_tpl->tpl_vars['account']->value['has_pay_password']==1){?>
        <p class="p">
            <a href="/buyer/account/payment-password" class="menu_setppwd"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
setPaymentPassword<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
        <?php }?>
        <?php if ($_smarty_tpl->tpl_vars['account']->value['status']!=12){?>
        <p class="p">
            <a href="/buyer/account/edit-account-info" class="menu_companyinfo"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
companyInfoMange<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
        <?php }else{ ?>
        <p class="p">
            <a href="/buyer/portal/detail" class="menu_purchaser_detail"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
purchaserDetail<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
        <?php }?>
    </div>
</div><?php }} ?>