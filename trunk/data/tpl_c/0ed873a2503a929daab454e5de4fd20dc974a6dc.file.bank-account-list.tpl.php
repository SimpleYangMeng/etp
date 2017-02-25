<?php /* Smarty version Smarty-3.1.13, created on 2017-01-13 16:09:16
         compiled from "D:\www\etp\trunk\application\modules\seller\views\bank\bank-account-list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2791458788b2c43f389-59154894%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0ed873a2503a929daab454e5de4fd20dc974a6dc' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\bank\\bank-account-list.tpl',
      1 => 1484188930,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2791458788b2c43f389-59154894',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'hasSubAccount' => 0,
    'bankAccount' => 0,
    'item' => 0,
    'accountNoId' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58788b2c781aa2_21956322',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58788b2c781aa2_21956322')) {function content_58788b2c781aa2_21956322($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><div class="top clearfix">
    <p class="dt"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cashAccountManagement<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
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
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['status']==1){?>
                    <a href="javascript:" class="m_icon set2 f_right margin_left8" bNo="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_card_id'];?>
" aNo="<?php echo $_smarty_tpl->tpl_vars['accountNoId']->value[$_smarty_tpl->tpl_vars['item']->value['account_no']];?>
">
                    </a>
                    <?php }?>
                </p>
                <div class="m">
                    <p class="name" title="">
                        <?php echo $_smarty_tpl->tpl_vars['item']->value['bank_name'];?>

                    </p>
                    <p class="number" title="">
                        <?php echo implode((str_split((str_pad((substr($_smarty_tpl->tpl_vars['item']->value['bank_card_no'],-4)),(strlen($_smarty_tpl->tpl_vars['item']->value['bank_card_no'])),'*',@constant('STR_PAD_LEFT'))),4))," ");?>

                    </p>
                </div>
                <p class="b">
                    <?php if ($_smarty_tpl->tpl_vars['item']->value['status']==1){?>
                    <a href="javascript:" bNo="<?php echo $_smarty_tpl->tpl_vars['item']->value['bank_card_id'];?>
" aNo="<?php echo $_smarty_tpl->tpl_vars['accountNoId']->value[$_smarty_tpl->tpl_vars['item']->value['account_no']];?>
" class="link2">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
activateBankCard<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    </a>
                    <?php }else{ ?>
                    &nbsp;
                    <?php }?>

                </p>
            </div>
        <?php } ?>
        <?php if (count($_smarty_tpl->tpl_vars['bankAccount']->value)<20){?>
            <div class="item empty">
                <i class="m_icon plus f_left margin_left30 margin_top50"></i>
                <a class="f_left margin_left8 blue_00a0e9 f14 margin_top50" href="/seller/bank/add-bank-card" target="_self">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
addBankAccount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                </a>
            </div>
        <?php }?>
        <?php }else{ ?>
            <div class="form_item  clearfix" style="margin: 20px 0 0 30px;">
                <p class="f_left">
                    <a href='#' id="timeOutAgree" data-toggle="modal" data-target="#dialog_service_agreement" class="f_left blue_btn f16 blue_btn_h_32">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
applySubAccount<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    </a>
                </p>
            </div>
            <div id="dialog_service_agreement" class="modal fade" role="dialog" aria-labelledby="dialog_bankLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">
                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
serviceAgreement<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        </h4>
                    </div>
                    <div class="modal-body">
                        <?php echo $_smarty_tpl->getSubTemplate ("seller/views/bank/pingan_epay_xieyi.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="exportDataBtn" data-dismiss="modal"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Agree<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<span id="second_span" style="margin-left: 4px;">10m</span></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cancel<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</button>
                    </div>
                </div>
                </div>
            </div>
            <script type="text/javascript">
                var timeOutIn;
                var secondNum = 10;
                var runSecond = function () {
                    if( secondNum > 0 ){
                        $('#second_span').text(secondNum+'m');
                    }else {
                        window.location.href =  '/seller/bank/apply-sub-account';
                    }
                    secondNum = secondNum - 1;
                }

                $(function(){
                    $('#timeOutAgree').click(function (){
                        secondNum = 10;
                        timeOutIn = setInterval(runSecond, 60000);
                    });

                    //取消
                    $('#dialog_service_agreement').on('hide.bs.modal', function () {
                        clearInterval(timeOutIn);
                    });

                    $('#exportDataBtn').click(function (){
                        window.location.href = '/seller/bank/apply-sub-account';
                    });
                });
            </script>
        <?php }?>
    </div>
</div>
<form id="hidde-form" action="" method="post" style="display:none;">
    <input type="hidden" name="aNo" id="aNo" value="" >
    <input type="hidden" name="bNo" id="bNo" value="" >
</form>
<script type="text/javascript">
    $(function() {
        $('.addNewOne').click(function() {
            window.location = '/seller/bank/add-bank-account';
        })
        $('.link2').click(function() {
            $('#hidde-form').attr('action','/seller/bank/confirm-bank-card');
            $('#aNo').val( $(this).attr('aNo') );
            $('#bNo').val( $(this).attr('bNo') );
            document.getElementById('hidde-form').submit(); 
        });

        $('.set2').click(function() {
            $('#hidde-form').attr('action','/seller/bank/edit-bank-card');
            $('#aNo').val( $(this).attr('aNo') );
            $('#bNo').val( $(this).attr('bNo') );
            document.getElementById('hidde-form').submit(); 
        });
    })
</script><?php }} ?>