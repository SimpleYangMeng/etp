<div class="min_width">
    <div class="priv_title_content"><{t}>ETP<{/t}><span class="pipe">|</span>收银台</div>
    <div class="order_content cl">
        <p class="order_title"><{t}>orderDetail<{/t}></p>
        <{include file="buyer/views/order/order_base_detail.tpl"}>
        <{if $return.state == 1}>
            <{if $isLogin}>
                <div class="order_pay_login_wrap">
                    <p class="order_title"><{t}>payNow<{/t}></p>
                </div>
                <div class="bottom">
                    <div class="form_group clearfix">
                        <form id="payOrderForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                            <input type="hidden" name="orderId" value="<{$return.data.order_id}>" />
                            <div class="form_item margin_top20 clearfix">
                                <span class="tit f_left" style="width: 150px"><{t}>payPwd<{/t}>：<em class="blue_00a0e9">*</em></span>
                                <div class="dl f_left clearfix">
                                    <input type="password" name="payPwd" class="input" data-tip="<{t}>payPwd<{/t}>" data-rule="<{t}>payPwd<{/t}>:required;length(6~16)"/>
                                </div>
                            </div>
                            <div class="form_item margin_top20 clearfix">
                                <span class="tit f_left" style="width: 150px">&nbsp;</span>
                                <p class="f_left" style="padding-left: 12px;">
                                    <button type="submit" class="btn btn-primary btn-check submit" id="passwordTip" data-toggle="tooltip" data-trigger="hover" data-placement="right" title="<{t}>payNotice<{/t}>"><{t}>Confirm<{/t}><{t}>submit<{/t}></button>
                                </p>
                            </div>
                            <div class="form_item margin_top10 clearfix">
                                <span class="tit f_left" style="width: 150px">&nbsp;</span>
                                <div class="f_left" id="noticeWrap"></div>
                            </div>
                        </form>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function (){
                        $('#passwordTip').tooltip();
                        var submit = $('.submit');
                        //表单验证
                        $('#payOrderForm').validator({
                            //验证原始密码
                            fields: {
                                'payPwd': "<{t}>payPwd<{/t}>:required;length(6~16);remote[/buyer/account/check-pwd, payPwd]"
                            },
                            valid: function() {
                                submit.showLoading({addClass:'loading-indicator-circle-1'});
                                submit.addClass('disabled');
                                $.ajax({
                                    type: "POST",
                                    async: false,
                                    dataType: "json",
                                    data: $('#payOrderForm').serialize(),
                                    url: '/buyer/order/pay-order-submit',
                                    success: function(json) {
                                        if (json.state == '1') {
                                            alertTip(json.message, 3);
                                            var gotoURL = 'window.location.href=" ' + json.backUrl + ' "';
                                            setTimeout(gotoURL, 2000);
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
            <{else}>
                <style type="text/css">
                    .in_bannerContainer { height: 380px;}
                    .in_bannerContainer .bannerWrap,.in_bannerContainer .bannerWrap .bannerWidth { height: 360px; }
                    .in_bannerContainer .loginBox { top: 20px; right: 210px; }
                    .in_bannerContainer .loginBox .box .inputBox .input { height: 32px; }
                    .in_bannerContainer .noticeBox { position: absolute; top: 20px; left: 100px; height: 340px; border-right: 1px dashed #CCC; padding-right: 60px; padding-top: 120px;}
                    .in_bannerContainer .noticeBox .slogan { padding-left: 24px; margin-top: 14px;}
                </style>
                <div class="order_pay_login_wrap">
                    <p class="order_title"><{t}>loginEtpPay<{/t}></p>
                </div>
                <div class="in_bannerContainer">
                    <div class="bannerWrap">
                        <div class="bannerWidth">
                            <div class="noticeBox clearfix">
                                <p class="pay_logo"><img src="/etp_style_v1.0/images/logo.jpg" /></p>
                                <p class="slogan"><img src="/etp_style_v1.0/images/slogan.jpg" /></p>
                            </div>
                            <div class="loginBox clearfix">
                                <div class="layer"></div>
                                <div class="box">
                                    <form id="loginForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                                        <input type="hidden" name="callBackUrl" value="<{$callBackUrl}>" />
                                        <input type="hidden" name="visitor_type" value="1" />
                                        <p class="text_align_c"><i class="logo"></i></p>
                                        <div class="inputBox clearfix margin_top25">
                                            <p class="tit">
                                                <i class="icon user"></i>
                                            </p>
                                            <input  class="input" type="text" name="username" data-rule="<{t}>userCode<{/t}>:required" />
                                        </div>
                                        <div class="inputBox clearfix margin_top20">
                                            <p class="tit">
                                                <i class="icon pwd"></i>
                                            </p>
                                            <input class="input" type="password" name="password" data-rule="<{t}>userPass<{/t}>:required;length(6~16)"/>
                                        </div>
                                        <p class="f12 margin_top15"><a href="javascript:" class="white_link"><{t}>forgetPassword<{/t}></a></p>
                                        <!-- 错误提示信息地方 可以根据需要自行选择。默认是hidden，加error后visible。不是用的display: none,用的Visbiblity属性，隐藏后还占据高度。-->
                                        <p class="tip red_e83d2c margin_top10" id="errorMsg" style="overflow: hidden;"></p>
                                        <!--如果采用上述tip错误提示，那么这里的margin_top30改为margin_top15即可。-->
                                        <p class="margin_top10">
                                            <!--<a href="javascript:" class="submit">登 录</a>-->
                                            <input  class="submit" type="submit" value="<{t}>login<{/t}>" style="padding: 6px 12px;" id="submitBtn">
                                        </p>
                                        <p class="white_text margin_top10">
                                            <{t}>NoUserRegLink<{/t}> <a href="/default/register/index/" class="blue_link"><{t}>regNow<{/t}></a>
                                        </p>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $('#loginForm').validator({
                        valid: function (){
                            $.ajax({
                                url:"/login/check",
                                data:$('#loginForm').serialize(),
                                type:'POST',
                                dataType:"json",
                                success:function(json){
                                    if(typeof(json.authcodeError) != 'undefined' && json.authcodeError == 1){
                                        $(".verifyChange").click();
                                    }
                                    if(json.state == "1"){
                                        //console.log(json);
                                        if(json.callback == '1'){
                                            window.location.href =  json.callbackurl;
                                        }else {
                                            window.location.href = json.jumpToUrl;
                                        }
                                    }else if(json.state == "-1"){
                                        window.location.href='/register/step?current='+ json.current +'&visitor_type='+json.visitor_type;
                                    }else{
                                        $('input[name=password]').val('');
                                        $('input[name=verify]').val('');
                                        $(".verifyChange").click();
                                        $('#errorMsg').addClass('error');
                                        $("#errorMsg").html('<span class="error">'+json.errorMsg+'</span>');
                                    }
                                }
                            });
                        }
                    });
                </script>
            <{/if}>
        <{/if}>
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
</script>