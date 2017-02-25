<?php /* Smarty version Smarty-3.1.13, created on 2017-01-12 14:48:18
         compiled from "D:\www\etp\trunk\application\modules\seller\views\withdraw\internal_withdraw.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8395587726b2913684-07526646%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1046b35f1fe5b052952897af5e88bbe1b53e147b' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\withdraw\\internal_withdraw.tpl',
      1 => 1484188930,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8395587726b2913684-07526646',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'languageTpl' => 0,
    'cBalance' => 0,
    'currency' => 0,
    'language' => 0,
    'hasSubAccount' => 0,
    'bankAccount' => 0,
    'item' => 0,
    'accountNoId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_587726b2b63ba9_23653010',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_587726b2b63ba9_23653010')) {function content_587726b2b63ba9_23653010($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js">
</script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<?php echo $_smarty_tpl->tpl_vars['languageTpl']->value;?>
.js">
</script>
<style type="text/css">
    <?php if ($_smarty_tpl->tpl_vars['languageTpl']->value=='en_US'){?>
        .m_colContainer .col-r .form_item .tit { width: 190px; }
    <?php }else{ ?>
        .m_colContainer .col-r .form_item .tit { width: 120px; }
    <?php }?>
</style>
<div class="top clearfix">
    <p class="dt"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
localWithdrawApply<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <div class="t_w2 border_b_line"></div>
    <p class="f15 margin_top30" style="padding-left: 60px">
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
localAccountBalance<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
&nbsp;&nbsp;<span class="f16 red_e83d2c"><?php echo $_smarty_tpl->tpl_vars['cBalance']->value;?>
&nbsp;&nbsp;<?php if (!empty($_smarty_tpl->tpl_vars['currency']->value)){?><?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?><?php echo $_smarty_tpl->tpl_vars['currency']->value['currency_name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['currency']->value['currency_name_en'];?>
<?php }?><?php }?></span>
    </p>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="cashForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="totalAmount" value="<?php echo $_smarty_tpl->tpl_vars['cBalance']->value;?>
" />
            <div class="form_item margin_top45 clearfix">
                <span class="tit">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
selectwithdrawBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <em class="blue_00a0e9">
                        &nbsp;
                    </em>
                </span>
                <span class="dl">
                    <?php if ($_smarty_tpl->tpl_vars['hasSubAccount']->value==true){?>
                        <a class="m_icon plus  addNewOne" data-toggle="modal" data-target="#dialog_bank" style="height:20px!important;vertical-align:middle"></a>
                    <?php }else{ ?>
                        <i class="m_icon plus  addNewOne" style="height:20px!important;vertical-align:middle"></i>
                        <a class="margin_left8 blue_00a0e9 f14 addNewOne" href="/portal/bank/add-bank-card"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
AddNewWithdrawal<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
                    <?php }?>
                </span>
            </div>
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <em class="blue_00a0e9">
                        *
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <span id="bank_name_text">
                    </span>
                    <input type="hidden" class="input" name="data[bank_name]" id="bank_name" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;" data-tip="" />
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <em class="blue_00a0e9">
                        *
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <span id="bank_buyer_name_text">
                    </span>
                    <input type="hidden" class="input" name="data[bank_buyer_name]" id="bank_buyer_name" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;" data-tip="" />
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <em class="blue_00a0e9">
                        *
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <span id="bank_card_text">
                    </span>
                    <input type="hidden" class="input" name="data[bank_card]" id="bank_card" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;" data-tip="" />
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cashAmount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <em class="blue_00a0e9">
                        *
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[amount]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cashAmount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;amount;match[lte, totalAmount];" data-rule-amount="[/^(([1-9]\d{0,9})|0)(\.\d{1,4})?$/, '<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
wrongFormat<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
']" data-tip="" />
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
remark<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <em class="blue_00a0e9">
                        &nbsp;
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <textarea name="data[note]" id="note" cols="30" rows="10" class="textBox"></textarea>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left">
                    &nbsp;
                </span>
                <p class="dl f_left clearfix">
                    <!--<input class="submit" type="submit" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Confirm<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submit<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" id="submitBtn" />-->
                    <button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submiting<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submit<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    </button>
                </p>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    &nbsp;
                </span>
                <div class="dl f_left clearfix">
                    <span id="noticeWrap">
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="dialog_bank" class="modal fade" role="dialog" aria-labelledby="dialog_bankLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
selectwithdrawBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                </h4>
            </div>
            <div class="modal-body bottom" style="padding-bottom:20px;">
                <div class="cardList clearfix">
                <?php if ($_smarty_tpl->tpl_vars['hasSubAccount']->value==true){?>
                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['bankAccount']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                    <div class="item">
                        <p class="t clearfix">
                            <span class="span">
                                <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCard<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                            </span>
                            <a href="javascript:" class="m_icon set2 f_right margin_left8">
                            </a>
                        </p>
                        <div class="m">
                            <p class="name" title="">
                                <?php echo $_smarty_tpl->tpl_vars['item']->value['bank_name'];?>

                            </p>
                            <p class="number" title="">
                            </p>
                        </div>
                        <p class="b">
                            <?php if ($_smarty_tpl->tpl_vars['item']->value['status']==1){?>
                                <a href="javascript:" bNo="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_card_id'];?>
" aNo="<?php echo $_smarty_tpl->tpl_vars['accountNoId']->value[$_smarty_tpl->tpl_vars['item']->value['account_no']];?>
" bank_name="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_name'];?>
" card_user_name="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_card_user_name'];?>
" bank_card_no="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_card_no'];?>
" class="link2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
activateBankCard<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                </a>
                            <?php }else{ ?>
                                <a href="javascript:" bNo="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_card_id'];?>
" aNo="<?php echo $_smarty_tpl->tpl_vars['accountNoId']->value[$_smarty_tpl->tpl_vars['item']->value['account_no']];?>
" bank_name="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_name'];?>
" card_user_name="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_card_user_name'];?>
" bank_card_no="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_card_no'];?>
" class="link2 select">
                                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
select<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                                </a>
                            <?php }?>
                        </p>
                    </div>
                <?php } ?>
                    <div class="item empty">
                        <i class="m_icon plus f_left margin_left40 margin_top50 addNewOne">
                        </i>
                        <a class="f_left margin_left8 blue_00a0e9 f14 margin_top50 addNewOne" href="/seller/bank/add-bank-card">
                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
addNewBankCard_U<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        </a>
                    </div>
                <?php }?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
close<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                </button>
                <div></div>
            </div>
        </div>
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
        $('.select').on('click',
            function() {
                var bank_name = $(this).attr('bank_name'); //银行名称
                $('#bank_name').val(bank_name);
                $('#bank_name_text').html(bank_name);
                var bankCardNo = $(this).attr('bank_card_no'); //银行卡号
                $('#bank_card').val(bankCardNo);
                $('#bank_card_text').html(bankCardNo);
                var bank_card_user_name = $(this).attr('card_user_name'); //银行持卡人名称
                $('#bank_buyer_name').val(bank_card_user_name);
                $('#bank_buyer_name_text').html(bank_card_user_name);
                var bank_card_no = '';
                $('#dialog_bank').modal('hide');
           }
        );
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
                    url: '/seller/withdraw/internal-withdraw',
                    success: function(json) {
                        if (json.state == '1') {
                            alertTip(json.message, 3);
                            $('#cashForm')[0].reset();
                        } else {
                            $('#noticeWrap').empty();
                            if (json.message != '') {
                                alertTip(json.message, 2);
                            }
                            if (typeof(json.error) != 'undefined') {
                                $.each(json.error,
                                function(key, item) {
                                    alertTip(item.errorCode + ':' + item.errorMsg, 2);
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