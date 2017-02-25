<{if $language != 'zh_CN'}>
<style type="text/css">
.reg_email_ver_content .gte_wrap { width: 780px; }
.reg_email_ver_content .gte_wrap p.reg_title { font-size: 14px; }
</style>
<{/if}>
<div class="common_wrap">
    <div class="reg_wrap">
        <div class="reg_select"><{t}>EmailVer<{/t}></div>
        <div class="reg_form_wrap reg_email_ver_content">
            <div class="gte_wrap">
                <p class="reg_title"><{t}>sendMailTip1<{/t}> <{$visitor['email']}> <{t}>sendMailTip2<{/t}></p>
                <a class='btn mail' target="_blank" href="<{$maileLoginLink}>" style="padding: 8px 12px;"><{t}>gotoEmail<{/t}></a>
                <div class="no_email">
                    <div class="no_email_title">
                        <{t}>getNoEmail<{/t}>
                    </div>
                    <div class="no_email_info">
                        <p>1.<{t}>getNoEmailStepF<{/t}></p>
                        <p>2.<{t}>getNoEmailStepSHead<{/t}><a href="/register/resend"><{t}>resend<{/t}></a><{t}>getNoEmailStepSFoot<{/t}></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>