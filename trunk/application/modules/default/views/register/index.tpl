<style type="text/css">
input[type='text'],input[type='password'] { font-size: 14px; border: none; padding: 0 ; height: 20px; line-height: 20px; margin: 0px 0 0 8px;overflow: hidden; outline: 0; background: transparent; width: 94%;}
div.in_footerContainer { background: #313131; }
.n-simple .n-bottom .msg-wrap{ margin-top: 12px; }
.notice-str {width: 300px; line-height: 1.2em;vertical-align: middle}
</style>
<div class="common_wrap">
    <div class="reg_wrap">
        <div class="reg_select"><{t}>SelectType<{/t}></div>
        <div class="reg_form_wrap">
            <form id="registerForm" action='' onsubmit='return false' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'simple_bottom'}">
                <div class="reg_form_inner_wrap">
                    <div class="reg_line_wrap">
                        <span class="reg_title"><{t}>regType<{/t}><{t}>colon<{/t}><i>*</i></span>
                        <span class="reg_input">
                            <label><input type="radio" name="visitor_type" value="1" checked="checked" /><{t}>buyer<{/t}></label>
                            <label><input type="radio" name="visitor_type" value="2" /><{t}>seller<{/t}></label>
                        </span>
                        <span class="notice notice-str"><{t}>PleaseSelectType<{/t}></span>
                    </div>
                    <!--
                    <div class="reg_line_wrap">
                        <span class="reg_title"><{t}>UserName<{/t}><{t}>colon<{/t}><i>*</i></span>
                        <span class="reg_input input_wrap"><input type="text" class="text-input" data-rule="<{t}>userCode<{/t}>:required" id="username" name="username" /></span>
                        <span class="notice notice-str"><{t}>UserName<{/t}><{t}>NoEmpty<{/t}></span>
                    </div>
                    -->
                    <div class="reg_line_wrap">
                        <span class="reg_title"><{t}>Email<{/t}><{t}>colon<{/t}><i>*</i></span>
                        <span class="reg_input input_wrap"><input type="text" class="text-input" data-rule="<{t}>Email<{/t}>:required;email" id="email" name="email" /></span>
                        <span class="notice notice-str"><{t}>EmailNotice<{/t}></span>
                    </div>
                    <div class="reg_line_wrap">
                        <span class="reg_title"><{t}>userPass<{/t}><{t}>colon<{/t}><i>*</i></span>
                        <span class="reg_input input_wrap"><input type="password" class="text-input" data-rule="<{t}>userPass<{/t}>:required;length(6~16)" id="userpwd" name="userpwd" /></span>
                        <span class="notice notice-str"><{t}>Gtsix<{/t}></span>
                    </div>
                    <div class="reg_line_wrap">
                        <span class="reg_title"><{t}>confirmPwd<{/t}><{t}>colon<{/t}><i>*</i></span>
                        <span class="reg_input input_wrap"><input type="password" class="text-input" data-rule="<{t}>confirmPwd<{/t}>:required;length(6~16);match[userpwd]" id="repwd" name="repwd" /></span>
                        <span class="notice notice-str"><{t}>rePassword<{/t}></span>
                    </div>
                    <div class="reg_line_wrap cl">
                        <span class="reg_title leftloat"><{t}>VerifyCode<{/t}><{t}>colon<{/t}><i>*</i></span>
                        <span class="reg_input verify_input input_wrap leftloat"><input type="text" id="verify" name="verify" style="text-transform:uppercase;"/></span>
                        <span class="verify_code leftloat">
                            <img class="verifyChange" id="verifyImg" title="<{t}>ChangeVerifyCode<{/t}>" src="/register/verify-code" valign="absmiddle"/>
                        </span>
                        <span class="notice notice-str leftloat"><{t}>vCodeRequired<{/t}> (<{t}>CaseInsensitive<{/t}>)</span>
                    </div>
                    <div class="reg_submit_btn">
                        <input <{if $language == 'en_US'}> style="width:200px;"<{/if}> type="submit" value="<{t}>ConfirmReg<{/t}>" id="registersub" />
                        <input type="reset" value="<{t}>reset<{/t}>" />
                        <a href="/login" alt="login" style="text-decoration:underline"><{t}>loginNow<{/t}></a>
                    </div>
                    <div id="registerinfo"></div>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" language="javascript">
$(function(){
    $(".verifyChange").click(function(){
        $('#verifyImg').attr("src","/register/verify-code?"+Math.random());
    });
    var visitor_type = $("input[name=visitor_type][checked]").val();
    var submit = $('.submit');
    $('#registerForm').validator({
        valid: function (){
            //submit.showLoading({addClass:'loading-indicator-circle-1'});
            //submit.addClass('disabled');
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: $('#registerForm').serialize(),
                url: '/register/save',
                success: function(json) {
                    //console.log(json);
                    var html = '';
                    if(json.state == '1'){
                        //html += "<p class='messageSuccess'><image src='/images/icons/icon_approve.png' /> "+json.message+"</p>";
                        //$('.orderMessage').html(json.message).show();
                        //$('#refundbillForm').resetForm();
                        alertTip(json.message, 3);
                        var gotoURL ='window.location.href="/register/step?current=2&visitor_type='+json.visitor_type+'"';
                        var t = setTimeout(gotoURL, 1000);
                    }else if (0 == json.state) {
                        if(typeof(json.authcodeError) != 'undefined' && json.authcodeError == 1){
                            $(".verifyChange").click();
                        }
                        if (json.error) {
                            alertTip(json.message+';'+json.error.join(';'));
                        }else if (json.message) {
                            alertTip(json.message);
                        }
                    }else {
                        html +=json.message;
                        if(html){ alertTip( html, 1)};
                        if(typeof(json.error) != 'undefined'){
                            $('#registerinfo').empty();
                            $.each(json.error,function(key,item){
                                html += "<p class='messageFail'><image src='/images/icons/icon_missing.png' /> "+item+"</p>";
                            })
                            $('#registerinfo').html(html);
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
	if( reloadinfo == 1 ){$('#registerinfo').empty();}
	if( reloadinfo == 3 ){
		$('#registerinfo').empty();
		$('<span class="success">'+tip+'</span>').appendTo($('#registerinfo').show());
	}else {
        $('<span class="error">'+tip+'</span>').appendTo($('#registerinfo').show());
    }
}
</script>