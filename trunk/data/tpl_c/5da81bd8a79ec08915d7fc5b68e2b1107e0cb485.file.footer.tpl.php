<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 11:41:57
         compiled from "D:\www\etp\trunk\application\modules\buyer\views\layout\footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:297975876fb05291825-23338457%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5da81bd8a79ec08915d7fc5b68e2b1107e0cb485' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\buyer\\views\\layout\\footer.tpl',
      1 => 1484188929,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '297975876fb05291825-23338457',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5876fb052ee757_88424026',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5876fb052ee757_88424026')) {function content_5876fb052ee757_88424026($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><div class="min_width c1">
    <p class="clearfix text_align_c">
        <a href="/help/guide?visitor_type=2" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
sellerManuals<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        <span class="span">|</span>
        <a href="/help/guide?visitor_type=1" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
buyerManuals<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        <span class="span">|</span>
        <a href="/help/coopera" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
coopBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        <span class="span">|</span>
        <a href="/help/" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
CommonProblem<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        <span class="span">|</span>
        <a href="/help/question" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
AboutUs<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
    </p>
    <p class="copy text_align_c">
        Copyright &copy; 2016-2019 Globex. All Rights Reserved. <a href="http://www.miitbeian.gov.cn">粤ICP备15005741号-8</a> Shenzhen Baohong Ecommerce Integrated Services Co, Ltd
    </p>
</div><?php }} ?>