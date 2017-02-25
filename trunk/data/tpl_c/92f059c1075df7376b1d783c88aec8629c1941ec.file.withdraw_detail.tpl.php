<?php /* Smarty version Smarty-3.1.13, created on 2017-01-13 17:13:14
         compiled from "D:\www\etp\trunk\application\modules\seller\views\withdraw_record\withdraw_detail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2208558789a2a90ae22-70649629%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92f059c1075df7376b1d783c88aec8629c1941ec' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\withdraw_record\\withdraw_detail.tpl',
      1 => 1484188929,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2208558789a2a90ae22-70649629',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'withdraw' => 0,
    'language' => 0,
    'currency' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58789a2ab2da34_32808947',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58789a2ab2da34_32808947')) {function content_58789a2ab2da34_32808947($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><a href="/seller/withdraw-record/withdraw-list"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
withdrawList<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a> &gt; <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
viewWithdraw<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <?php if (!empty($_smarty_tpl->tpl_vars['withdraw']->value)){?>
    <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
withdrawCode<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['withdraw_code'];?>
</td>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
transactionNo<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['transaction_no'];?>
</td>
            </tr>
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
withdrawType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['withdraw_type'];?>
</td>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
status<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['status'];?>
</td>
            </tr>
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['bank_name'];?>
</td>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo preg_replace("/(\S{4})(?=\S)/","**** ",$_smarty_tpl->tpl_vars['withdraw']->value['bank_card']);?>
</td>
            </tr>
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['bank_buyer_name'];?>
</td>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cashAmount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php if ($_smarty_tpl->tpl_vars['currency']->value!=false){?><?php echo $_smarty_tpl->tpl_vars['currency']->value['currency_symbol_left'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['currency'];?>
<?php }?><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['amount'];?>
</td>
            </tr>
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeTime<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['add_time'];?>
</td>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
updateTime<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['update_time'];?>
</td>
            </tr>
            <tr>
                <td class="tit_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
" style="height: 100px;"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
remark<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                <td colspan="3"><?php echo $_smarty_tpl->tpl_vars['withdraw']->value['note'];?>
</td>
            </tr>
        </table>
    </div>
    <?php }else{ ?>
    <div>
        <div id="success-div" style="margin-top:15%;text-align:center;font-size:15px">
            <p><i class="errorIcon"></i> <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
failedToGetWithdrawDetails<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    </div>
    </div>
    <?php }?>
</div><?php }} ?>