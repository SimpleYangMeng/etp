<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 11:31:36
         compiled from "D:\www\etp\trunk\application\modules\default\views\default\footer-menu-inner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:148965876f8983186d7-10456755%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '285de840ce68f4bd764acb9d5f6b431df9c99a7c' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\default\\views\\default\\footer-menu-inner.tpl',
      1 => 1484188928,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '148965876f8983186d7-10456755',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5876f8983473e5_97029388',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5876f8983473e5_97029388')) {function content_5876f8983473e5_97029388($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><!--footer begin -->
<div class="m_footerContainer">
    <div class="min_width">
        <p class="clearfix text_align_c">
            <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
            <a href="/help/guide?visitor_type=2" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
sellerManuals<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
            <span class="span">|</span>
            <a href="/help/guide?visitor_type=1" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
buyerManuals<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
            <span class="span">|</span>
            <?php }?>
            <a href="/help/cooperative-bank" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
coopBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
            <span class="span">|</span>
            <a href="/help/question" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
CommonProblem<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
            <span class="span">|</span>
            <a href="/help/about-us" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
AboutUs<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
        </p>
        <p class="copy text_align_c">
            <?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?>
                Copyright &copy; 2016-2019 Globex. All Rights Reserved. <a href="http://www.miitbeian.gov.cn">粤ICP备15005741号-8</a> Shenzhen Baohong Ecommerce Integrated Services Co, Ltd
            <?php }else{ ?>
                Copyright &copy; 2016-2019 Globex. All Rights Reserved. <a href="http://www.miitbeian.gov.cn">粤ICP备15005741号-8</a> Shenzhen Baohong Ecommerce Integrated Services Co, Ltd
            <?php }?>
        </p>
    </div>
</div>
<!--footer end --><?php }} ?>