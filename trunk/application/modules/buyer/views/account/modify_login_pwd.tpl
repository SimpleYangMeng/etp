<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>
<style type="text/css">
.m_mainContainer { min-height: 580px; }
.m_mainContainer div.tips_notice { padding-left: 0; }
.m_mainContainer div.tips_notice .tips_notice_wrap { text-align: center;  width: 730px; margin: 0 auto; }
div#noticeWrap { width: auto; text-align: left; }
</style>
<div class="min_width">
    <div class="tips_notice">
        <div class="tips_notice_wrap">
            <form id="setPasswordForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                <div class="form_group margin_top25">
                    <div class="form_item clearfix">
                        <p class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}>"><{t}>oldLoginPwd<{/t}><{t}>colon<{/t}><span class="blue_00a0e9">*</span></p>
                        <div class="dl">
                            <input type="password" name="oldLoginPwd" class="input" data-rule="<{t}>oldLoginPwd<{/t}>:required;length(6~16)" data-tip="<{t}>oldLoginPwd<{/t}>"//>
                        </div>
                    </div>
                </div>
                <div class="form_group margin_top25">
                    <div class="form_item clearfix">
                        <p class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}>"><{t}>newLoginPwd<{/t}><{t}>colon<{/t}><span class="blue_00a0e9">*</span></p>
                        <div class="dl">
                            <input type="password" name="newLoginPwd" class="input" data-rule="<{t}>newLoginPwd<{/t}>:required;length(6~16)" data-tip="<{t}>Gtsix<{/t}>"/>
                        </div>
                    </div>
                </div>
                <div class="form_group margin_top25">
                    <div class="form_item clearfix">
                        <p class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}>"><{t}>confirmLoginPwd<{/t}><{t}>colon<{/t}><span class="blue_00a0e9">*</span></p>
                        <div class="dl">
                            <input type="password" name="reLoginPwd" class="input" data-rule="<{t}>confirmLoginPwd<{/t}>:required;length(6~16);match[newLoginPwd]" data-tip="<{t}>Gtsix<{/t}>"/>
                        </div>
                    </div>
                </div>
                <div class="form_item clearfix" style="margin-top: 50px">
                    <span class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}> f_left">&nbsp;</span>
                    <div class="dl">
                        <button type="submit" class="btn btn-primary btn-check submit margin_left8 f_left" data-loading-text="<{t}>submiting<{/t}>"><{t}>submit<{/t}></button>
                    </div>
                </div>
                <div class="form_item margin_top25 clearfix">
                    <span class="tit <{if $language=='zh_CN'}>tit_130_zh_CN<{else}>tit_235_en_US<{/if}> f_left">&nbsp;</span>
                    <div class="dl f_left padding_left20" id="noticeWrap"></div>
                </div>
                
            </form>
        </div>
        <!-- pwd notice -->
        <div class="maincenter-box-tip margin_top20">
            <p class="ui-tiptext ui-tiptext-message cl">
                <span class="ui-tiptext-icon f_left"></span>
                <span class="ui-tiptext-text f_left">
                    <{t}>loginPwdNotice<{/t}>
                    <a href="javascript:;" id="password_tip" data-toggle="tooltip" data-html="true" data-trigger="click" data-placement="bottom" title="<{t}>loginPwdReg<{/t}>"><{t}>loginPwdHow<{/t}></a>
                </span>
            </p>
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
    //密码提示信息
    $('#password_tip').tooltip();
    var submit = $('.submit');
    //表单验证
    $('#setPasswordForm').validator({
        valid: function() {
            //提交中
            submit.showLoading({addClass:'loading-indicator-circle-1'});
            submit.addClass('disabled');
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: $('#setPasswordForm').serialize(),
                url: '/buyer/account/submit-login-pwd',
                success: function(json) {
                    var html = '';
                    //重置成功
                    if (json.state == '1') {
                        //服务端跳转
                        alertTip(json.message, 3);
                        var gotoURL = 'window.location.href="/buyer/account/set-loginpwd-success"';
                        var t = setTimeout(gotoURL, 500);
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
                        //重置提交按钮可用
                        submit.hideLoading();
                        submit.removeClass('disabled');
                    }
                }
            });
        }
    });
});
</script>