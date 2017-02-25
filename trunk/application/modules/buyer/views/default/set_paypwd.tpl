<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$languageTpl}>.js"></script>
<style type="text/css">
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
                        <p class="tit" style="width: 160px"><{t}>payPwd<{/t}><{t}>colon<{/t}><span class="blue_00a0e9">*</span></p>
                        <div class="dl">
                            <input type="password" name="payPwd" class="input" data-rule="<{t}>payPwd<{/t}>:required;length(6~16)" data-tip="<{t}>payPwd<{/t}>:<{t}>Gtsix<{/t}>"//>
                        </div>
                    </div>
                </div>
                <div class="form_group margin_top25">
                    <div class="form_item clearfix">
                        <p class="tit" style="width: 160px"><{t}>ConfirmPassword<{/t}><{t}>colon<{/t}><span class="blue_00a0e9">*</span></p>
                        <div class="dl">
                            <input type="password" name="rePwd" class="input" data-rule="<{t}>ConfirmPassword<{/t}>:required;length(6~16):match[payPwd]" data-tip="<{t}>Gtsix<{/t}>"/>
                        </div>
                    </div>
                </div>
                <!-- notice -->
                <div class="form_group margin_top25">
                    <div class="form_item clearfix">
                        <p class="tit" style="width: 160px">&nbsp;</p>
                        <div class="dl">
                            <div id="noticeWrap"></div>
                        </div>
                    </div>
                </div>
                <p class="margin_top25">
                    <!--<a href="javascript:" class="blue_btn blue_btn_h_32 margin_left190"><{t}>Confirm<{/t}><{t}>submit<{/t}></a> -->
                    <input  class="submit" type="submit" value="<{t}>submit<{/t}>" id="submitBtn" />
                </p>
            </form>
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
    //表单验证
    $('#setPasswordForm').validator({
        valid: function() {
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: $('#setPasswordForm').serialize(),
                url: '/buyer/portal/do-set-paypwd',
                success: function(json) {
                    var html = '';
                    if (json.state == '1') {
                        //alertTip(json.message, 3);
                        var gotoURL = 'window.location.href="/buyer/portal/set-paypwd-success"';
                        var t = setTimeout(gotoURL, 1000);
                        /*
                        $('.bottom').hide();
                        $('#setSuccess').show();
                        $('#setSuccess').find('a').attr('href', json.backUrl);
                        */
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
                    }
                }
            });
        }
    });
});
</script>