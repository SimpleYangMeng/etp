<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>
<div class="top clearfix">
    <p class="dt"><{t}>orderDetail<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="table border order_detail">
        <{include file="buyer/views/order/order_base_detail.tpl"}>
    </div>
</div>
<{if $return.state == 1}>
<div class="top clearfix" style="margin-top: 40px;">
    <p class="dt"><{t}>payNow<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="payOrderForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="orderId" value="<{$return.data.order_id}>" />
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left" style="width: 150px"><{t}>payCurrency<{/t}>：</span>
                <div class="dl f_left clearfix">
                    <{$return.data.order_currency}>
                </div>
            </div>
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left" style="width: 150px"><{t}>orderPayAmount<{/t}>：</span>
                <div class="dl f_left clearfix">
                    <{$return.data.order_amount}>
                </div>
            </div>
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left" style="width: 150px"><{t}>payPwd<{/t}>：<!--<em class="blue_00a0e9">*</em>--></span>
                <div class="dl f_left clearfix">
                    <input type="password" name="payPwd" class="input" data-tip="<{t}>payPwd<{/t}>" data-rule="<{t}>payPwd<{/t}>:required;length(6~16)"/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left" style="width: 150px">&nbsp;</span>
                <p class="f_left" style="padding-left: 12px;">
                    <button type="submit" class="btn btn-primary btn-check submit" id="password_tip" data-toggle="tooltip" data-trigger="hover" data-placement="right" title="<{t}>payNotice<{/t}>"><{t}>Confirm<{/t}></button>
                </p>
            </div>
            <div class="form_item margin_top10 clearfix">
                <span class="tit f_left" style="width: 150px">&nbsp;</span>
                <div class="f_left" id="noticeWrap"></div>
            </div>
        </form>
    </div>
</div>
<{/if}>
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
    $(function (){
        $('#password_tip').tooltip();
        var submit = $('.submit');
        //表单验证
        $('#payOrderForm').validator({
            //验证原始密码
            fields: {
                'payPwd': "<{t}>payPwd<{/t}>:required;length(6~16);remote[/buyer/order/check-pay-pwd, payPwd, orderId]"
            },
            valid: function() {
                submit.showLoading({addClass:'loading-indicator-circle-1'});
                submit.addClass('disabled');
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#payOrderForm').serialize(),
                    url: '/buyer/order/pay-order-submit',
                    success: function(json) {
                        if (json.state == '1') {
                            alertTip(json.message, 3);
                            var gotoURL = 'window.location.href=" ' + json.backUrl + ' "';
                            setTimeout(gotoURL, 2000);
                        }else {
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
                            //重置提交按钮可用
                            submit.hideLoading();
                            submit.removeClass('disabled');
                        }
                    }
                });
            }
        });
    });
</script>