<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title><{t}>logoinType<{/t}></title>
    <link href="/etp_style_v1.0/css/base.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/style.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/sample.css" rel="stylesheet" type="text/css" />
    <link href="/etp_style_v1.0/css/member.css" rel="stylesheet" type="text/css" />
</head>
<body>
<{include file="default/views/default/header-menu-inner.tpl"}>
<!--banner-->
<div class="in_bannerContainer">
    <!--<a class="prev duration none"></a>-->
    <!--<a class="next duration none"></a>-->
    <div class="bannerWrap">
        <div class="bannerWidth">
            <div class="btnBox clearfix">
                <a href="/login/login?visitor_type=1" class="btn btn1"><{t}>iamBuyer<{/t}></a>
                <a href="/login/login?visitor_type=2" class="btn btn2"><{t}>iamSeller<{/t}></a>
                <a href="/register" class="btn btn3"><{t}>regNow<{/t}></a>
            </div>
        </div>
    </div>
    <div class="bannerItem">
        <{if $language == 'zh_CN'}>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/banner01.jpg') no-repeat scroll center top transparent;" target="_blank"></a>
        <{else}>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/banner01_en.jpg') no-repeat scroll center top transparent;" target="_blank"></a>
        <{/if}>
    </div>
    <div class="bannerItem">
        <{if $language == 'zh_CN'}>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/banner02.jpg') no-repeat scroll center top transparent;" target="_blank"></a>
        <{else}>
            <a href="javascript:" style="background: url('/etp_style_v1.0/images/banner/banner02_en.jpg') no-repeat scroll center top transparent;" target="_blank"></a>
        <{/if}>
    </div>
    <div class="banner_pagination none">
        <span class="btn_index current"></span>
        <span class="btn_index"></span>
    </div>
    <style type="text/css">
        .m_footerContainer { position: absolute; bottom: 0px; background: rgba(0, 0, 0, 0.6); z-index: 9999; }
    </style>
    <{include file="default/views/default/footer-menu-inner.tpl"}>
</div>
<!--注意：有两种不同风格的头部和尾部，注意其标签-->
<script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="/etp_style_v1.0/js/util.js" type="text/javascript"></script>
<script src="/etp_style_v1.0/js/common.new.js" type="text/javascript"></script>
<script type="text/javascript">
    new Banner({
        bannerBox: $('.in_bannerContainer'),
        banner: $('.bannerItem'),
        indexBtn: $('.btn_index'),
        indexBtnCurrent: 'current',
        autoPlay: true,
        autoPlayTime: 4000,
        scrollSpeed: 1000
        //bgColorSwicth: true,
        //bgColorArr:bannerColors,//背景色
        //bgColorSpeed: 500
    });
</script>
</body>
</html>