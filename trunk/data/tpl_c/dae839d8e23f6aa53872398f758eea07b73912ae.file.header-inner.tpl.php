<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 13:57:02
         compiled from "D:\www\etp\trunk\application\modules\seller\views\layout\header-inner.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2064758771aae5abdd0-52636236%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dae839d8e23f6aa53872398f758eea07b73912ae' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\layout\\header-inner.tpl',
      1 => 1484188930,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2064758771aae5abdd0-52636236',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'accountName' => 0,
    'lastLoginTime' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58771aae5f4206_89867924',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58771aae5f4206_89867924')) {function content_58771aae5f4206_89867924($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><div class="min_width cl">
    <div class="logo_wrap f_left">
        <a href="/" class="logo f_left">
            <img src="/etp_style_v1.0/images/logo.png" alt="logo" width="220" height="35" />
        </a>
    </div>
    <div class="slogan f_right f14 cl">
        <p class="f_left">
            <?php echo $_smarty_tpl->tpl_vars['accountName']->value;?>

            <span>
                <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
welcome<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            </span>
        </p>
        <p class="f_left cl f12">
            <a href="javascript:" class="cl f_left">
                <i class="m_icon email2 f_left margin_left5 margin_top28"></i>
                <span class="f_left margin_left5">
                    ( 5 )
                </span>
            </a>
            <a href="/seller/account/modify-login-pwd" class="f_left margin_left10">
                <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
ChangePassword<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            </a>
            <a href="/login/out" class="f_left margin_left10">
                <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
logout<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            </a>
        </p>
        <p class="f_right f12">
            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
lastLoginTime<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php echo $_smarty_tpl->tpl_vars['lastLoginTime']->value;?>

        </p>
    </div>
</div><?php }} ?>