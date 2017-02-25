<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 13:57:02
         compiled from "D:\www\etp\trunk\application\modules\seller\views\layout\top.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1776658771aae4dc051-14096400%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '673c5fa3c1d7d74551dec9213285f3e008749c29' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\layout\\top.tpl',
      1 => 1484188930,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1776658771aae4dc051-14096400',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'languageList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58771aae4f3920_47920865',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58771aae4f3920_47920865')) {function content_58771aae4f3920_47920865($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><div class="min_width clearfix">
    <p class="f_right">
        <a href="/help/question" class="link">
            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
questionAnswer<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

        </a>
        <span class="span">
            |
        </span>
        <a href="/help/about-us" class="link">
            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
aboutUs<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

        </a>
        <span class="span">
            |
        </span>
        <a href="/default/index/change-language?lang=<?php echo $_smarty_tpl->tpl_vars['languageList']->value;?>
" class="link">
            <?php if ($_smarty_tpl->tpl_vars['languageList']->value=='zh_CN'){?>Chinese Site(中文版)<?php }else{ ?>English Site(英文版)<?php }?>
        </a>
    </p>
</div><?php }} ?>