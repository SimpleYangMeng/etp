<div class="common_wrap">
    <div class="reg_wrap">
        <div class="reg_select"><{t}>EmailVer<{/t}></div>
        <div class="reg_form_wrap reg_email_ver_content">
            <div class="gte_wrap">
                <p class="active_code_error_title"><span class="active_code_error_content cl"><span class="active_code_error_ico leftloat"></span><{$notice}></span></p>
                <{if $is_show_resend == 1}>
                    <a class='btn mail' href="/register/resend" style="padding: 8px 12px;"><{t}>resendEmail<{/t}></a>
                    <div class="no_email">
                        <div class="no_email_title">
                            <{t}>getNoEmail<{/t}>
                        </div>
                        <div class="no_email_info">
                            <p>1.<{t}>getNoEmailStepF<{/t}></p>
                            <p>2.<{t}>getNoEmailStepSHead<{/t}><a href="/register/resend"><{t}>resend<{/t}></a><{t}>getNoEmailStepSFoot<{/t}></p>
                        </div>
                    </div>
                <{/if}>
            </div>
        </div>
    </div>
</div>