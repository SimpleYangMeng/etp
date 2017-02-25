<style type="text/css">
.m_mainContainer .tips_notice { padding-top: 120px; }
<{if $language == 'zh_CN'}>
.m_mainContainer .tips_notice { padding-left: 252px; }
i.m_icon.suc { margin-left: 130px; }
<{/if}>
</style>
<div class="min_width">
    <div class="tips_notice">
        <div class="bot">
            <div class="clearfix">
                <i class="m_icon suc f_left margin_left50"></i>
                <p class="f_left info f16 margin_left8"><{t}>loginPwdSuccessNotice<{/t}></p>
            </div>
            <p class="margin_top25">
                <a href="/buyer/portal" class="blue_btn blue_btn_h_32 margin_left190"><{t}>login_in<{/t}><{t}>operationAdmin<{/t}></a>
            </p>
            <p class="margin_top20">
                <{if $language == 'zh_CN'}>
                <a href="/buyer/portal" class="blue_link f14 margin_left150">
                    系统将在
                    <span id="second_span">
                    5s
                    </span>
                    后自动跳转至登陆页面
                </a>
                <{else}>
                <a href="/buyer/portal" class="blue_link f14 <{if $language == 'en_US'}>margin_left100<{else}>margin_left150<{/if}>">
                    The system will jump to the landing page after 
                    <span id="second_span">
                    5s
                    </span>
                </a>
                <{/if}>
            </p>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function (){
    var second = 5;
    var timeOut = setInterval(function() {
        if( second >= 0 ){
            $('#second_span').text(second+'s');
        }else {
            loginOut();
            window.location.href =  '<{$indexUrl}>';
        }
        second = second - 1;
    }, 1000);

    //注销登陆
    function loginOut(){
        $.ajax({
            type: "POST",
            async: false,
            dataType: "json",
            data: '',
            url: '/default/login/out',
            success: function(json) {
                console.log(json);
            }
        });
    }
});
</script>