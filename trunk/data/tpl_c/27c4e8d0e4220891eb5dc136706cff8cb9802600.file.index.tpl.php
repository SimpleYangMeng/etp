<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 11:31:34
         compiled from "D:\www\etp\trunk\application\modules\default\views\login\index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:235225876f896c90697-37056639%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27c4e8d0e4220891eb5dc136706cff8cb9802600' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\default\\views\\login\\index.tpl',
      1 => 1484188928,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '235225876f896c90697-37056639',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5876f897ba8f26_91923166',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5876f897ba8f26_91923166')) {function content_5876f897ba8f26_91923166($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
logoinType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</title>
    <link href="/etp_style_v1.0/css/base.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/sample.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/member.css" rel="stylesheet" type="text/css" />
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("default/views/default/header-menu-inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!--banner-->
<div class="in_bannerContainer">
    <!--<a class="prev duration none"></a>-->
    <!--<a class="next duration none"></a>-->
    <div class="bannerWrap">
        <div class="bannerWidth">
            <div class="btnBox clearfix">
                <a href="/login/login?visitor_type=1" class="btn btn1"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
iamBuyer<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
                <a href="/login/login?visitor_type=2" class="btn btn2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
iamSeller<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
                <a href="/register" class="btn btn3"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
regNow<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
            </div>
        </div>
    </div>
    <div class="bannerItem">
        <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/banner01.jpg') no-repeat scroll center top transparent;" target="_blank"></a>
        <?php }else{ ?>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/banner01_en.jpg') no-repeat scroll center top transparent;" target="_blank"></a>
        <?php }?>
    </div>
    <div class="bannerItem">
        <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/banner02.jpg') no-repeat scroll center top transparent;" target="_blank"></a>
        <?php }else{ ?>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/banner02_en.jpg') no-repeat scroll center top transparent;" target="_blank"></a>
        <?php }?>
    </div>
    <div class="banner_pagination none">
        <span class="btn_index current"></span>
        <span class="btn_index"></span>
    </div>
    <style type="text/css">
        .m_footerContainer { position: absolute; bottom: 0px; background: rgba(0, 0, 0, 0.6); z-index: 9999; }
    </style>
    <?php echo $_smarty_tpl->getSubTemplate ("default/views/default/footer-menu-inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<!--注意：有两种不同风格的头部和尾部，注意其标签-->
<script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="/etp_style_v1.0/js/util.js" type="text/javascript"></script>
<script src="/etp_style_v1.0/js/common.new.js" type="text/javascript"></script>
<script type="text/javascript">
    new Banner({
        bannerBox: $('.in_bannerContainer'),
        banner: $('.bannerItem'),
        indexBtn: $('.btn_index'),
        indexBtnCurrent: 'current',
        autoPlay: true,
        autoPlayTime: 4000,
        scrollSpeed: 1000
        //bgColorSwicth: true,
        //bgColorArr:bannerColors,//背景色
        //bgColorSpeed: 500
    });
</script>
</body>
</html><?php }} ?>