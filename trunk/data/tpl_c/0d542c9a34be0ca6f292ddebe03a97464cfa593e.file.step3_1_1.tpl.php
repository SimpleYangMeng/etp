<?php /* Smarty version Smarty-3.1.13, created on 2017-01-18 16:13:15
         compiled from "D:\www\etp\trunk\application\modules\default\views\register\step3_1_1.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21998587f22abddfef9-17229511%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0d542c9a34be0ca6f292ddebe03a97464cfa593e' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\default\\views\\register\\step3_1_1.tpl',
      1 => 1484727194,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21998587f22abddfef9-17229511',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_587f22ac062168_98329454',
  'variables' => 
  array (
    'visitorText' => 0,
    'visitor_type' => 0,
    'visitor' => 0,
    'currencys' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_587f22ac062168_98329454')) {function content_587f22ac062168_98329454($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?>
<!-- diyUpload -->
<link rel="stylesheet" type="text/css" href="/etp_style_v1.0/js/diyUpload/css/webuploader.css">
<link rel="stylesheet" type="text/css" href="/etp_style_v1.0/js/diyUpload/css/diyUpload.css">
<script type="text/javascript" src="/etp_style_v1.0/js/diyUpload/js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/diyUpload/js/diyUpload.js"></script>

<div class="m_mainContainer">
    <div class="min_width">
        <p class="title"><?php echo $_smarty_tpl->tpl_vars['visitorText']->value;?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
completeData<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
        <div class="form_group">
            <form id="completeForm" action='' onsubmit='return false' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                <input type="hidden" name="visitor_type" value="<?php echo $_smarty_tpl->tpl_vars['visitor_type']->value;?>
" />
                <!--
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Email<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
VerifyCode<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="email_verify" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Email<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
VerifyCode<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
emailCodeInfo<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                    </div>
                </div>
                -->
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
companyName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[company_name]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
companyName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required,length[6~120]" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
companyNameNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
address<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[register_address]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
address<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
addressNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[contact_name]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactNameNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactPhone<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[contact_telphone]" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactPhone<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactPhoneNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactEmail<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[email]" value="<?php echo $_smarty_tpl->tpl_vars['visitor']->value['email'];?>
" readonly="true" data-rule="required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactEmailNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
currency<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <select name="complereData[currency]" id="currency" class="selBox" data-rule="required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
currencyNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
">
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currencys']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['currency_code'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['currency_code'];?>
 <?php echo $_smarty_tpl->tpl_vars['item']->value["currency_name"];?>
</option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
businessLicense<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9"></span></p>
                    <div class="dl" style="width: 380px;">
                        <div class="uploadBox">
                            <!--<input type="button" id="file_upload_1" name="file"  data-rule="required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
businessLicenseNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>-->
                            <div id="businessLicense" class="clear"></div>
                        </div>
                    </div>
                    <p class="tip"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
imageNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
directorIdCard<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
 <span class="blue_00a0e9"></span></p>
                    <div class="dl clearfix" style="width: 380px;">
                        <div class="uploadBox f_left">
                            <div id="cardFront" class="clear"></div>
                        </div>
                        <div class="uploadBox f_left margin_left8">
                            <!--
                            <div class="box">
                                <a href="javascript:" class="addBtn">+点击上传</a>
                            </div>
                            <p class="info">背面</p>
                            -->
                            <div id="cardBack" class="clear"></div>
                        </div>
                    </div>
                    <p class="tip" style="width: 300px;"><?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cardNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
</p>
                </div>
                <!-- 保存图片 -->
                <span id="img" style="display:none;"></span>
                <!-- 提交按钮-->
                <div class="form_item margin_top50 clearfix">
                    <p class="tit">&nbsp;</p>
                    <div class="dl">
                        <input type="submit" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
submit<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" style="padding: 2px 12px;" id="registersub" />
                    </div>
                </div>
                <div id="noticeWrap"></div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
//重写提示信息
function alertTip(tip, reloadinfo) {
   var reloadinfo =  reloadinfo||1;
    if( reloadinfo == 1 ){$('#noticeWrap').empty();}
    if( reloadinfo == 3 ){
        $('#noticeWrap').empty();
        $('<span class="success">'+tip+'</span>').appendTo($('#noticeWrap').show());
    }else {
        $('<span class="error">'+tip+'</span>').appendTo($('#noticeWrap').show());
    }
}
$(function(){
    //表单验证
    $('#completeForm').validator({
        //远程验证邮箱
        fields: {
            'email': "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Email<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;email;remote[/register/check-email-exists, visitor_type]"
        },
        valid: function (){
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: $('#completeForm').serialize(),
                url: '/register/complete',
                success: function(json) {
                    $('#noticeWrap').empty();
                    var html = '';
                    if(json.state=='1'){
                        alertTip(json.message, 3);
                        var gotoURL ='window.location.href="/register/step?current=4&visitor_type='+json.visitor_type+'"';
                        var t = setTimeout(gotoURL,2000);
                    }else if(json.state == '-1'){
                        alertTip(json.message, 2);
                        setTimeout('window.location.href="/login"', 2000);
                    }else {
                        html += json.message;
                        alertTip(html, 2);
                        if(typeof(json.error) != 'undefined'){
                            $.each(json.error, function(key, item){
                                alertTip(item.errorCode+':'+item.errorMsg, 2);
                            });
                        }
                    }
                }
            });
        }
    });
    
    //文件上传
    $('#businessLicense').diyUpload({
        url:'/register/uplodeimg',
        success:function( data ) {
            result = $("#img").html()+'<input type="hidden" name="businessLicense[imgFilePath]" value='+data.imgFilePath+' /><input type="hidden" name="businessLicense[type]" value='+data.type+' /><input type="hidden" name="businessLicense[atname]" value='+data.atname+' /><input type="hidden" name="businessLicense[imgUrl]" value='+data.imgUrl+' />';
            $("#img").html(result);
            result = '';
        },
        error:function( err ) {
            console.info( err );  
        },
        //文件上传方式
        method:"POST",
        chunked:true,
        // 分片大小
        chunkSize:512 * 1024,
        //最大上传的文件数量
        fileNumLimit:1,
        //单个文件大小(单位字节)
        fileSingleSizeLimit: 300 * 1024,
        //总文件大小
        fileSizeLimit:300 * 1024,
        buttonText: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
businessLicense<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
    });

    $('#cardFront').diyUpload({
        url:'/register/uplodeimg',
        success:function( data ) {
            result = $("#img").html()+'<input type="hidden" name="cardFront[imgFilePath]" value='+data.imgFilePath+' /><input type="hidden" name="cardFront[type]" value='+data.type+' /><input type="hidden" name="cardFront[atname]" value='+data.atname+' /><input type="hidden" name="cardFront[imgUrl]" value='+data.imgUrl+' />';
            $("#img").html(result);
            result = '';
        },
        error:function( err ) {
            console.info( err );
        },
        //文件上传方式
        method:"POST",
        chunked:true,
        // 分片大小
        chunkSize:512 * 1024,
        //最大上传的文件数量
        fileNumLimit:1,
        //单个文件大小(单位字节)
        fileSingleSizeLimit: 300 * 1024,
        //总文件大小
        fileSizeLimit: 900 * 1024,
        buttonText: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
front<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
    });

    $('#cardBack').diyUpload({
        url:'/register/uplodeimg',
        success:function( data ) {
            result = $("#img").html()+'<input type="hidden" name="cardBack[imgFilePath]" value='+data.imgFilePath+' /><input type="hidden" name="cardBack[type]" value='+data.type+' /><input type="hidden" name="cardBack[atname]" value='+data.atname+' /><input type="hidden" name="cardBack[imgUrl]" value='+data.imgUrl+' />';
            $("#img").html(result);
            result = '';
        },
        error:function( err ) {
            console.info( err );
        },
        //文件上传方式
        method:"POST",
        chunked:true,
        // 分片大小
        chunkSize:512 * 1024,
        //最大上传的文件数量
        fileNumLimit:1,
        //单个文件大小(单位字节)
        fileSingleSizeLimit: 300 * 1024,
        //总文件大小
        fileSizeLimit: 900 * 1024,
        buttonText: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
back<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
    });
});
</script><?php }} ?>