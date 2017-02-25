<script type="text/javascript">
    $(function() {
        $("#rechargeApply").bind('click',function(){
            var rechargeType = $('#rechargeType').val();
            switch (rechargeType){
                case '1':
                    window.location.href='/portal/purchaser-charge/parecharge';
                    break;
                case '3':
                    window.location.href='/portal/purchaser-charge/zdrecharge';
                    break;
            }
        });
    });
</script>
<!--买家充值页面-->
<div class="bottom">
    <div class="form_group clearfix">
        <div class="form_item margin_top45 clearfix">
            <span class="tit width120 f_left"><{t}>rechargeType<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left clearfix">
                <select name="rechargeType" id="rechargeType" class="selBox">
                    <option value="1"><{t}>rechargePA<{/t}></option>
                    <option value="3"><{t}>rechargeZD<{/t}></option>
                </select>
            </div>
            <p class="tip f_left error">

            </p>
        </div>

        <div class="form_item  clearfix" style="margin-top: 50px">
            <span class="tit width120 f_left">&nbsp;</span>
            <p class="f_left">
                <a href="javascript:" id="rechargeApply" class="f_left blue_btn f16 blue_btn_h_32 margin_left10">提交申请</a>
            </p>
        </div>
    </div>
    <!-- -->
</div>