<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>
<style type="text/css">
    <{if $language == 'en_US'}>
    .m_colContainer .col-r .form_item .{ width: 190px; }
    <{else}>
    .m_colContainer .col-r .form_item .{ width: 120px; }
    <{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>appSettlement<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="cashForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="totalAmount" value="<{$cBalance}>" />
            <div class="form_item clearfix">
                <span class="tit f_left <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_300_en_US<{/if}>"><{t}>settlingValue<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">&nbsp;</em></span>
                <div class="dl f_left clearfix">
                    <span class="f16 red_e83d2c balance"><{$currency['currency_code']}> <{$cBalance}></span>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_300_en_US<{/if}>"><{t}>needsettlingValue<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" id='needsettlement'  class="input288" name="data[needsettlingValue]" data-rule="<{t}>amount<{/t}>:required;<{t}>needsettlingValue<{/t}>:zhengshu" data-rule-amount="[/^(([1-9]\d{0,9})|0)(\.\d{1,4})?$/, '<{t}>wrongFormat<{/t}>']" data-tip=""/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_300_en_US<{/if}>"><{t}>nowRate<{/t}><{t}>colon<{/t}></span>
                <div class="dl f_left clearfix">
                    <span><{$currency['currency_rate']}> (<{t}>rateUSDToCNY<{/t}>)</span>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_300_en_US<{/if}>"><{t}>processingFee<{/t}><{t}>colon<{/t}></span>
                <div class="dl f_left clearfix">
                    <span id="processingFee" class="tipfee"></span>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_300_en_US<{/if}>">&nbsp;</span>
                <p class="dl f_left clearfix">
                    <button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<{t}>submiting<{/t}>"><{t}>submit<{/t}></button>
                </p>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left <{if $language=='zh_CN'}>tit_120_zh_CN<{else}>tit_300_en_US<{/if}>">&nbsp;</span>
                <p class="dl f_left clearfix">
                    <span id="noticeWrap"></span>
                </p>
            </div>

        </form>
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
    $(function() {
        $('#needsettlement').on('blur',function(){
            var jxvalue = $('#needsettlement').val();
            var sxf = jxvalue*0.007;
            $('#processingFee').html(sxf.toFixed(4));
        });



        var submit = $('.submit');
        //表单验证
        $('#cashForm').validator({
            valid: function() {
                submit.button('loading');
                submit.addClass('disabled');
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#cashForm').serialize(),
                    url: '/seller/settlement/settlement',
                    success: function(json) {
                        if (json.state == '1') {
                            $('.balance').html('$'+json.balance);
                            $('#processingFee').html('');
                            alertTip(json.message, 3);
                            $('#cashForm')[0].reset();
                        } else {
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
                        }
                        submit.button('reset');
                        submit.removeClass('disabled');
                    }
                });
            }
        });
    });
</script>