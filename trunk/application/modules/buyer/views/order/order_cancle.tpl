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
    <p class="dt"><{t}>confirmCancle<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="cancleOrderForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="orderId" value="<{$return.data.order_id}>" />
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left" style="width: 150px"><{t}>cancelReason<{/t}>：<em class="blue_00a0e9">*</em></span>
                <div class="dl f_left clearfix">
                    <!--<input type="password" name="payPwd" class="input" data-rule="<{t}>payPwd<{/t}>:required;length(6~16)"/>-->
                    <textarea name="cancleReason" data-rule="<{t}>cancelReason<{/t}>:required"></textarea>
                </div>
            </div>
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left" style="width: 150px">&nbsp;</span>
                <div class="dl f_left clearfix">
                    <button type="submit" class="btn btn-primary btn-check submit" data-tip="<{t}>payPwd<{/t}>" id="cancle_tip" data-toggle="tooltip" data-trigger="hover" data-placement="right" title="<{$cancelNotice}>"><{t}>Confirm<{/t}><{t}>submit<{/t}></button>
                </div>
            </div>
        </form>
        <div class="form_item margin_top10 clearfix">
            <span class="tit f_left" style="width: 50px">&nbsp;</span>
            <div class="f_left" id="noticeWrap"></div>
        </div>
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
        $('#cancle_tip').tooltip();
        var submit = $('.submit');
        //表单验证
        $('#cancleOrderForm').validator({
            valid: function() {
                submit.showLoading({addClass:'loading-indicator-circle-1'});
                submit.addClass('disabled');
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#cancleOrderForm').serialize(),
                    url: '/buyer/order/cancle-order-submit',
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
<{/if}>