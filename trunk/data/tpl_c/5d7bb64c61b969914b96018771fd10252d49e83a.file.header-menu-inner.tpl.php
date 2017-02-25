<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 11:31:36
         compiled from "D:\www\etp\trunk\application\modules\default\views\default\header-menu-inner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:111235876f8981210c3-24958487%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5d7bb64c61b969914b96018771fd10252d49e83a' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\default\\views\\default\\header-menu-inner.tpl',
      1 => 1484188927,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '111235876f8981210c3-24958487',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5876f898222ea2_89859450',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5876f898222ea2_89859450')) {function content_5876f898222ea2_89859450($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><!-- 引入语言包 -->
<script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
.js"></script>
<!-- header begin -->
<div class="in_topContainer">
    <div class="min_width clearfix">
        <p class="f_right">
            <a class="link" href="/"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
homePage<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
            <span class="span">|</span>
            <a href="/help/question" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
CommonProblem<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
            <span class="span">|</span>
            <a href="/help/about-us" class="link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
AboutUs<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
            <span class="span">|</span>
            <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
            <a href="/default/index/change-language?lang=en_US" class="link">
                English Site(英文版)
            </a>
            <?php }else{ ?>
            <a href="/default/index/change-language?lang=zh_CN" class="link">
                Chinese Site(中文版)
            </a>
            <?php }?>
        </p>
    </div>
</div>
<div class="in_headerContainer" style="background: #FFFFFF;">
    <!--
    <div class="min_width clearfix">
        <a href="/" class="logo f_left">
            <img src="/etp_style_v1.0/images/logo.png" alt="logo" width="220" height="35"/>
        </a>
        <p class="slogan f_right">
            <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
                <img src="/etp_style_v1.0/images/slogan.png" width="170" height="22"/>
            <?php }else{ ?>
                <img src="/etp_style_v1.0/images/slogan_en.png"/>
            <?php }?>
        </p>
    </div>
    -->
    <div class="min_width clearfix">
        <a href="/" class="logo f_left">
            <img src="/etp_style_v1.0/images/logo.jpg" alt="logo" width="220" height="35"/>
        </a>
        <p class="slogan f_left">
            <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
                <img src="/etp_style_v1.0/images/slogan.jpg" width="170" height="22"/>
            <?php }else{ ?>
                <img src="/etp_style_v1.0/images/slogan_en.jpg"/>
            <?php }?>
        </p>
    </div>
</div>
<!--header end --><?php }} ?>