<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 14:48:20
         compiled from "D:\www\etp\trunk\application\modules\seller\views\withdraw\foreigin_withdraw.tpl" */ ?>
<?php /*%%SmartyHeaderCode:27494587726b40445e1-96905897%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b1d17d05ef1921ab443fa1f6ebc94b71c351227' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\withdraw\\foreigin_withdraw.tpl',
      1 => 1484188930,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '27494587726b40445e1-96905897',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language' => 0,
    'cBalance' => 0,
    'currency' => 0,
    'country' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_587726b41d2fe4_32697217',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_587726b41d2fe4_32697217')) {function content_587726b41d2fe4_32697217($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
.js"></script>
<style type="text/css">
    <?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?>
    .m_colContainer .col-r .form_item .tit { width: 190px; }
    <?php }else{ ?>
    .m_colContainer .col-r .form_item .tit { width: 120px; }
    <?php }?>
</style>
<div class="top clearfix">
    <p class="dt"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cashRequest<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <div class="t_w2 border_b_line"></div>
    <p class="f15 margin_top20" style="padding-left: 60px"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
overseasAmount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
：&nbsp;&nbsp;<span class="f16 red_e83d2c balance"><?php echo $_smarty_tpl->tpl_vars['cBalance']->value;?>
&nbsp;&nbsp;<?php if (!empty($_smarty_tpl->tpl_vars['currency']->value)){?><?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?><?php echo $_smarty_tpl->tpl_vars['currency']->value['currency_name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['currency']->value['currency_name_en'];?>
<?php }?><?php }?></span></p>
    <p class="margin_top5 gray_919191" style="padding-left: 60px"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
foreignWithdrawTip1<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <p class="margin_top5 gray_919191" style="padding-left: 60px"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
foreignWithdrawTip2<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <p class="margin_top5 gray_919191" style="padding-left: 60px"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
foreignWithdrawTip3<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="cashForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="totalAmount" value="<?php echo $_smarty_tpl->tpl_vars['cBalance']->value;?>
" />
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[bank_name]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;" data-tip=""/>
                </div>
                <!--
                <p class="tip f_left error">
                    错误提示
                </p>
                -->
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankLocation<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <!--<input type="text" class="input" name="bank_buyer_name" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;" data-tip=""/>-->
                    <select name="data[country_id]" id="" class="selBox" style="min-width: 80px;max-width: 245px;" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankLocation<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;">
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['country']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['country_id'];?>
" <?php if ($_smarty_tpl->tpl_vars['item']->value['country_code']=='US'){?>selected="selected"<?php }?>><?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?><?php echo $_smarty_tpl->tpl_vars['item']->value['country_name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['item']->value['country_name_en'];?>
<?php }?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[bank_buyer_name]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;" data-tip=""/>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[bank_card]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;" data-tip=""/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cashAmount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[amount]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cashAmount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;amount;match[lte, totalAmount];" data-rule-amount="[/^(([1-9]\d{0,9})|0)(\.\d{1,4})?$/, '<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
wrongFormat<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
']" data-tip=""/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
remark<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <textarea name="data[note]" id="note" cols="30" rows="10" class="textBox"></textarea>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left">&nbsp;</span>
                <p class="dl f_left clearfix">
                    <!--<input  class="submit" type="submit" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Confirm<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submit<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" id="submitBtn" />-->
                    <button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submiting<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Confirm<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submit<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</button>
                </p>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    &nbsp;
                </span>
                <div class="dl">
                    <div id="noticeWrap"></div>
                </div>
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
                    url: '/seller/withdraw/foreign-withdraw',
                    success: function(json) {
                        if (json.state == '1') {
                            $('.balance').html(json.balance);
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