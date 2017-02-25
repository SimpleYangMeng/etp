<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>
<style type="text/css">
    .tooltip.top .tooltip-arrow { bottom: -5px; }
</style>
<div class="top clearfix">
    <p class="dt"><{t}>setPaymentPassword<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="<{if $language=='zh_CN'}>form_group<{else}>form_group_en_US<{/if}>  clearfix">
        <form id="setPasswordForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <div class="form_item margin_top45 clearfix">
                <span class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}> f_left"><{t}>oldPassword<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="password" name="payPwd" class="input200" data-rule="<{t}>oldPassword<{/t}>:required;length(6~16)" data-tip="<{t}>oldPassword<{/t}>"/>
                </div>
            </div>
            <div class="form_item margin_top45 clearfix">
                <span class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}> f_left"><{t}>newPassword<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="password" name="newPwd" class="input200" data-rule="<{t}>newPassword<{/t}>:required;length(6~16)" data-tip="<{t}>Gtsix<{/t}>"/>
                </div>
            </div>
            <div class="form_item margin_top45 clearfix">
                <span class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}> f_left"><{t}>confirmNewPpwd<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="password" name="reNewPwd" class="input200" data-rule="<{t}>confirmNewPpwd<{/t}>:required;length(6~16):match[newPwd]" data-tip="<{t}>rePassword<{/t}>"/>
                </div>
            </div>
            <div class="form_item clearfix" style="margin-top: 50px">
                <span class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}> f_left">&nbsp;</span>
                <p class="f_left" style="padding-left: 12px;">
                    <button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<{t}>submiting<{/t}>"><{t}>submit<{/t}></button>
                </p>
            </div>
            <div class="form_item margin_top25 clearfix">
                <span class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}> f_left">&nbsp;</span>
                <div class="f_left" id="noticeWrap"></div>
            </div>
        </form>
    </div>
    <div class="maincenter-box-tip">
        <p class="ui-tiptext ui-tiptext-message cl">
            <span class="ui-tiptext-icon f_left"></span>
            <span class="ui-tiptext-text f_right">
                <{t}>loginPwdNotice<{/t}>
                <a href="javascript:;" id="password_tip" data-toggle="tooltip" data-html="true" data-trigger="click" data-placement="top" title="<{t}>loginPwdReg<{/t}>"><{t}>loginPwdHow<{/t}></a>
            </span>
        </p>
    </div>
</div>

<!-- 修改成功 -->
<div class="bottom" id="setSuccess" style="display: none;">
    <p class="f16 gray_616161 clearfix" style="padding: 140px 0px 0px 235px;">
        <i class="m_icon suc f_left"></i>
        <span class="f_left margin_left10" style="display: inline-block;height: 25px;line-height: 25px;"><{t}>setPayPwdSuccess<{/t}></span>
    </p>
    <p class="text_align_c margin_top35">
        <a href="/buyer/portal" class="blue_btn blue_btn_h_32 f14"><{t}>goHome<{/t}></a>
    </p>
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
    $('#password_tip').tooltip();
    var submit = $('.submit');
    //表单验证
    $('#setPasswordForm').validator({
        //验证原始密码
        fields: {
            'payPwd': "<{t}>oldPassword<{/t}>:required;remote[/buyer/account/check-pwd, payPwd]"
        },
        valid: function() {
            submit.showLoading({addClass:'loading-indicator-circle-1'});
            submit.addClass('disabled');
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: $('#setPasswordForm').serialize(),
                url: '/buyer/account/update-pay-pwd',
                success: function(json) {
                    if (json.state == '1') {
                        /*
                        alertTip(json.message, 3);
                        var gotoURL = 'window.location.href=" ' + json.backUrl + ' "';
                        var t = setTimeout(gotoURL, 2000);
                        */
                        $('.bottom').hide();
                        $('#setSuccess').show();
                    }else {
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
                    //重置提交按钮可用
                    submit.hideLoading();
                    submit.removeClass('disabled');
                }
            });
        }
    });
});
</script>