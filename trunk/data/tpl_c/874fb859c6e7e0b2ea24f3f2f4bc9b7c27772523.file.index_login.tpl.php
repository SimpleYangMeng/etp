<?php /* Smarty version Smarty-3.1.13, created on 2017-01-13 15:18:18
         compiled from "D:\www\etp\trunk\application\modules\default\views\login\index_login.tpl" */ ?>
<?php /*%%SmartyHeaderCode:191125876fa541b8b84-94882109%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '874fb859c6e7e0b2ea24f3f2f4bc9b7c27772523' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\default\\views\\login\\index_login.tpl',
      1 => 1484291708,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '191125876fa541b8b84-94882109',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_5876fa542ffbe2_76453832',
  'variables' => 
  array (
    'visitor_type' => 0,
    'language' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5876fa542ffbe2_76453832')) {function content_5876fa542ffbe2_76453832($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><?php if ($_smarty_tpl->tpl_vars['visitor_type']->value==1){?><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
buyer<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }else{ ?><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
seller<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }?>&nbsp;<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
login_in<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</title>
    <link href="/etp_style_v1.0/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/sample.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/member.css" rel="stylesheet" type="text/css" />
    <!-- nice-validator -->
    <script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css">
    <script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
</head>
<body>
<?php echo $_smarty_tpl->getSubTemplate ("default/views/default/header-menu-inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<!--banner-->
<div class="in_bannerContainer">
    <!--<a class="prev duration none"></a>-->
    <!--<a class="next duration none"></a>-->
    <div class="bannerWrap">
        <div class="bannerWidth">
            <div class="loginBox clearfix">
                <div class="layer"></div>
                <div class="box">
                    <form id="loginForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                        <input type="hidden" name="visitor_type" value="<?php echo $_smarty_tpl->tpl_vars['visitor_type']->value;?>
" />
                        <p class="text_align_c">
                            <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
                                <i class="logo" style="width: 225px;background: url('/etp_style_v1.0/images/m_icon.png') no-repeat -104px -5px;"></i>
                            <?php }else{ ?>
                                <i class="logo" style="width: 255px;background: url('/etp_style_v1.0/images/m_icon.png') no-repeat -104px -315px;"></i>
                            <?php }?>
                        </p>
                        <div class="inputBox clearfix margin_top25">
                            <p class="tit">
                                <i class="icon user"></i>
                            </p>
                            <input  class="input" type="text" name="username" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
userCode<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Email<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
userCode<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
/<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Email<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                        </div>
                        <div class="inputBox clearfix margin_top20">
                            <p class="tit">
                                <i class="icon pwd"></i>
                            </p>
                            <input class="input" type="password" name="password" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
userPass<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
password<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                        </div>
                        <p class="f12 margin_top15"><a href="/forget-password?visitor_type=<?php echo $_smarty_tpl->tpl_vars['visitor_type']->value;?>
" class="white_link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
forgetPassword<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a></p>
                        <!-- 错误提示信息地方 可以根据需要自行选择。默认是hidden，加error后visible。不是用的display: none,用的Visbiblity属性，隐藏后还占据高度。-->
                        <p class="tip red_e83d2c margin_top10" id="errorMsg" style="overflow: hidden;"></p>
                        <!--如果采用上述tip错误提示，那么这里的margin_top30改为margin_top15即可。-->
                        <p class="margin_top10">
                            <!--<a href="javascript:" class="submit">登 录</a>-->
                            <input  class="submit" type="submit" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
login<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" style="padding: 6px 12px;" id="submitBtn">
                        </p>
                        <p class="white_text margin_top10">
                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
NoUserRegLink<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <a href="/default/register/index/" class="blue_link"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
regNow<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="bannerItem">
        <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/<?php if ($_smarty_tpl->tpl_vars['visitor_type']->value==1){?>banner03.jpg<?php }else{ ?>banner04.jpg<?php }?>') no-repeat scroll center top transparent; background-size: cover;" target="_blank"></a>
        <?php }else{ ?>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/<?php if ($_smarty_tpl->tpl_vars['visitor_type']->value==1){?>banner05.jpg<?php }else{ ?>banner06.jpg<?php }?>') no-repeat scroll center top transparent; background-size: cover;" target="_blank"></a>
        <?php }?>
    </div>
    <style type="text/css">
        .m_footerContainer { position: absolute; bottom: 0px; background: rgba(0, 0, 0, 0.6); z-index: 9999; }
    </style>
    <?php echo $_smarty_tpl->getSubTemplate ("default/views/default/footer-menu-inner.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<!--注意：有两种不同风格的头部和尾部，注意其标签-->
<script type="text/javascript" language="javascript">
$(function(){
    $(".verifyChange").click(function(){
        $('#verifyImg').attr("src","/register/verify-code?"+Math.random());
    });
    $('#loginForm').validator({
        valid: function (){
            $.ajax({
                url:"/login/check",
                data:$('#loginForm').serialize(),
                type:'POST',
                dataType:"json",
                success:function(json){
                    if(typeof(json.authcodeError) != 'undefined' && json.authcodeError == 1){
                        $(".verifyChange").click();
                    }
                    if(json.state == "1"){
                        //console.log(json);
                        if(json.callback == '1'){
                            window.location.href =  json.callbackurl;
                        }else {
                            window.location.href = json.jumpToUrl;
                        }
                    }else if(json.state == "-1"){
                        window.location.href='/register/step?current='+ json.current +'&visitor_type='+json.visitor_type;
                    }else{
                        $('input[name=password]').val('');
                        $('input[name=verify]').val('');
                        $(".verifyChange").click();
                        $('#errorMsg').addClass('error');
                        $("#errorMsg").html('<span class="error">'+json.errorMsg+'</span>');
                    }
                }
            });
        }
    });
});
</script>
</body>
</html><?php }} ?>