<link href="/etp_style_v1.0/css/style.css" rel="stylesheet" type="text/css" />
<div class="aboutContainer">
    <div class="min_width clearfix">
        <div class="col-leftMenu f_left">
            <!-- 第一项标题border-top: none-->
            <div class="dl">
                <li class="li <{if $visitor_type == 2}>active<{/if}>"><a href="/help/guide?visitor_type=2">卖家操作指南 <i class="icon"></i></a></li>
                <li class="li <{if $visitor_type == 1}>active<{/if}>"><a href="/help/guide?visitor_type=1">买家操作指南<i class="icon"></i></a></li>
                <li class="li"><a href="/help/question">常见问题<i class="icon"></i></a></li>
                <li class="li"><a href="/help/cooperative-bank"> 合作银行 <i class="icon"></i></a></li>
                <li class="li"><a href="/help/about-us"> 关于我们 <i class="icon"></i></a></li>
            </div>
        </div>
        <div class="col-rightArea rightArea f_right">
            <!-- 右边分2块的情况-->
            <div class="topTit">
                <p class="tit"><{if $visitor_type == 1}>采购商操作指南<{else}>供应商操作指南<{/if}></p>
            </div>
            <div class="bottomCon">
                <div class="guide">
                    <{if $visitor_type == 1}>
                        <{include file="default/views/service-center/buyer.tpl"}>
                    <{else}>
                        <{include file="default/views/service-center/seller.tpl"}>
                    <{/if}>
                </div>
            </div>
     </div>
</div>
</div>