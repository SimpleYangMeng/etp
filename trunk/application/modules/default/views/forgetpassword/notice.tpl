
<div class="common_wrap">
    <div class="reg_wrap">
        <div class="reg_select"><{t}>forgetEmailSubject<{/t}></div>
        <div class="reg_form_wrap reg_email_ver_content">
                <{if $is_show_next == 0}>
                    <div class="gte_wrap">
                        <p class="active_code_error_title"><span class="active_code_error_content cl"><span class="active_code_error_ico leftloat"></span><{$notice}></span></p>
                        <div class="no_email">
                            <div class="no_email_title">
                                <{t}>getNoEmail<{/t}>
                            </div>
                            <div class="no_email_info">
                                <p>1.<{t}>getNoEmailStepF<{/t}></p>
                            </div>
                        </div>
                    </div>
                <{else}>
                    <style type="text/css">
                    input[type='text'],input[type='password'] { font-size: 14px; border: none; padding: 0 ; height: 20px; line-height: 20px; margin: 0px 0 0 8px;overflow: hidden; outline: 0; background: transparent; width: 94%;}
                    .n-simple .n-bottom .msg-wrap{ margin-top: 12px; }
                    #noticeWrap {margin-top: 20px; color: #FF0000; }
                    </style>
                    <!--<p class="active_code_error_title"><span class="active_code_error_content cl"><span class="active_code_success_ico leftloat"></span><{$notice}></span></p>-->
                    <div class="forget_sub_form">
                        <form id="forgetPasswordForm" action='' onsubmit='return false' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'simple_bottom'}">
                            <input type="hidden" name="accountType" value="<{$data.visitor_type}>" />
                            <input type="hidden" name="accountId" value="<{$data.visitor_id}>" />
                            <div class="reg_form_inner_wrap">
                                <div class="reg_line_wrap">
                                    <span class="reg_title"><{t}>newLoginPwd<{/t}><i>*</i></span>
                                    <span class="reg_input input_wrap"><input type="password" class="text-input" data-rule="<{t}>newLoginPwd<{/t}>:required;length(6~16)" id="newLoginPwd" name="newLoginPwd" /></span>
                                    <span class="notice"><{t}>loginPwdDetailNotice<{/t}></span>
                                </div>
                                <div class="reg_line_wrap">
                                    <span class="reg_title"><{t}>Confirm<{/t}><{t}>password<{/t}><i>*</i></span>
                                    <span class="reg_input input_wrap"><input type="password" class="text-input" data-rule="<{t}>Confirm<{/t}><{t}>password<{/t}>:required;length(6~16);match[newLoginPwd]" name="reLoginPwd"/></span>
                                    <span class="notice"><{t}>rePassword<{/t}></span>
                                </div>
                                <div class="reg_line_wrap cl">
                                    <span class="reg_title leftloat"><{t}>VerifyCode<{/t}><i>*</i></span>
                                    <span class="reg_input verify_input input_wrap leftloat">
                                        <input type="text" id="verify" name="verify" style="text-transform:uppercase;" />
                                    </span>
                                    <span class="verify_code leftloat">
                                        <img class="verifyChange" id="verifyImg" title="<{t}>ChangeVerifyCode<{/t}>" src="/forget-password/verify-code" valign="absmiddle"/>
                                    </span>
                                    <span class="notice leftloat"><{t}>VerifyCode<{/t}><{t}>require<{/t}>(<{t}>CaseInsensitive<{/t}>)</span>
                                </div>
                                <div class="reg_submit_btn">
                                    <input type="submit" value="<{t}>submitApplication<{/t}>" />
                                    <a href="/login" alt="login"><{t}>loginNow<{/t}></a>
                                </div>
                                <div id="noticeWrap"><span class="success"></span></div>
                            </div>
                        </form>
                    </div>
                    <script type="text/javascript" language="javascript">
                    $(function(){
                        $(".verifyChange").click(function(){
                            $('#verifyImg').attr("src","/forget-password/verify-code?"+Math.random());
                        });
                        var visitor_type = $("input[name=visitor_type][checked]").val();
                        var submit = $('.submit');
                        $('#forgetPasswordForm').validator({
                            valid: function (){
                                //submit.showLoading({addClass:'loading-indicator-circle-1'});
                                //submit.addClass('disabled');
                                $.ajax({
                                    type: "POST",
                                    async: false,
                                    dataType: "json",
                                    data: $('#forgetPasswordForm').serialize(),
                                    url: '/forget-password/reset-pwd',
                                    success: function(json) {
                                        //console.log(json);
                                        var html = '';
                                        if(json.state == '1'){
                                            alertTip(json.message, 3);
                                            var gotoURL ='window.location.href="/login/login?visitor_type='+json.visitor_type+'"';
                                            var t = setTimeout(gotoURL, 1000);
                                        }else {
                                            html += json.message;
                                            if(html){ alertTip( html, 1)};
                                            if(typeof(json.error) != 'undefined'){
                                                //$('#noticeWrap').empty();
                                                $.each(json.error,function(key,item){
                                                    html += "<p class='messageFail'><image src='/images/icons/icon_missing.png' /> "+item+"</p>";
                                                })
                                                $('#noticeWrap').html(html);
                                            }
                                        }
                                        //submit.hideLoading();
                                        //submit.removeClass('disabled');
                                    }
                                });
                            }
                        });
                    });

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
                    </script>
                <{/if}>
        </div>
    </div>
</div>