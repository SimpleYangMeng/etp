<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>

<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/zh-CN.js"></script>
<link type="text/css" href="/css/smoothness/jquery-ui-1.8.16.custom.css" rel="stylesheet" />
<script src='/js/jquery-ui-1.8.16.custom.min.js' type="text/javascript"></script>

<!--<link href="/etp_style_v1.0/js/bootstrap/css/bootstrap-dialog.css" rel="stylesheet" type="text/css" />
<script src="/etp_style_v1.0/js/jquery-ui.min.js" type="text/javascript"></script>-->
<!--买家充值页面-->
<div class="bottom">
    <div class="form_group clearfix">
      <form id="completeForm" action='' onsubmit='return false' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
        <!--<div class="form_item margin_top45 clearfix">
            <span class="tit width120 f_left"><{t}>FromBankName<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left clearfix">
                <input type="text" name="charge_bank_name" id='charge_bank_name' class="input" data-rule="<{t}>FromBankName<{/t}>:required" data-tip="<{t}>FromBankNameTip<{/t}>"/>
            </div>
        </div>-->
        <!-- -->
        <!--<div class="form_item clearfix">
            <span class="tit width120 f_left"><{t}>FromBankAccount<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left clearfix">
                <input type="text" name="charge_bank_card_name" id="charge_bank_card_name" class="input" data-rule="<{t}>FromBankAccount<{/t}>:required" data-tip="<{t}>FromBankAccountTip<{/t}>"/>
            </div>
        </div>-->
        <div class="form_item clearfix">
            <span class="tit width120 f_left"><{t}>RechargeNo<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left clearfix">
                <input type="text" name="recharge_code" id="recharge_code" class="input" data-rule="<{t}>RechargeNo<{/t}>:required" data-tip="<{t}>RechargeNoTip<{/t}>"/>
            </div>
        </div>
        <!-- -->
        <div class="form_item  clearfix">
            <span class="tit width120 f_left"><{t}>FromBankCard<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left clearfix">
                <input type="text" name="charge_bank_card" id="charge_bank_card" class="input" data-rule="<{t}>FromBankCard<{/t}>:required" data-tip="<{t}>FromBankCardTip<{/t}>"/>
            </div>
        </div>
        <!-- -->
        <div class="form_item clearfix">
            <span class="tit width120 f_left"><{t}>chargeValue<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left clearfix">
                <input type="text" name="charge_value" id="charge_value" class="input" data-rule="<{t}>chargeValue<{/t}>:required" data-tip="<{t}>chargeValueTip<{/t}>"/>
            </div>
        </div>
        <!-- -->
        <div class="form_item clearfix">
            <span class="tit width120 f_left"><{t}>currency<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left clearfix">
                <select name="charge_currency" id="charge_currency" class="selBox">
                    <option value="USD">USD</option>
                </select>
            </div>
        </div>
        <!-- -->
        <div class="form_item clearfix">
            <span class="tit width120 f_left"><{t}>note<{/t}>：<em class="blue_00a0e9">*</em></span>
            <div class="dl f_left clearfix">
                <textarea name="note" id="note" cols="30" rows="10" class="textBox" data-rule="<{t}>note<{/t}>:required" data-tip="<{t}>noteTip<{/t}>"></textarea>
            </div>
        </div>
        <!-- -->
        <div class="form_item  clearfix" style="margin-top: 50px">
            <span class="tit width120 f_left">&nbsp;</span>
            <p class="f_left">
                <a href="javascript:" class="f_left blue_btn f16 blue_btn_h_32 margin_left10 blue_btn submitBtn">提交申请</a>
            </p>
        </div>
          <div class="form_item margin_top45 clearfix">
              <span class="tit width240 f_left" style="width: 150px">&nbsp;</span>
              <div class="f_left" id="noticeWrap"></div>
          </div>
      </form>
    </div>
    <!-- -->
</div>

<script type="text/javascript">
    function alertTip2(tip,width,height,notflash) {
        width = width?width:500;
        height = height?height:'auto';
        $('<div title="Note(Esc)"><p align="">' + tip + '</p></div>').dialog({
            autoOpen: true,
            width: width,
            height: height,
            modal: true,
            show:"slide",
            buttons: {
                '关闭(Close)': function() {
                    $(this).dialog('close');
                    if(!(typeof(notflash)!="undefined" && notflash=='1')){
                        //$('#pagerForm').submit();
                    }
                }
            },
            close: function() {

            }
        });
    }
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
        $('.submitBtn').click(function() {
            $('#completeForm').submit();
        });
        $('#completeForm').validator({
            //alert('ooo');
            //远程验证邮箱
            fields: {
                //'email': "<{t}>Email<{/t}>:required;email;remote[/register/check-email-exists, visitor_type]",
                // 'charge_bank_name':'required; username;',
            },
            valid: function() {
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#completeForm').serialize(),
                    url: '/portal/purchaser/parecharge',
                    success: function(json) {
                        var html = '';
                        if (json.state == '1') {
                        }else if (json.state == '-1') {
                            alertTip(json.message, 2);
                            setTimeout('window.location.href="/login"', 2000);
                        } else {
                            html += json.message;
                            $.each(json.error,function(k,v){
                                html+='<p>'+ v.errorMsg+'</p>';
                                alertTip(v.errorMsg,1);
                            });
                            //alertTip(html);
                        }
                    }
                });
            }
        });
    });
</script>