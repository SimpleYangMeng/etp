<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>
<style type="text/css">
<{if $language == 'en_US'}>
.m_colContainer .col-r .form_item .tit { width: 190px; }
<{else}>
.m_colContainer .col-r .form_item .tit { width: 120px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>localWithdraw<{/t}></p>
    <p class="f15 gray_919191 margin_top30" style="padding-left: 60px"><{t}>localAccountBalance<{/t}>：</span></p>
    <p class="line margin_top8"></p>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="cashForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left"><{t}>bankName<{/t}>：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <select id="bankNo" name="bankNo" data-rule="银行账号:required;" data-tip="">
                    <{foreach from=$bankCard key=key item=item}>
                    <option value="<{$item.bank_card_id}>"><{$item.bank_name}> 尾号<{$item.bank_card_no|substr:-4}></option>
                    <{/foreach}>
                    </select>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><{t}>bankCardName<{/t}>：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[bank_buyer_name]" data-rule="<{t}>bankCardName<{/t}>:required;" data-tip=""/>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left"><{t}>bankCardNum<{/t}>：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[bank_card]" data-rule="<{t}>bankCardNum<{/t}>:required;" data-tip=""/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><{t}>cashAmount<{/t}>：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[amount]" data-rule="<{t}>cashAmount<{/t}>:required;amount;match[lte, totalAmount];" data-rule-amount="[/^(([1-9]\d{0,9})|0)(\.\d{1,4})?$/, '格式错误(Format error)']" data-tip=""/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left"><{t}>remark<{/t}>：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <textarea name="data[note]" id="note" cols="30" rows="10" class="textBox" data-rule="<{t}>remark<{/t}>:required;" data-tip=""></textarea>
                </div>
            </div>
            <div class="form_item  clearfix" style="margin-top: 50px">
                <span class="tit f_left">&nbsp;</span>
                <p class="f_left">
                    <!--<input  class="submit" type="submit" value="<{t}>Confirm<{/t}><{t}>submit<{/t}>" id="submitBtn" />-->
                    &nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<{t}>submiting<{/t}>"><{t}>Confirm<{/t}><{t}>submit<{/t}></button>
                </p>
            </div>
            <div class="form_item clearfix">
                <div class="dl">
                    <div id="noticeWrap"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(function() {
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
                url: '/portal/purchaser/cash-submit',
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
                    submit.button('reset');
                    submit.removeClass('disabled');
                }
            });
        }
    });
});
</script>