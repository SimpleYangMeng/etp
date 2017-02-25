<script type="text/javascript">
    function alertTip(tip, reloadinfo) {
        var reloadinfo = reloadinfo || 1;
        if (reloadinfo == 1) {
            $('#noticeWrap').empty();
        }
        if (reloadinfo == 3) {
            $('#noticeWrap').empty();
            $('<span class="success">' + tip + '</span>').appendTo($('#noticeWrap').show());
        } else if(reloadinfo == 4){
            $('#noticeWrap').empty();
            $('#noticeWrap').html(tip);
        } else{
            $('<span class="error">' + tip + '</span>').appendTo($('#noticeWrap').show());
        }
    }
    $(function() {
        $('.submitBtn').click(function() {
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: $('#completeForm').serialize(),
                url: '/buyer/charge/zdrecharge',
                success: function(json) {
                    var html = '';
                    if (json.state == '1') {
                        alertTip(json.message, 3);
                        setTimeout('window.location.href="/buyer/charge/recharge-list"', 2000);
                    }else if (json.state == '-1') {
                        alertTip(json.message, 2);
                        setTimeout('window.location.href="/login"', 2000);
                    } else {
                        html += json.message;
                        $.each(json.error,function(k,v){
                            html+='<span class="error">'+ v.errorMsg+'</span>';
                        });
                        alertTip(html,4);
                        //alertTip(html);
                    }
                }
            });
        });
    });
</script>
<div class="top clearfix">
    <p class="dt"><{t}>rechargeApplication<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<!--买家充值页面-->
<div class="bottom">
    <div class="form_group clearfix margin_left20 margin_top10">
        <div class="topTit">
            <p class="tit"><{t}>rechargeNote<{/t}></p>
        </div>
        <div class="bottomCon">
            <div class="faqList">
                <div class="dl">
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            供应商注册需提交资料有哪些？是否保证证照有效性？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            填写企业名称、联系人、联系电话、联系电子邮箱、交易币种等信息上传营业执照、法定代表人身份证影印件
                        </p>
                    </div>
                    <!-- -->
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            卖家国内收款账号必须是对公账号？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            是的，必须是对公账号。
                        </p>
                    </div>
                    <!-- -->
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            卖家提现银行账号，可以录入几个？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            填写企业名称、联系人、联系电话、联系电子邮箱、交易币种等信息上传营业执照、法定代表人身份证影印件
                        </p>
                    </div>
                    <!-- -->
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            境外卖家提现时效？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            填写企业名称、联系人、联系电话、联系电子邮箱、交易币种等信息上传营业执照、法定代表人身份证影印件
                        </p>
                    </div>
                    <!-- -->
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            采购商注册需提交资料有哪些？保证证照有效性？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            填写企业名称、联系人、联系电话、联系电子邮箱、交易币种等信息上传营业执照、法定代表人身份证影印件
                        </p>
                    </div>
                    <!-- -->
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            买家充值账户有哪几种方式？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            充值方式有两种，平安NRA、渣打。
                        </p>
                    </div>
                    <!-- -->
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            买家账户满足什么条件才能充值？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            完成填写资料，并通过后台审核，状态为已审核的采购商账户才可进行账号充值。
                        </p>
                    </div>
                    <!-- -->
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            币种是如何确定的？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            ETP平台上采购商与供应商的账户显示为美金；境外充值为美元，境内提现为人民币
                        </p>
                    </div>
                    <!-- -->
                    <div class="q clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            ETP平台上的美元汇率如何更新？
                        </p>
                    </div>
                    <div class="a clearfix">
                        <i class="icon f_left"></i>
                        <p class="f_left p">
                            一天维护一次汇率（维护方式）
                        </p>
                    </div>
                    <!-- -->
                </div>
            </div>
        </div>

        <div class="form_item  clearfix" style="margin-top: 50px">
            <span class="tit width120 f_left">&nbsp;</span>
            <p class="f_left">
                <a href="javascript:" id="rechargeApply" class="f_left blue_btn f16 blue_btn_h_32 margin_left10 blue_btn submitBtn">提交申请</a>
            </p>
        </div>
        <div class="form_item margin_top45 clearfix">
            <span class="tit width240 f_left" style="width: 150px">&nbsp;</span>
            <div class="f_left" id="noticeWrap"></div>
        </div>
    </div>
    <!-- -->
</div>