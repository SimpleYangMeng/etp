<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>
<style type="text/css">
<{if $languageTpl == 'en_US'}>
.m_colContainer .col-r .form_item .tit { width: 190px; }
<{else}>
.m_colContainer .col-r .form_item .tit { width: 120px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>cashRequest<{/t}></p>
    <div class="t_w2 border_b_line"></div>
    <div class="margin_left60 margin_top20">
        <p class="f15"><{t}>overseasAmount<{/t}>：&nbsp;&nbsp;<{$currency}>&nbsp;&nbsp;<span class="f16 red_e83d2c"><{$cBalance}></span></p>
        <p class="margin_top5 gray_919191"><{t}>foreignWithdrawTip1<{/t}></p>
        <p class="margin_top5 gray_919191"><{t}>foreignWithdrawTip2<{/t}></p>
        <p class="margin_top5 gray_919191"><{t}>foreignWithdrawTip3<{/t}></p>
    </div>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="cashForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="totalAmount" value="<{$cBalance}>" />
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left"><{t}>bankName<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[bank_name]" data-rule="<{t}>bankName<{/t}>:required;" data-tip=""/>
                </div>
                <!--
                <p class="tip f_left error">
                    错误提示
                </p>
                -->
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><{t}>bankLocation<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <!--<input type="text" class="input" name="bank_buyer_name" data-rule="<{t}>bankCardName<{/t}>:required;" data-tip=""/>-->
                    <select name="data[country_id]" id="" class="selBox" style="min-width: 80px;max-width: 245px;" data-rule="<{t}>bankLocation<{/t}>:required;">
                        <{foreach from=$country key=key item=item}>
                            <option value="<{$item['country_id']}>" <{if $item['country_code'] == 'US'}>selected="selected"<{/if}>><{$item['country_code']}>-<{if $languageTpl == 'zh_CN'}><{$item['country_name']}><{else}><{$item['country_name_en']}><{/if}></option>
                        <{/foreach}>
                    </select>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><{t}>bankCardName<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[bank_buyer_name]" data-rule="<{t}>bankCardName<{/t}>:required;" data-tip=""/>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left"><{t}>bankCardNum<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[bank_card]" data-rule="<{t}>bankCardNum<{/t}>:required;" data-tip=""/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><{t}>cashAmount<{/t}><{t}>colon<{/t}><em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[amount]" data-rule="<{t}>cashAmount<{/t}>:required;amount;match[lte, totalAmount];" data-rule-amount="[/^(([1-9]\d{0,9})|0)(\.\d{1,4})?$/, '<{t}>wrongFormat<{/t}>']" data-tip=""/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><{t}>remark<{/t}><{t}>colon<{/t}>&nbsp;</span>
                <div class="dl f_left clearfix">
                    <textarea name="data[note]" id="note" cols="30" rows="10" class="textBox" data-tip=""></textarea>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left">&nbsp;</span>
                <p class="dl f_left clearfix">
                    <!--<input  class="submit" type="submit" value="<{t}>Confirm<{/t}><{t}>submit<{/t}>" id="submitBtn" />-->
                    <button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<{t}>submiting<{/t}>"><{t}>submit<{/t}></button>
                </p>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">&nbsp;</span>
                <div class="dl f_left clearfix">
                    <div id="noticeWrap"></div>
                </div>
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
    var submit = $('.submit');
    //表单验证
    $('#cashForm').validator({
        valid: function() {
            submit.showLoading({addClass:'loading-indicator-circle-1'});
            submit.addClass('disabled');
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: $('#cashForm').serialize(),
                url: '/buyer/withdraw/cash-submit',
                success: function(json) {
                    if (json.state == '1') {
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
                    submit.hideLoading();
                    submit.removeClass('disabled');
                }
            });
        }
    });
});
</script>