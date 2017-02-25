<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
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
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>

<div class="top clearfix">
    <p class="dt">
        <{t}>companyInfoMange<{/t}>
    </p>
    <div class="t_w2 border_b_line"></div>
</div>
<{if $isAllowEdit == 1}>
<div class="m_mainContainer">
        <div class="form_group" <{if $language == 'en_US' }>style="padding:20px 0 50px 30px;"<{/if}>>
            <form id="completeForm" action='' onsubmit='return false' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        <{t}>companyName<{/t}>
                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <input type="text" class="input" name="companyName" value="<{$companyInfo['company_name']}>" data-rule="<{t}>companyName<{/t}>:required,length[6~120]" data-tip="<{t}>companyNameNotice<{/t}>" />
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        <{t}>contactName<{/t}>
                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <input type="text" class="input" name="contacts" value="<{$companyInfo['contact_name']}>" data-rule="<{t}>contactName<{/t}>:required" data-tip="<{t}>contactNameNotice<{/t}>" />
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        <{t}>contactPhone<{/t}>
                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <input type="text" class="input" name="contactNumber" value="<{$companyInfo['contact_telphone']}>" data-rule="<{t}>contactPhone<{/t}>:required" data-tip="<{t}>contactPhoneNotice<{/t}>"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        <{t}>address<{/t}>
                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <input type="text" class="input" name="register_address" value="<{$companyInfo['register_address']}>" data-rule="<{t}>address<{/t}>:required" data-tip="<{t}>address<{/t}>"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        <{t}>contactEmail<{/t}>
                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <!--<input type="text" class="input" name="email" readonly="readonly" value="<{$companyInfo['email']}>" data-rule="required" data-tip="<{t}>contactEmailNotice<{/t}>" />-->
                        <{$companyInfo['email']}>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        <{t}>currency<{/t}>
                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <select name="currency" id="currency" class="selBox288" data-rule="required" data-tip="<{t}>currencyNotice<{/t}>">
                            <{foreach from=$currency item=item}>
                                <option value="<{$item['currency_code']}>" <{if $companyInfo['currency'] == $item['currency_code'] }>selected<{/if}> >
                                    <{$item[ 'currency_code']}> <{if $language == 'zh_CN'}><{$item[ "currency_name"]}><{else}><{$item[ "currency_name_en"]}><{/if}>
                                </option>
                                <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        <{t}>businessLicense<{/t}>
                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl">
                        <div class="uploadBox">
                            <div id="businessLicense" class="clear">
                            </div>
                            <div style="height:150px;width:170px;margin-top:1px;" id="bl-imge" class="zj-img" />
                                <img src="/common/image/get-image?aid=<{if isset( $image[1] ) }><{$image[1]}><{else}>no-image<{/if}>" os="/common/image/get-image?aid=<{if isset( $image[1] ) }><{$image[1]}><{else}>no-image<{/if}>" style="height:150px;width:170px;" />
                            </div>
                        </div>
                        <p class="tip_w550">
                            <{t}>imageNotice<{/t}>
                        </p>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        <{t}>directorIdCard<{/t}>
                        <span class="blue_00a0e9">*</span>
                    </p>
                    <div class="dl clearfix" style="width: 380px;">
                        <div class="uploadBox f_left">
                            <div id="cardFront" class="clear">
                            </div>
                            <div style="height:150px;width:170px;margin-top:1px;" id="cf-img" class="zj-img" />
                                <img src="/common/image/get-image?aid=<{if isset( $image[2] ) }><{$image[2]}><{else}>no-image<{/if}>" os="/common/image/get-image?aid=<{if isset( $image[2] ) }><{$image[2]}><{else}>no-image<{/if}>" style="height:150px;width:170px;"/>
                            </div>
                        </div>
                        <div class="uploadBox f_left margin_left8">
                            <div id="cardBack" class="clear">
                            </div>
                            <div style="height:150px;width:170px;margin-top:1px;" id="cb-img" class="zj-img" />
                                <img src="/common/image/get-image?aid=<{if isset( $image[3] ) }><{$image[3]}><{else}>no-image<{/if}>" os="/common/image/get-image?aid=<{if isset( $image[3] ) }><{$image[3]}><{else}>no-image<{/if}>" style="height:150px;width:170px;" />
                            </div>
                        </div>
                        <p class="tip_w550">
                            <{t}>cardNotice<{/t}>
                        </p>
                    </div>
                </div>
                <!-- 保存图片 -->
                <span id="img" style="display:none;">
                </span>
                <!-- 提交按钮-->
                <div class="form_item margin_top50 clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
                        &nbsp;
                    </p>
                    <div style="display:inline-block;margin-left: 10px;">
                        <span><input type="submit" value="<{t}>edit<{/t}>"/></span>
                    </div>
                    <div style="display:inline-block;width:450px;vertical-align:middle;">
                        <div id="noticeWrap" style="display:none;">
                            <div style="display:inline-block;"><i class="m_icon notice-wrap-img"></i></div>
                            <div style="display:inline-block;"><span class="notice-wrap-text"></span></div>
                        </div>
                    </div>
                </div>
                <div id="error-div" class="form_item clearfix">
                    <p class="tit <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_225_en_US<{/if}>">
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
                'email': "<{t}>Email<{/t}>:required;email;remote[/register/check-email-exists, visitor_type]"
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
            buttonText: "<{t}>businessLicense<{/t}>",
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
            buttonText: "<{t}>front<{/t}>",
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
            buttonText: "<{t}>back<{/t}>",
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
<{else}>
<div class="m_mainContainer">
    <div class="form_group">
        <div style="padding: 10px"><{$notAllowEditNotice}></div>
    </div>
</div>
<{/if}>