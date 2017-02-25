<script type="text/javascript">
$(function() {
    $("#rechargeApply").bind('click',function(){
        var rechargeType = $('#rechargeType').val();
        switch (rechargeType){
            case '1':
                window.location.href='/buyer/charge/parecharge';
                break;
            case '3':
                window.location.href='/buyer/charge/zdrecharge';
                break;
        }
    });
    $('#rechargeType').change(function (){
        $('.hideClass').hide();
        switch($(this).val()) {
            //平安
            case '1':
                $('#rechargeApply').show();
                //$('#paNotice').show();
                break;
            //渣打
            case '3':
                $('#rechargeApply').hide();
                //$('#zdNotice').show();
                break;
        }
    });
});
</script>
<!--买家充值页面-->
<div class="top cl">
    <p class="dt"><{t}>rechargeApplication<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="form_group cl">
        <div class="form_item margin_top45 cl">
            <span class="tit f_left" style="width: 150px;"><{t}>rechargeType<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left cl">
                <p class="f_left">
                <select name="rechargeType" id="rechargeType" class="selBox">
                    <option value="1"><{t}>rechargePA<{/t}></option>
                    <option value="3"><{t}>rechargeZD<{/t}></option>
                </select>
                </p>
                <p class="f_left">
                    <a href="javascript:" id="rechargeApply" class="f_left blue_btn f16 blue_btn_h_32 margin_left10"><{t}>submitApplication<{/t}></a>
                </p>
            </div>
        </div>
        <div class="form_item margin_left30 noticeContent cl">
            <!--
            <div id="paNotice" class="commonContent hideClass">
                <p class="title"><{t}>rechargeNote<{/t}></p>
                <p>平安充值注意事项…</p>
            </div>
            -->
            <div id="zdNotice" class="commonContent">
                <p class="title"><{t}>rechargeNote<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ1<{/t}></p>
                <p class="n_a"><{t}>czNoticeA1<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ9<{/t}></p>
                <p class="n_a"><{t}>czNoticeA9<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ2<{/t}></p>
                <p class="n_a"><{t}>czNoticeA2<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ3<{/t}></p>
                <p class="n_a"><{t}>czNoticeA3<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ4<{/t}></p>
                <p class="n_a"><{t}>czNoticeA4<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ5<{/t}></p>
                <p class="n_a"><{t}>czNoticeA5<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ6<{/t}></p>
                <p class="n_a"><{t}>czNoticeA6<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ7<{/t}></p>
                <p class="n_a"><{t}>czNoticeA7<{/t}></p>
                <p class="n_q"><{t}>czNoticeQ8<{/t}></p>
                <p class="n_a"><{t}>czNoticeA8<{/t}></p>
            </div>
        </div>
    </div>
</div>