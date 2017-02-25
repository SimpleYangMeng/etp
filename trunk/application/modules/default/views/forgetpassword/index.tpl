<style type="text/css">
input[type='text'],input[type='password'] { font-size: 14px; border: none; padding: 0 ; height: 20px; line-height: 20px; margin: 0px 0 0 8px;overflow: hidden; outline: 0; background: transparent; width: 94%;}
.n-simple .n-bottom .msg-wrap{ margin-top: 12px; }
#noticeWrap {margin-top: 20px; color: #FF0000; }
</style>
<div class="common_wrap">
    <div class="reg_wrap">
        <div class="reg_select"><{t}>forgetPassword<{/t}></div>
        <div class="reg_form_wrap">
            <form id="forgetPasswordForm" action='' onsubmit='return false' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'simple_bottom'}">
                <div class="reg_form_inner_wrap">
                    <div class="reg_line_wrap">
                        <span class="reg_title"><{t}>logoinType<{/t}><i>*</i></span>
                        <span class="reg_input">
                            <label><input type="radio" name="data[visitor_type]" value="1" <{if $visitor_type == 1}>checked="checked"<{/if}> /><{t}>buyer<{/t}></label>
                            <label><input type="radio" name="data[visitor_type]" value="2" <{if $visitor_type == 2}>checked="checked"<{/if}>/><{t}>seller<{/t}></label>
                        </span>
                        <span class="notice"><{t}>forgetSelectType<{/t}></span>
                    </div>
                    <div class="reg_line_wrap">
                        <span class="reg_title"><{t}>userCode<{/t}><i>*</i></span>
                        <span class="reg_input input_wrap"><input type="text" class="text-input" data-rule="<{t}>userCode<{/t}>:required;" id="accountCode" name="data[accountCode]" /></span>
                        <span class="notice"><{t}>regCode<{/t}></span>
                    </div>
                    <div class="reg_line_wrap">
                        <span class="reg_title"><{t}>Email<{/t}><i>*</i></span>
                        <span class="reg_input input_wrap"><input type="text" class="text-input" data-rule="<{t}>Email<{/t}>:required;email" id="email" name="data[email]" /></span>
                        <span class="notice"><{t}>regEmail<{/t}></span>
                    </div>
                    <div class="reg_line_wrap cl">
                        <span class="reg_title leftloat"><{t}>VerifyCode<{/t}><i>*</i></span>
                        <span class="reg_input verify_input input_wrap leftloat">
                            <input type="text" id="verify" name="data[verify]" style="text-transform:uppercase;" />
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
    </div>
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
                url: '/forget-password/confirm-user',
                success: function(json) {
                    //console.log(json);
                    var html = '';
                    if(json.state == '1'){
                        alertTip(json.message, 3);
                        // var gotoURL ='window.location.href="/forget-password/step?current=2&visitor_type='+json.visitor_type+'"';
                        // var t = setTimeout(gotoURL, 1000);
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