<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 17:14:33
         compiled from "D:\www\etp\trunk\application\modules\seller\views\settlement\settlement_detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2169258771aef8e4410-19621920%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7ae4a56d90b296d1fce2673684a52a36ec8c19f8' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\settlement\\settlement_detail.tpl',
      1 => 1484211905,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2169258771aef8e4410-19621920',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58771aef9ad052_37562919',
  'variables' => 
  array (
    'return' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58771aef9ad052_37562919')) {function content_58771aef9ad052_37562919($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"> <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
settlementView<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
        <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <?php if ($_smarty_tpl->tpl_vars['return']->value['state']==1){?>
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
settlementCode<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['return']->value['data']['settlement_code'];?>
</td>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
needsettlingValue<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['return']->value['data']['settling_value'];?>
 <?php echo $_smarty_tpl->tpl_vars['return']->value['data']['settling_currency'];?>
</td>
            </tr>
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
processingFee<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['return']->value['data']['handling_fee'];?>
 RMB</td>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
nowRate<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['return']->value['data']['exchange_rate'];?>
</td>
            </tr>
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
" style="height: 100px;"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
remark<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['return']->value['data']['note'];?>
</td>
            </tr>
            <?php }else{ ?>
            <tr>
                <td colspan="4"><?php echo $_smarty_tpl->tpl_vars['return']->value['message'];?>
</td>
            </tr>
            <?php }?>
        </table>
    </div>
</div>
<?php }} ?>