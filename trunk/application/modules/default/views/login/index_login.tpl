<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><{if $visitor_type == 1 }><{t}>buyer<{/t}><{else}><{t}>seller<{/t}><{/if}>&nbsp;<{t}>login_in<{/t}></title>
    <link href="/etp_style_v1.0/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/sample.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/member.css" rel="stylesheet" type="text/css" />
    <!-- nice-validator -->
    <script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css">
    <script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
</head>
<body>
<{include file="default/views/default/header-menu-inner.tpl"}>
<!--banner-->
<div class="in_bannerContainer">
    <!--<a class="prev duration none"></a>-->
    <!--<a class="next duration none"></a>-->
    <div class="bannerWrap">
        <div class="bannerWidth">
            <div class="loginBox clearfix">
                <div class="layer"></div>
                <div class="box">
                    <form id="loginForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
                        <input type="hidden" name="visitor_type" value="<{$visitor_type}>" />
                        <p class="text_align_c">
                            <{if $language == 'zh_CN'}>
                                <i class="logo" style="width: 225px;background: url('/etp_style_v1.0/images/m_icon.png') no-repeat -104px -5px;"></i>
                            <{else}>
                                <i class="logo" style="width: 255px;background: url('/etp_style_v1.0/images/m_icon.png') no-repeat -104px -315px;"></i>
                            <{/if}>
                        </p>
                        <div class="inputBox clearfix margin_top25">
                            <p class="tit">
                                <i class="icon user"></i>
                            </p>
                            <input  class="input" type="text" name="username" data-rule="<{t}>userCode<{/t}>/<{t}>Email<{/t}>:required" placeholder="<{t}>userCode<{/t}>/<{t}>Email<{/t}>"/>
                        </div>
                        <div class="inputBox clearfix margin_top20">
                            <p class="tit">
                                <i class="icon pwd"></i>
                            </p>
                            <input class="input" type="password" name="password" data-rule="<{t}>userPass<{/t}>:required;" placeholder="<{t}>password<{/t}>"/>
                        </div>
                        <p class="f12 margin_top15"><a href="/forget-password?visitor_type=<{$visitor_type}>" class="white_link"><{t}>forgetPassword<{/t}></a></p>
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
    <div class="bannerItem">
        <{if $language == 'zh_CN'}>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/<{if $visitor_type == 1 }>banner03.jpg<{else}>banner04.jpg<{/if}>') no-repeat scroll center top transparent; background-size: cover;" target="_blank"></a>
        <{else}>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/<{if $visitor_type == 1 }>banner05.jpg<{else}>banner06.jpg<{/if}>') no-repeat scroll center top transparent; background-size: cover;" target="_blank"></a>
        <{/if}>
    </div>
    <style type="text/css">
        .m_footerContainer { position: absolute; bottom: 0px; background: rgba(0, 0, 0, 0.6); z-index: 9999; }
    </style>
    <{include file="default/views/default/footer-menu-inner.tpl"}>
</div>
<!--注意：有两种不同风格的头部和尾部，注意其标签-->
<script type="text/javascript" language="javascript">
$(function(){
    $(".verifyChange").click(function(){
        $('#verifyImg').attr("src","/register/verify-code?"+Math.random());
    });
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
});
</script>
</body>
</html>