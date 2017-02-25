<?php /* Smarty version Smarty-3.1.13, created on 2017-01-16 14:03:58
         compiled from "D:\www\etp\trunk\application\modules\seller\views\order\trade_detail_list.tpl" */ ?>
<?php /*%%SmartyHeaderCode:32156587c624eeee664-17054609%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca655e8710397088cdd015dfaa0b708eeef0f7d9' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\seller\\views\\order\\trade_detail_list.tpl',
      1 => 1484188930,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '32156587c624eeee664-17054609',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'language' => 0,
    'changeType' => 0,
    'key' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_587c624f1be098_09997676',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_587c624f1be098_09997676')) {function content_587c624f1be098_09997676($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><style type="text/css">
.m_colContainer .col-r .form_item .tit { width: auto; }
<?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?>
.m_colContainer .col-r .bottom .tabBtnGroup .tabBtn { padding: 0 20px 0 20px; }
<?php }?>
</style>
<div class="top clearfix">
    <p class="dt"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
tradeOrderDetail<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
    <div class="t_w2 border_b_line"></div>
    <div class="form_group clearfix">
        <form id="searchForm" method="post" action="" onsubmit="return false">
            <input type="hidden" value="" name="condition[status]" id="status" />
            <table>
                <tr class="height50">
                    <td class="td_l_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>width130<?php }else{ ?>width130<?php }?>"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
refNo<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                    <td class="width240 td_r_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><input type="text" name="condition[reference_code]" class="input width200"/></td>
                    <td class="td_l_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
 <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>width130<?php }else{ ?>width130<?php }?>"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
tradeType<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                    <td class="width240 td_r_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
">
                        <select name="condition[change_type]" id="" class="selBox" style="min-width: 80px;max-width: 245px;">
                            <option value=""><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
all<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</option>
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['changeType']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['key']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value;?>
</option>
                            <?php } ?>
                        </select>
                    </td>
                </tr>
                <tr class="height50">
                    <td class="td_l_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeTime<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
colon<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</td>
                    <td colspan=2 class="td_r_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
">
                        <input type="text" name="condition[add_time_start]" class="input width150 f_left" value="" id="add_time_start"/>
                        <em class="line5 f_left"></em>
                        <input type="text" name="condition[add_time_end]" class="input width150 f_left" value="" id="add_time_end"/>
                    </td>
                    <td class="td_r_<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
">
                        <input class="submit height35" type="submit" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
search<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" id="searchSubmit" />
                        <input class="submit height35" type="button" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
exportData<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" id="exportBtn" data-toggle="modal" data-target="#dialog_export"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="bottom">
    <div class="tabCon">
        <div class="tabPanel all">
            <div class="table">
                <form name="exportForm" id="exportForm">
                    <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                                <th class="table-checkbox" style="width:40px"><input class="checkAll" type="checkbox" /></th>
                                <th width="100"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
refNo<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
                                <th width="100"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
type<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
                                <th width="120"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeTime<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
                                <th width="100"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
AvaBalance<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
                                <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
                                <th width="100"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
settlingValue<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
                                <th width="100"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
settlingHoldValue<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
                                <?php }?>
                                <th width="100"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
localAccountBalance<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
                                <th width="100"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
foreignValue<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</th>
                            </tr>
                        </thead>
                        <tbody id="grid_body"></tbody>
                    </table>
                    <div class="pageInfo">
                        <ul class="pagination" id="pagination"></ul>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<div id="dialog_export" class="modal fade" role="dialog" aria-labelledby="dialog_bankLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">
                <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
exportData<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            </h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="exportPostData" id="exportPostData" value="" />
            <label><input type="radio" name="exportType" value="1" checked="checked"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
selectRow<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
            <label class="margin_left15"><input type="radio" name="exportType" value="0"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
all<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</label>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="exportDataBtn" data-dismiss="modal"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
exportData<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cancel<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</button>
        </div>
    </div>
    </div>
</div>

<!-- 未选择提示 begin -->
<input class="submit margin_left10" type="button" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
notice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" id="noticeBtn" data-toggle="modal" data-target="#oneNotice" style="display: none;"/>
<div id="oneNotice" class="modal fade" role="dialog" aria-labelledby="dialog_bankLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">
                <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
notice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            </h4>
        </div>
        <div class="modal-body">
            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
pleaseSelectedOne<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cancel<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</button>
        </div>
    </div>
    </div>
</div>
<!-- 未选择提示 end -->

<script type="text/javascript">
    ETP.url = '/seller/order/trade-detail-';
    ETP.getListData = function (json) {
        var changeType = json.changeType;
        var html = '';
        $.each(json.data, function (key, val) {
            var rowchangeType = changeType[val.E27] == undefined ? '<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
nodefined<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
' : changeType[val.E27];
            html += "<tr>";
            html += '<td><input class="cblidArr" name="cblidArr[]" type="checkbox" value="'+val.E0 +'"/></td>'
            html += "<td>" + val.E1 + "</td>";
            html += "<td>" + rowchangeType + "</td>";
            html += "<td>" + val.E28 + "</td>";
            html += "<td><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeBefore<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:" +val.E3 +'<br /><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeAfter<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:'+ val.E4 + "</td>";
            <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>
            html += "<td><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeBefore<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:" +val.E6 +'<br /><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeAfter<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:'+ val.E7 + "</td>";
            html += "<td><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeBefore<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:" +val.E10 +'<br /><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeAfter<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:'+ val.E11 + "</td>";
            <?php }?>
            html += "<td><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeBefore<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:" +val.E20 +'<br /><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeAfter<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:'+ val.E21 + "</td>";
            html += "<td><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeBefore<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:" +val.E13 +'<br /><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
changeAfter<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:'+ val.E14 + "</td>";
            html += "</tr>";
        });
        return html;
    }
    $(function (){
        //时间控件
        $('#add_time_start').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>language: 'zh-CN',<?php }?>
        });
        $('#add_time_end').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>language: 'zh-CN',<?php }?>
        });
        //全选
        $(".checkAll").click(function () {
            $(this).EzCheckAll($(".cblidArr"));
        });
        //数据导出
        $('#exportDataBtn').click(function (){
            var exportType = $('[name=exportType]:checked').val();
            var postData = '';
            if(exportType=='1'){
                //console.log($('.cblidArr:checked'));
                var checkedSizesize = $('.cblidArr:checked').size();
                if(checkedSizesize<=0){
                    $('#noticeBtn').click();
                    return;
                }
                /*
                var cblidValueArr = [];
                $('.cblidArr:checked').each(function (){
                    cblidValueArr.push($(this).val());
                });
                postData = {'exportTypeValue': exportType, 'cblidArr': cblidValueArr};
                */
                $('#exportForm').attr('action', '/seller/order/trade-detail-export/exportType/'+exportType);
                $('#exportForm').attr('method', 'POST');
                $('#exportForm').submit();
                $('#exportForm').removeAttr('action');
                $('#exportForm').removeAttr('method');
            }else if(exportType=='0'){
                /*
                $('#exportTypeValue').val(exportType);
                postData = ETP.searchObj.serializeArray();
                $('#exportPostData').val(postData);
                */
                $('#exportForm').attr('action', '/seller/order/trade-detail-export/exportType'+exportType);
                $('#exportForm').attr('method', 'POST');
                $('#exportForm').submit();
            }
            /*
            $.ajax({
                type: "POST",
                async: false,
                dataType: "jsonp",
                url: '/buyer/order/trade-detail-export',
                data: postData,
                beforeSend: function (request){
                    request.setRequestHeader("Pragma", "public");
                    request.setRequestHeader("Content-Type", "application/x-msexecl;name=aa.xls");
                    request.setRequestHeader("Content-Disposition", "inline;filename=aa.xls");
                },
                error: function () {},
                success: function (json) {
                    window.open(json);
                }
            });
            */
        });
    });
</script><?php }} ?>