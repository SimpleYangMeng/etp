
<!-- diyUpload -->
<link rel="stylesheet" type="text/css" href="/etp_style_v1.0/js/diyUpload/css/webuploader.css">
<link rel="stylesheet" type="text/css" href="/etp_style_v1.0/js/diyUpload/css/diyUpload.css">
<script type="text/javascript" src="/etp_style_v1.0/js/diyUpload/js/webuploader.html5only.min.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/diyUpload/js/diyUpload.js"></script>

<div class="m_mainContainer">
    <div class="min_width">
        <p class="title"><{t}>seller<{/t}><{t}>completeData<{/t}></p>
        <div class="form_group">
            <form id="completeForm" action='' onsubmit='return false' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                <input type="hidden" name="visitor_type" value="<{$visitor_type}>" />
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>Email<{/t}><{t}>VerifyCode<{/t}> <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="email_verify" data-rule="<{t}>Email<{/t}><{t}>VerifyCode<{/t}>:required" data-tip="<{t}>emailCodeInfo<{/t}>"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>companyName<{/t}> <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[company_name]" data-rule="<{t}>companyName<{/t}>:required" data-tip="<{t}>companyNameNotice<{/t}>"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>address<{/t}> <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[register_address]" data-rule="<{t}>address<{/t}>:required" data-tip="<{t}>addressNotice<{/t}>"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>contactName<{/t}> <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[contact_name]" data-rule="<{t}>contactName<{/t}>:required" data-tip="<{t}>contactNameNotice<{/t}>"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>contactPhone<{/t}> <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[contact_telphone]" data-rule="<{t}>contactPhone<{/t}>:required" data-tip="<{t}>contactPhoneNotice<{/t}>"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>contactEmail<{/t}> <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <input type="text" class="input" name="complereData[email]" value="<{$visitor['email']}>" readonly="true" data-rule="required" data-tip="<{t}>contactEmailNotice<{/t}>"/>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>currency<{/t}> <span class="blue_00a0e9">*</span></p>
                    <div class="dl">
                        <select name="complereData[currency]" id="currency" class="selBox" data-rule="required" data-tip="<{t}>currencyNotice<{/t}>">
                            <{foreach from=$currencys item=item}>
                                <option value="<{$item['currency_code']}>"><{$item['currency_code']}> <{$item["currency_name"]}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>businessLicense<{/t}> <span class="blue_00a0e9"></span></p>
                    <div class="dl">
                        <div class="uploadBox">
                            <!--<input type="button" id="file_upload_1" name="file"  data-rule="required" data-tip="<{t}>businessLicenseNotice<{/t}>"/>-->
                            <div id="businessLicense" class="clear"></div>
                        </div>
                    </div>
                    <!--<p class="tip"><{t}><{/t}></p>-->
                </div>
                <div class="form_item margin_top25 clearfix">
                    <p class="tit"><{t}>directorIdCard<{/t}> <span class="blue_00a0e9"></span></p>
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
                    <p class="tip" style="width: 300px;"><{t}>cardNotice<{/t}></p>
                </div>
                <!-- 保存图片 -->
                <span id="img" style="display:none;"></span>
                <!-- 提交按钮-->
                <div class="form_item margin_top50 clearfix">
                    <p class="tit">&nbsp;</p>
                    <div class="dl">
                        <input type="submit" value="<{t}>Confirm<{/t}><{t}>submit<{/t}>" id="registersub" />
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
            'email': '<{t}>Email<{/t}>:required;email;remote[/register/check-email-exists, visitor_type]'
        },
        valid: function (){
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: $('#completeForm').serialize(),
                url: '/register/complete',
                success: function(json) {
                    var html = '';
                    if(json.state=='1'){
                        alertTip(json.msg, 3);
                        var gotoURL ='window.location.href="/register/step?current=4&visitor_type='+json.visitor_type+'"';
                        var t = setTimeout(gotoURL,2000);
                    }else if(json.state == '-1'){
                        alertTip(json.msg, 2);
                        setTimeout('window.location.href="/login"', 2000);
                    }else {
                        html += json.msg;
                        if(typeof(json.error) != 'undefined'){
                            $('#noticeWrap').empty();
                            $.each(json.error, function(key, item){
                                alertTip(item, 2);
                            });
                        }
                        alertTip(html, 2);
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
        buttonText: '<{t}>pleaseSelected<{/t}><{t}>businessLicense<{t}>',
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
        buttonText: '<{t}>front<{/t}>',
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
        buttonText: '<{t}>back<{/t}>',
    });
});
</script>