<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>
<div class="top clearfix">
    <p class="dt"><{t}>orderDetail<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <{if $return.state == 1}>
            <tr>
                <td class="tit"><{t}>refNo<{/t}></td>
                <td><{$return.data.order_code}></td>
                <td class="tit"><{t}>plateCode<{/t}></td>
                <td><{$return.data.platefrom}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>buyerName<{/t}></td>
                <td><{$return.data.buyer_name}></td>
                <td class="tit"><{t}>accCode<{/t}></td>
                <td><{$return.data.reference_no}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>orderCurrency<{/t}></td>
                <td><{$return.data.order_currency}></td>
                <td class="tit"><{t}>orderAmount<{/t}></td>
                <td><{$return.data.order_amount}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>orderStatus<{/t}></td>
                <td><{$return.data.status_text}></td>
                <td class="tit"><{t}>shipMethod<{/t}></td>
                <td><{$return.data.sm_code}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>payCurrency<{/t}></td>
                <td><{$return.data.pay_currency}></td>
                <td class="tit"><{t}>payAmount<{/t}></td>
                <td><{$return.data.pay_amount}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>payNo<{/t}></td>
                <td><{$return.data.pay_no}></td>
                <td class="tit"><{t}>changeTime<{/t}></td>
                <td><{$return.data.add_time}></td>
            </tr>
            <tr>
                <td class="tit" style="height: 100px;"><{t}>remark<{/t}></td>
                <td colspan="3"><{$return.data.note}></td>
            </tr>
            <{else}>
            <tr>
                <td colspan="4"><{$return.msg}></td>
            </tr>
            <{/if}>
        </table>
    </div>
</div>
<div class="top clearfix" style="margin-top: 40px;">
    <p class="dt"><{t}>payNow<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="payOrderForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="orderId" value="<{$return.data.order_id}>" />
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left" style="width: 150px"><{t}>payPwd<{/t}>：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <input type="password" name="payPwd" class="input" data-rule="<{t}>payPwd<{/t}>:required;length(6~16)"/>
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left" style="width: 150px">&nbsp;</span>
                <p class="f_left" style="padding-left: 12px;">
                    <button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<{t}>submiting<{/t}>" data-tip="<{t}>payPwd<{/t}>" id="password_tip" data-toggle="tooltip" data-trigger="hover" data-placement="right" title="<{t}>payNotice<{/t}>"><{t}>Confirm<{/t}><{t}>submit<{/t}></button>
                </p>
            </div>
            <div class="form_item margin_top10 clearfix">
                <span class="tit f_left" style="width: 150px">&nbsp;</span>
                <div class="f_left" id="noticeWrap"></div>
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
    $(function (){
        $('#password_tip').tooltip();
        var submit = $('.submit');
        //表单验证
        $('#payOrderForm').validator({
            //验证原始密码
            fields: {
                'payPwd': "<{t}>payPwd<{/t}>:required;length(6~16);remote[/seller/account/check-pwd, payPwd]"
            },
            valid: function() {
                submit.showLoading({addClass:'loading-indicator-circle-1'});
                submit.addClass('disabled');
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#payOrderForm').serialize(),
                    url: '/seller/order/pay-order-submit',
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