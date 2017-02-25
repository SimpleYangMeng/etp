<?php /* Smarty version Smarty-3.1.13, created on 2017-01-13 16:10:43
         compiled from "D:\www\etp\trunk\application\modules\seller\views\bank\add-bank-account.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1061958788b316becc5-25558420%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c7eb8ec100f81e6965b2745e26007a0e7aaf8ae' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\bank\\add-bank-account.tpl',
      1 => 1484295042,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1061958788b316becc5-25558420',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_58788b31a0dd70_92063721',
  'variables' => 
  array (
    'language' => 0,
    'idCardType' => 0,
    'item' => 0,
    'provinces' => 0,
    'supperBank' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_58788b31a0dd70_92063721')) {function content_58788b31a0dd70_92063721($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><div id="bindding-data">
    <p class="title">
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
addNewBankCard_U<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    </p>
    <form id="completeForm" class="fm-layout" method="post" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
        <div class="form_group">
            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="radio" name="bankType" value="1" checked="checked" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:checked" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseChooseBankType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pingAnBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="bankType" value="2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
otherBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
IdCardType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <select name="idCardType" id="idCardType" class="selBox"  data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
IdCardType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseChooseIdCardType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
">
                        <option value=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseSelected<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</option>
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['idCardType']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                        <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['id_card_no'];?>
"><?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?><?php echo $_smarty_tpl->tpl_vars['item']->value['id_card_name'];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['item']->value['id_card_name_en'];?>
<?php }?></option>
                        <?php } ?>
                    </select>
                </div>
                </p>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
IdCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="idNo" id="idNo" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
IdCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
IdCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseInputIdCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cardOwner<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="cardOwner" id="cardOwner" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cardOwner<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cardOwner<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseInputCardOwner<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="bankAccountNo" id="bankAccountNo" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required,bankAccount" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseInputBankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                </div>
            </div>
            <!-- -->
            <div class="other-bank-div" style="display:none;">
                <div class="form_item margin_top25 clearfix">
                    <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
BankAttribute<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <input type="radio" name="bankAttr" class="bankAttr" value="1" checked="checked"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
branchBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="bankAttr" class="bankAttr" value="2"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
superBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <br/>
                    </div>
                    <div class="dl2" style="<?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>width:500px;margin-left:100px;<?php }else{ ?>width:350px;margin-left:30px;<?php }?>font-size:13px;">
                        <p id="bank-note-1" class="blue_0054ed"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankNote1<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
                        <p id="bank-note-2" class="blue_0054ed" style="display:none"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankNote2<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
                    </div>
                </div>
                <!-- -->
                <div class="form_item margin_top10 clearfix bank-div">
                    <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
bankLocation<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <div style="display:inline-block;">
                        <select name="province" id="province" class="selBox2">
                            <option value=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseSelected<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</option>
                        <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['provinces']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                            <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['code'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
                        <?php } ?>
                        </select>
                        <select name="city" id="city" class="selBox2">、
                            <option value=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseSelected<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</option>
                        </select>
                        <select name="district" id="district" class="selBox2">
                            <option value=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseSelected<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</option>
                        </select>
                        </div>
                        <div style="display:inline-block;vertical-align:middle" class="searchDiv<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> width300<?php }?>">
                            <input class="searchInput keywords"<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> style="width: 270px;" <?php }?>placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
inputKeywordToSearchBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" type="text" name="keyword" id="keyword">
                            <i class="blueSearchBtn"></i>
                        </div>
                    </div>
                </div>
                <!-- -->

                <!-- -->
                <div class="form_item margin_top10 clearfix bank-div">
                    <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
branchBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <select name="bankNo" id="bankNo" class="selBox">
                            <option value=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseSelected<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</option>
                        </select>
                    </div>
                </div>

                <!-- -->
                <div class="form_item margin_top25 clearfix sBank-div" style="display:none">
                    <div class="clearfix">
                        <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
superBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                            <span class="blue_00a0e9">
                                *
                            </span>
                        </p>
                        <div class="dl2">
                            <select name="sBankNo" id="sBankNo" class="selBox"">
                                <option value=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseSelected<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</option>
                                <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['supperBank']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['No'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                    <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
phoneNumLeftForBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="mobilePhone" id="mobilePhone" placeholder="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
inputPhoneNumLeftForBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
phoneNumLeftForBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required,phoneCN" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
inputPhoneNumLeftForBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                </div>
            </div>

            <!-- 提交按钮-->
            <div class="form_item margin_top50 clearfix">
                <p class="tit<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?> tit_w300<?php }?>">
                    &nbsp;
                </p>
                <div class="dl2" class="submitBtn">
                    <a href="javascript:" class="blue_btn submitBtn">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submit<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="success-div" style="display:none;margin-top:15%;text-align:center;font-size:15px">
    <i class="sucIcon"></i> <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
addBankCardTip1<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    <p class="margin_top25">
        <a href="javascript:" class="blue_btn blue_btn_h_32 cb"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
addBankCardTip2<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</a>
    </p>
    <p class="margin_top20"><a href="/seller/bank/card" class="blue_link f14">
    <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
    系统将在 <span id="to">5</span>s 后自动跳转至提现账户管理界面
    <?php }else{ ?>
    The system will automatically jump to the <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cashAccountManagement<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 after <span id="to">5s</span>
    <?php }?>
    </a></p>
</div>
<div id="error-div" style="display:none;margin-top:5px;" class="form_item margin_top25 clearfix" >
    <p class="tit">
        &nbsp;
    </p>
    <div class="dl2">
    </div>
</div>
<form id="confirm-bank" action="/seller/account/confirm-bank-card" method="post" style="display:none;">
    <input type="hidden" name="aNo" id="aNo" value="" >
    <input type="hidden" name="bNo" id="bNo" value="" >
</form>
<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
.js"></script>

<script type="text/javascript">
    $(function() {
        $('.submitBtn').click(function() {
            $('#completeForm').submit();
        });
        $('#completeForm').validator({
            rules: {
                phoneCN:[/^1[34578]\d{9}$/, '<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
wrongPhoneNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
'],
                idCard:[/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/,'<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
wrongIdNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
'],
                bankAccount:[/^(\d{0,4}\s*)+$/,'<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
wrongBankCardNum<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
']
            },
            valid: function() {
                $('.submitBtn').showLoading({addClass:'loading-indicator-circle-1'});
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#completeForm').serialize(),
                    url: '/seller/bank/add-new-one',
                    success: function(json) {
                        if( json.state == 1) {
                            $('#bindding-data').hide();
                            document.getElementById('completeForm').reset();
                            $('#aNo').val(json.aNo);
                            $('#bNo').val(json.bNo);
                            $('#success-div').show();
                            timedCount();
                            $('#error-div > .dl2').html('');
                            $('#error-div').hide();
                        } else {
                            var html = '';
                            if( json.message )
                                html += '<p class="red_text"><i class="errorIcon"></i> '+ json.message +'</p>';
                            if( json.error.length > 0 ) {
                                $.each(json.error,function(k,v) {
                                    html += '<p class="red_text"><i class="errorIcon"></i> '+ v.errorMsg +'</p>';
                                });
                            }
                            $('#error-div > .dl2').html(html);
                            $('#error-div').show();
                        }
                    }
                });
                $('.submitBtn').hideLoading();
            }
        });
        $('#bankAccountNo').keyup(function() {
            var s = $.trim($(this).val());
            $(this).val(s.replace(/(\S{4})(?=\S)/g,"$1"+" "));
        });
        $('#idCardType').change(function(){
            if( $(this).val() == '1') {
                $('#idNo').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
IdCard<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required,idCard"});
            } else {
                $('#idNo').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
paper<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required"});
            }
        })
        $('#province').change(function() {
            getCity();
        })
        $('#city').change(function() {
            getDistrict();
        })
        $('#district').change(function() {
            getBank();
        })
        $('#keyword').keyup(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);  
            console.log(keycode);
            if(keycode == '13'){  
                getBank();
            }  
        })
        $('.blueSearchBtn').click(function(){
            getBank();
        });
        $('.cb').click(function() {
            document.getElementById('confirm-bank').submit(); 
        });
        $('[name=bankType]').click(function(){
            if( $(this).val() == 1 ) {
                $('.other-bank-div').fadeOut();
                $('.bankAttr[value=1]').prop('checked',true);
                $('.other-bank-div .selBox').val('')
                $('.other-bank-div .selBox2').val('')
                //$('#province').removeAttr('data-rule').val('');
                //$('#city').removeAttr('data-rule').children('option:gt(0)').remove();
                //$('#district').removeAttr('data-rule').children('option:gt(0)').remove();
                $('#bankNo').removeAttr('data-rule').removeAttr('data-tip').children('option:gt(0)').remove();
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');
            } else {
                $('.other-bank-div').fadeIn();
                //$('#province').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
province<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required"});
                $('#bankNo').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
branchBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required","data-tip":'<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseChooseBranchBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
'});
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');
                $('#bank-note-2').hide();
                $('#bank-note-1').show();
            }
        });
        $('[name=bankAttr]').click(function() {
            if( $(this).val() == 1 ) {
                $('#bank-note-2').hide();
                $('#bank-note-1').show();
                $('.sBank-div').hide();
                $('.bank-div').show();
                $('#sBankNo').val('')
                $('.other-bank-div .selBox2').val('');
                //$('#province').removeAttr('data-rule').val('');
                //$('#city').removeAttr('data-rule').children('option:gt(0)').remove();
                //$('#district').removeAttr('data-rule').children('option:gt(0)').remove();
                $('#bankNo').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
branchBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required","data-tip":'<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseChooseBranchBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
'});
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');

            } else {
                $('#bank-note-1').hide();
                $('#bank-note-2').show();
                $('.bank-div').hide();
                $('.sBank-div').show();
                //$('#province').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
province<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required"});
                $('#bankNo').removeAttr('data-rule').removeAttr('data-tip').children('option:gt(0)').remove();
                $('#sBankNo').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
super<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required","data-tip":'<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseChooseSuperBank<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
'});
            }
                
        })
    })
    function getCity() {
        if( $('#province').val() == '' ) {
            $('#city').children('option:gt(0)').remove();
            $('#district').children('option:gt(0)').remove();
            return;
        }
        //$('#city').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
city<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required"}).children('option:gt(0)').remove();
        $.ajax({
            type:'post',
            async:true,
            dataType:'json',
            url:'/common/area/get-city',
            data:{province:$('#province').val()},
            success:function( json ) {
               if( json.length > 0 ) {
                    var html = '';
                    $.each(json,function(k,v) {
                        html += '<option value="'+v.code+'">'+v.name+'</option>';
                    });
               }
               if(html)
                $('#city').append(html);
               getDistrict();
            }
        })
    }
    function getDistrict() {
        if( $('#city').val() === '' ) {
            $('#district').children('option:gt(0)').remove();
            return;
        }
        //$('#district').attr({"data-rule":"<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
town<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required"}).children('option:gt(0)').remove();
        $.ajax({
            type:'post',
            async:true,
            dataType:'json',
            url:'/common/area/get-district',
            data:{city:$('#city').val()},
            success:function( json ) {
                var html = '';
               if( json.length > 0 ) {
                    $.each(json,function(k,v) {
                        html += '<option value="'+v.name+'">'+v.name+'</option>';
                    });
               }
               if(html)
                    $('#district').append(html);

               getBank();
            }
        })
    }
    function getBank() {
        $('#bankNo').children('option:gt(0)').remove();
        $.ajax({
            type:'post',
            async:true,
            dataType:'json',
            url:'/seller/bank/get-bank',
            data:{
                province:$('#province').val(),
                city:$('#city').val(),
                district:$('#district').val(),
                keyword:$('#keyword').val()
            },
            success:function( json ) {
                var html = '';
                if(json.length > 0 ){
                    $.each(json,function(k,v){
                        html += '<option value="'+ v.No +'">'+ v.Name +'</option>';
                    })
                }
                $('#bankNo').append(html);
            }
        })
    }
    function timedCount() {
        var c=parseInt($('#to').html())-1;
        $('#to').html(c);
        if(c == 0) {
            window.location = '/seller/bank/card';
            return;
        }
        setTimeout("timedCount()",1000)
    } 
</script><?php }} ?>