<?php /* Smarty version Smarty-3.1.13, created on 2017-01-18 16:24:44
         compiled from "D:\www\etp\trunk\application\modules\buyer\views\account\company_info_manage.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17555587f242ca1d394-30565810%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '07462c304bfe9bace4746ce2ca4eb839fbc55b6f' => 
    array (
      0 => 'D:\\www\\etp\\trunk\\application\\modules\\buyer\\views\\account\\company_info_manage.tpl',
      1 => 1484727883,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17555587f242ca1d394-30565810',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_587f242cca28c8_63480575',
  'variables' => 
  array (
    'language' => 0,
    'isAllowEdit' => 0,
    'companyInfo' => 0,
    'currency' => 0,
    'item' => 0,
    'image' => 0,
    'notAllowEditNotice' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_587f242cca28c8_63480575')) {function content_587f242cca28c8_63480575($_smarty_tpl) {?><?php if (!is_callable('smarty_block_t')) include 'D:\\www\\etp\\trunk\\libs\\Smarty\\plugins\\block.t.php';
?><link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<link rel="stylesheet" type="text/css" href="/etp_style_v1.0/js/diyUpload/css/webuploader.css">
<link rel="stylesheet" type="text/css" href="/etp_style_v1.0/js/diyUpload/css/diyUpload.css">
<script src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<!--[if lt IE 9]>
<script src="/etp_style_v1.0/js/html5shiv.js"></script>
<script src="/etp_style_v1.0/js/respond.min.js"></script>
<![endif]-->

<!--<script type="text/javascript" src="/etp_style_v1.0/js/diyUpload/js/webuploader.html5only.min.js"></script>-->
<script type="text/javascript" src="/etp_style_v1.0/js/diyUpload/js/webuploader.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/diyUpload/js/diyUpload.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<?php echo $_smarty_tpl->tpl_vars['language']->value;?>
.js"></script>

<div class="top clearfix">
    <p class="dt">
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
companyInfoMange<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    </p>
    <div class="t_w2 border_b_line"></div>
</div>
<?php if ($_smarty_tpl->tpl_vars['isAllowEdit']->value==1){?>
<div class="m_mainContainer">
        <div class="form_group" <?php if ($_smarty_tpl->tpl_vars['language']->value=='en_US'){?>style="padding:20px 0 50px 30px;"<?php }?>>
            <form id="completeForm" action='' onsubmit='return false' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
companyName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <input type="text" class="input" name="companyName" value="<?php echo $_smarty_tpl->tpl_vars['companyInfo']->value['company_name'];?>
" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
companyName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required,length[6~120]" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
companyNameNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" />
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <input type="text" class="input" name="contacts" value="<?php echo $_smarty_tpl->tpl_vars['companyInfo']->value['contact_name'];?>
" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactName<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactNameNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" />
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactPhone<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <input type="text" class="input" name="contactNumber" value="<?php echo $_smarty_tpl->tpl_vars['companyInfo']->value['contact_telphone'];?>
" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactPhone<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactPhoneNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
address<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <input type="text" class="input" name="register_address" value="<?php echo $_smarty_tpl->tpl_vars['companyInfo']->value['register_address'];?>
" data-rule="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
address<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
address<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactEmail<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <!--<input type="text" class="input" name="email" readonly="readonly" value="<?php echo $_smarty_tpl->tpl_vars['companyInfo']->value['email'];?>
" data-rule="required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
contactEmailNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
" />-->
                        <?php echo $_smarty_tpl->tpl_vars['companyInfo']->value['email'];?>

                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
currency<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <select name="currency" id="currency" class="selBox288" data-rule="required" data-tip="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
currencyNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
">
                            <?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['currency']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
?>
                                <option value="<?php echo $_smarty_tpl->tpl_vars['item']->value['currency_code'];?>
" <?php if ($_smarty_tpl->tpl_vars['companyInfo']->value['currency']==$_smarty_tpl->tpl_vars['item']->value['currency_code']){?>selected<?php }?> >
                                    <?php echo $_smarty_tpl->tpl_vars['item']->value['currency_code'];?>
 <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?><?php echo $_smarty_tpl->tpl_vars['item']->value["currency_name"];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['item']->value["currency_name_en"];?>
<?php }?>
                                </option>
                                <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
businessLicense<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <div class="uploadBox">
                            <div id="businessLicense" class="clear">
                            </div>
                            <div style="height:150px;width:170px;margin-top:1px;" id="bl-imge" class="zj-img" />
                                <img src="/common/image/get-image?aid=<?php if (isset($_smarty_tpl->tpl_vars['image']->value[1])){?><?php echo $_smarty_tpl->tpl_vars['image']->value[1];?>
<?php }else{ ?>no-image<?php }?>" os="/common/image/get-image?aid=<?php if (isset($_smarty_tpl->tpl_vars['image']->value[1])){?><?php echo $_smarty_tpl->tpl_vars['image']->value[1];?>
<?php }else{ ?>no-image<?php }?>" style="height:150px;width:170px;" />
                            </div>
                        </div>
                        <p class="tip_w550">
                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
imageNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        </p>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
directorIdCard<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl clearfix" style="width: 380px;">
                        <div class="uploadBox f_left">
                            <div id="cardFront" class="clear">
                            </div>
                            <div style="height:150px;width:170px;margin-top:1px;" id="cf-img" class="zj-img" />
                                <img src="/common/image/get-image?aid=<?php if (isset($_smarty_tpl->tpl_vars['image']->value[2])){?><?php echo $_smarty_tpl->tpl_vars['image']->value[2];?>
<?php }else{ ?>no-image<?php }?>" os="/common/image/get-image?aid=<?php if (isset($_smarty_tpl->tpl_vars['image']->value[2])){?><?php echo $_smarty_tpl->tpl_vars['image']->value[2];?>
<?php }else{ ?>no-image<?php }?>" style="height:150px;width:170px;"/>
                            </div>
                        </div>
                        <div class="uploadBox f_left margin_left8">
                            <div id="cardBack" class="clear">
                            </div>
                            <div style="height:150px;width:170px;margin-top:1px;" id="cb-img" class="zj-img" />
                                <img src="/common/image/get-image?aid=<?php if (isset($_smarty_tpl->tpl_vars['image']->value[3])){?><?php echo $_smarty_tpl->tpl_vars['image']->value[3];?>
<?php }else{ ?>no-image<?php }?>" os="/common/image/get-image?aid=<?php if (isset($_smarty_tpl->tpl_vars['image']->value[3])){?><?php echo $_smarty_tpl->tpl_vars['image']->value[3];?>
<?php }else{ ?>no-image<?php }?>" style="height:150px;width:170px;" />
                            </div>
                        </div>
                        <p class="tip_w550">
                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
cardNotice<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        </p>
                    </div>
                </div>
                <!-- 保存图片 -->
                <span id="img" style="display:none;">
                </span>
                <!-- 提交按钮-->
                <div class="form_item margin_top50 clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        &nbsp;
                    </p>
                    <div style="display:inline-block;margin-left: 10px;">
                        <span><input type="submit" value="<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
edit<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
"/></span>
                    </div>
                    <div style="display:inline-block;width:450px;vertical-align:middle;">
                        <div id="noticeWrap" style="display:none;">
                            <div style="display:inline-block;"><i class="m_icon notice-wrap-img"></i></div>
                            <div style="display:inline-block;"><span class="notice-wrap-text"></span></div>
                        </div>
                    </div>
                </div>
                <div id="error-div" class="form_item clearfix">
                    <p class="tit <?php if ($_smarty_tpl->tpl_vars['language']->value=='zh_CN'){?>tit_120_zh_CN<?php }else{ ?>tit_225_en_US<?php }?>">
                        &nbsp;
                    </p>
                    <div style="display:inline-block;vertical-align:middle;" class="dl2">
                    </div>
                </div>
            </form>
        </div>
</div>
<script type="text/javascript">
    $(function() {
        //表单验证
        $('#completeForm').validator({
            //远程验证邮箱
            fields: {
                'email': "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
Email<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
:required;email;remote[/register/check-email-exists, visitor_type]"
            },
            valid: function() {
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#completeForm').serialize(),
                    url: '/buyer/account/edit-account-info',
                    success: function(json) {
                        var html = '';
                        if (json.state == '1') {
                            $('#error-div > .dl2').html('');
                            $('#error-div').hide();
                            $('.notice-wrap-img').addClass( 'suc' );
                            $('.notice-wrap-text').html( json.message );
                            $('#noticeWrap').fadeIn('fast').delay(3000).fadeOut('normal');
                            $('.img-file').remove();
                            if( $('.parentFileBox').length > 0 ) {
                                $.each( $('.parentFileBox'), function(k,v) {  
                                    var tmpImg = $('.parentFileBox').next('.zj-img').children('img');
                                    tmpImg.attr('os',tmpImg.attr('src'));
                                    $('.parentFileBox').remove();
                                    tmpImg.show();
                                })
                            }
                            $('.zj-img').show();
                        } else if (json.state == '-1') {
                            alertTip(json.message, 2);
                            setTimeout('window.location.href="/login"', 2000);
                        } else {
                            $('#noticeWrap').hide();
                            var html = '';
                            if( json.message )
                                html += '<p class="red_text"><i class="errorIcon"></i> '+ json.message +'</p>';
                            if( json.errors.length > 0 ) {
                                $.each(json.errors,function(k,v) {
                                    html += '<p class="red_text"><i class="errorIcon"></i> '+ v.errorMsg +'</p>';
                                });
                            }
                            $('#error-div > .dl2').html(html);
                            $('#error-div').show();
                        }
                    }
                });
            }
        });

        //文件上传
        $('#businessLicense').diyUpload({
            url: '/portal/resource/upload-image',
            success: function( json ) {
                if( json.state == 1 ) {
                    if( $('[name=blImage]').length >= 1 ) {
                        $('[name=blImage]').val( json.fileName );
                    } else {
                        $('#completeForm').append('<input type="hidden" class="img-file" name="blImage" value=' + json.fileName + ' />');
                    }
                    $('#bl-imge img').attr('src',$('textarea[name="businessLicense[]"]').val());
                } else {
                    $('[name=blImage]').remove();
                }
                
            },
            error: function(err) {
                console.info(err);
            },
            method: "POST",
            fileNumLimit: 1,
            buttonText: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
businessLicense<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
            cancelAllFileTrigger:function() {
                $('#bl-imge img').attr('src',$('#bl-imge img').attr('os'));
                $('#bl-imge').show();
                $('[name=blImage]').remove();
            },
            selectFileTrigger:function() {
                $('#bl-imge').hide();
                $('[name=blImage]').remove();
            },
            removeCancel:false
        });

        $('#cardFront').diyUpload({
            url: '/portal/resource/upload-image',
            success: function(json) {
                if( json.state == 1 ) {
                    if( $('[name=cfImage]').length >= 1 ) {
                        $('[name=cfImage]').val( json.fileName );
                    } else {
                        $('#completeForm').append('<input type="hidden" class="img-file" name="cfImage" value=' + json.fileName + ' />');
                    }
                    $('#cf-imge img').attr('src',$('textarea[name="cardFront[]"]').val());
                } else {
                    $('[name=cfImage]').remove();
                }
            },
            error: function(err) {
                console.info(err);
            },
            method: "POST",
            fileNumLimit: 1,
            buttonText: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
front<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
            cancelAllFileTrigger:function() {
                $('#cf-imge img').attr('src',$('#cf-imge img').attr('os'));
                $('#cf-img').show();
                $('[name=cfImage]').remove();
            },
            selectFileTrigger:function() {
                $('#cf-img').hide();
                $('[name=cfImage]').remove();
            },
            removeCancel:false
        });

        $('#cardBack').diyUpload({
            url: '/portal/resource/upload-image',
            success: function(json) {
                if( json.state == 1 ) {
                    if( $('[name=cbImage]').length >= 1 ) {
                        $('[name=cbImage]').val( json.fileName );
                    } else {
                        $('#completeForm').append('<input type="hidden" class="img-file" name="cbImage" value=' + json.fileName + ' />');
                    }
                    $('#cb-img img').attr('src',$('textarea[name="cardBack[]"]').val());
                } else {
                    $('[name=cbImage]').remove();
                }
            },
            error: function(err) {
                console.info(err);
            },
            method: "POST",
            fileNumLimit: 1,
            buttonText: "<?php $_smarty_tpl->smarty->_tag_stack[] = array('t', array()); $_block_repeat=true; echo smarty_block_t(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
back<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_t(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>
",
            cancelAllFileTrigger:function() {
                $('#cb-img img').attr('src',$('#cb-img img').attr('os'));
                $('#cb-img').show();
                $('[name=cbImage]').remove();
            },
            selectFileTrigger:function() {
                $('#cb-img').hide();
                $('[name=cbImage]').remove();
            },
            removeCancel:false
        });
    });
</script>
<?php }else{ ?>
<div class="m_mainContainer">
    <div class="form_group">
        <div style="padding: 10px"><?php echo $_smarty_tpl->tpl_vars['notAllowEditNotice']->value;?>
</div>
    </div>
</div>
<?php }?><?php }} ?>