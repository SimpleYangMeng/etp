<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 13:57:05
         compiled from "D:\www\etp\trunk\application\modules\seller\views\settlement\settlement.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2097858771ab1974eb0-94336163%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7f90ffccfdd383c81ec5b64b27ab0278aecf868d' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\settlement\\settlement.tpl',
      1 => 1484188929,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2097858771ab1974eb0-94336163',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language' => 0,
    'cBalance' => 0,
    'currency' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58771ab1a77e89_34791202',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58771ab1a77e89_34791202')) {function content_58771ab1a77e89_34791202($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
.js"></script>
<style type="text/css">
    <?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?>
    .m_colContainer .col-r .form_item .{ width: 190px; }
    <?php }else{ ?>
    .m_colContainer .col-r .form_item .{ width: 120px; }
    <?php }?>
</style>
<div class="top clearfix">
    <p class="dt"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
appSettlement<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="cashForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="totalAmount" value="<?php echo $_smarty_tpl->tpl_vars['cBalance']->value;?>
" />
            <div class="form_item clearfix">
                <span class="tit f_left <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_300_en_US<?php }?>"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
settlingValue<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<em class="blue_00a0e9">&nbsp;</em></span>
                <div class="dl f_left clearfix">
                    <span class="f16 red_e83d2c balance"><?php echo $_smarty_tpl->tpl_vars['currency']->value['currency_code'];?>
 <?php echo $_smarty_tpl->tpl_vars['cBalance']->value;?>
</span>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_300_en_US<?php }?>"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
needsettlingValue<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" id='needsettlement'  class="input288" name="data[needsettlingValue]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
amount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
needsettlingValue<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:zhengshu" data-rule-amount="[/^(([1-9]\d{0,9})|0)(\.\d{1,4})?$/, '<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
wrongFormat<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
']" data-tip=""/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_300_en_US<?php }?>"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
nowRate<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
                <div class="dl f_left clearfix">
                    <span><?php echo $_smarty_tpl->tpl_vars['currency']->value['currency_rate'];?>
 (<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
rateUSDToCNY<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
)</span>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_300_en_US<?php }?>"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
processingFee<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</span>
                <div class="dl f_left clearfix">
                    <span id="processingFee" class="tipfee"></span>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_300_en_US<?php }?>">&nbsp;</span>
                <p class="dl f_left clearfix">
                    <button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submiting<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submit<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</button>
                </p>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_300_en_US<?php }?>">&nbsp;</span>
                <p class="dl f_left clearfix">
                    <span id="noticeWrap"></span>
                </p>
            </div>

        </form>
    </div>
</div>
<script type="text/javascript">
    //重写提示信息
    function alertTip(tip, reloadinfo) {
        var reloadinfo = reloadinfo || 1;
        if (reloadinfo == 1) {
            $('#noticeWrap').empty();
        }
        if (reloadinfo == 3) {
            $('#noticeWrap').empty();
            $('<span class="success">' + tip + '</span>').appendTo($('#noticeWrap').show());
        } else {
            $('<span class="error">' + tip + '</span>').appendTo($('#noticeWrap').show());
        }
    }
    $(function() {
        $('#needsettlement').on('blur',function(){
            var jxvalue = $('#needsettlement').val();
            var sxf = jxvalue*0.007;
            $('#processingFee').html(sxf.toFixed(4));
        });



        var submit = $('.submit');
        //表单验证
        $('#cashForm').validator({
            valid: function() {
                submit.button('loading');
                submit.addClass('disabled');
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#cashForm').serialize(),
                    url: '/seller/settlement/settlement',
                    success: function(json) {
                        if (json.state == '1') {
                            $('.balance').html('$'+json.balance);
                            $('#processingFee').html('');
                            alertTip(json.message, 3);
                            $('#cashForm')[0].reset();
                        } else {
                            $('#noticeWrap').empty();
                            if(json.message != ''){
                                alertTip(json.message, 2);
                            }
                            if (typeof(json.error) != 'undefined') {
                                $.each(json.error,
                                        function(key, item) {
                                            alertTip(item.errorCode+':'+item.errorMsg, 2);
                                        });
                            }
                        }
                        submit.button('reset');
                        submit.removeClass('disabled');
                    }
                });
            }
        });
    });
</script><?php }} ?>