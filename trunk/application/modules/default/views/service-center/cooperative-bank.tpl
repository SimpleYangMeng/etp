<link href="/etp_style_v1.0/css/style.css" rel="stylesheet" type="text/css" />
<div class="aboutContainer">
    <div class="min_width clearfix">
        <div class="col-leftMenu f_left">
            <!-- 第一项标题border-top: none-->
            <div class="dl">
                <{if $language == 'zh_CN'}>
                <li class="li"><a href="/help/guide?visitor_type=2">供应商操作指南 <i class="icon"></i></a></li>
                <li class="li"><a href="/help/guide?visitor_type=1"> 采购商操作指南<i class="icon"></i></a></li>
                <{/if}>
                <li class="li"><a href="/help/question"><{t}>CommonProblem<{/t}><i class="icon"></i></a></li>
                <li class="li active"><a href="/help/cooperative-bank"> <{t}>coopBank<{/t}> <i class="icon"></i></a></li>
                <li class="li"><a href="/help/about-us"> <{t}>aboutUs<{/t}> <i class="icon"></i></a></li>
            </div>
        </div>
        <div class="col-rightArea rightArea f_right">
            <!-- 右边分2块的情况-->
            <div class="topTit">
                <p class="tit"><{t}>coopBank<{/t}></p>
            </div>
            <div class="bottomCon">
                <div class="bankList">
                    <{if $language == 'zh_CN'}>
                        <p class="margin_top25">
                            <img src="/etp_style_v1.0/images/bank_logo1.jpg" alt="" width="204" height="37"/>
                        </p>
                        <p class="margin_top15">
                            <{t}>pinganP1<{/t}>
                        </p>
                        <p class="margin_top15">
                            <{t}>pinganP2<{/t}>
                        </p>
                        <p class="margin_top65">
                            <img src="/etp_style_v1.0/images/bank_logo2.jpg" alt="" width="204" height="49"/>
                        </p>
                        <p class="margin_top15">
                            <{t}>zadaP1<{/t}>
                        </p>
                        <p class="margin_top15">
                            <{t}>zadaP2<{/t}>
                        </p>
                        <p class="margin_top15">
                            <{t}>zadaP3<{/t}>
                        </p>
                    <{else}>
                        <p class="margin_top25">
                            <img src="/etp_style_v1.0/images/bank_logo2_en.jpg" alt=""/>
                        </p>
                        <p class="margin_top15">
                            <{t}>zadaP1<{/t}>
                        </p>
                        <p class="margin_top15">
                            <{t}>zadaP2<{/t}>
                        </p>
                        <p class="margin_top15">
                            <{t}>zadaP3<{/t}>
                        </p>
                        <p class="margin_top65">
                            <img src="/etp_style_v1.0/images/bank_logo1_en.jpg" alt=""/>
                        </p>
                        <p class="margin_top15">
                            <{t}>pinganP1<{/t}>
                        </p>
                        <p class="margin_top15">
                            <{t}>pinganP2<{/t}>
                        </p>
                    <{/if}>
                </div>
            </div>
     </div>
</div>
</div>