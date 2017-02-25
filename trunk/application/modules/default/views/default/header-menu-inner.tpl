<!-- 引入语言包 -->
<script src="/js/jquery-1.8.3.min.js" type="text/javascript"></script>
<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>
<!-- header begin -->
<div class="in_topContainer">
    <div class="min_width clearfix">
        <p class="f_right">
            <a class="link" href="/"><{t}>homePage<{/t}></a>
            <span class="span">|</span>
            <a href="/help/question" class="link"><{t}>CommonProblem<{/t}></a>
            <span class="span">|</span>
            <a href="/help/about-us" class="link"><{t}>AboutUs<{/t}></a>
            <span class="span">|</span>
            <{if $language == 'zh_CN'}>
            <a href="/default/index/change-language?lang=en_US" class="link">
                English Site(英文版)
            </a>
            <{else}>
            <a href="/default/index/change-language?lang=zh_CN" class="link">
                Chinese Site(中文版)
            </a>
            <{/if}>
        </p>
    </div>
</div>
<div class="in_headerContainer" style="background: #FFFFFF;">
    <!--
    <div class="min_width clearfix">
        <a href="/" class="logo f_left">
            <img src="/etp_style_v1.0/images/logo.png" alt="logo" width="220" height="35"/>
        </a>
        <p class="slogan f_right">
            <{if $language == 'zh_CN'}>
                <img src="/etp_style_v1.0/images/slogan.png" width="170" height="22"/>
            <{else}>
                <img src="/etp_style_v1.0/images/slogan_en.png"/>
            <{/if}>
        </p>
    </div>
    -->
    <div class="min_width clearfix">
        <a href="/" class="logo f_left">
            <img src="/etp_style_v1.0/images/logo.jpg" alt="logo" width="220" height="35"/>
        </a>
        <p class="slogan f_left">
            <{if $language == 'zh_CN'}>
                <img src="/etp_style_v1.0/images/slogan.jpg" width="170" height="22"/>
            <{else}>
                <img src="/etp_style_v1.0/images/slogan_en.jpg"/>
            <{/if}>
        </p>
    </div>
</div>
<!--header end -->