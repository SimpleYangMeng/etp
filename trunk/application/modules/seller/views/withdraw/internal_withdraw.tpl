<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js">
</script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$languageTpl}>.js">
</script>
<style type="text/css">
    <{if $languageTpl=='en_US' }>
        .m_colContainer .col-r .form_item .tit { width: 190px; }
    <{else}>
        .m_colContainer .col-r .form_item .tit { width: 120px; }
    <{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>localWithdrawApply<{/t}></p>
    <div class="t_w2 border_b_line"></div>
    <p class="f15 margin_top30" style="padding-left: 60px">
        <{t}>localAccountBalance<{/t}><{t}>colon<{/t}>&nbsp;&nbsp;<span class="f16 red_e83d2c"><{$cBalance}>&nbsp;&nbsp;<{if !empty($currency)}><{if $language=='zh_CN'}><{$currency['currency_name']}><{else}><{$currency['currency_name_en']}><{/if}><{/if}></span>
    </p>
</div>
<div class="bottom">
    <div class="form_group clearfix">
        <form id="cashForm" method="post" action="" onsubmit="return false" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
            <input type="hidden" name="totalAmount" value="<{$cBalance}>" />
            <div class="form_item margin_top45 clearfix">
                <span class="tit">
                    <{t}>selectwithdrawBank<{/t}><{t}>colon<{/t}>
                    <em class="blue_00a0e9">
                        &nbsp;
                    </em>
                </span>
                <span class="dl">
                    <{if $hasSubAccount==true}>
                        <a class="m_icon plus  addNewOne" data-toggle="modal" data-target="#dialog_bank" style="height:20px!important;vertical-align:middle"></a>
                    <{else}>
                        <i class="m_icon plus  addNewOne" style="height:20px!important;vertical-align:middle"></i>
                        <a class="margin_left8 blue_00a0e9 f14 addNewOne" href="/portal/bank/add-bank-card"><{t}>AddNewWithdrawal<{/t}></a>
                    <{/if}>
                </span>
            </div>
            <div class="form_item margin_top45 clearfix">
                <span class="tit f_left">
                    <{t}>bankName<{/t}><{t}>colon<{/t}>
                    <em class="blue_00a0e9">
                        *
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <span id="bank_name_text">
                    </span>
                    <input type="hidden" class="input" name="data[bank_name]" id="bank_name" data-rule="<{t}>bankName<{/t}>:required;" data-tip="" />
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    <{t}>bankCardName<{/t}><{t}>colon<{/t}>
                    <em class="blue_00a0e9">
                        *
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <span id="bank_buyer_name_text">
                    </span>
                    <input type="hidden" class="input" name="data[bank_buyer_name]" id="bank_buyer_name" data-rule="<{t}>bankCardName<{/t}>:required;" data-tip="" />
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left">
                    <{t}>bankCardNum<{/t}><{t}>colon<{/t}>
                    <em class="blue_00a0e9">
                        *
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <span id="bank_card_text">
                    </span>
                    <input type="hidden" class="input" name="data[bank_card]" id="bank_card" data-rule="<{t}>bankCardNum<{/t}>:required;" data-tip="" />
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    <{t}>cashAmount<{/t}><{t}>colon<{/t}>
                    <em class="blue_00a0e9">
                        *
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <input type="text" class="input" name="data[amount]" data-rule="<{t}>cashAmount<{/t}>:required;amount;match[lte, totalAmount];" data-rule-amount="[/^(([1-9]\d{0,9})|0)(\.\d{1,4})?$/, '<{t}>wrongFormat<{/t}>']" data-tip="" />
                </div>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    <{t}>remark<{/t}><{t}>colon<{/t}>
                    <em class="blue_00a0e9">
                        &nbsp;
                    </em>
                </span>
                <div class="dl f_left clearfix">
                    <textarea name="data[note]" id="note" cols="30" rows="10" class="textBox"></textarea>
                </div>
            </div>
            <div class="form_item  clearfix">
                <span class="tit f_left">
                    &nbsp;
                </span>
                <p class="dl f_left clearfix">
                    <!--<input class="submit" type="submit" value="<{t}>Confirm<{/t}><{t}>submit<{/t}>" id="submitBtn" />-->
                    <button type="submit" class="btn btn-primary btn-check submit" data-loading-text="<{t}>submiting<{/t}>">
                        <{t}>submit<{/t}>
                    </button>
                </p>
            </div>
            <div class="form_item clearfix">
                <span class="tit f_left">
                    &nbsp;
                </span>
                <div class="dl f_left clearfix">
                    <span id="noticeWrap">
                    </span>
                </div>
            </div>
        </form>
    </div>
</div>
<div id="dialog_bank" class="modal fade" role="dialog" aria-labelledby="dialog_bankLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    <{t}>selectwithdrawBank<{/t}>
                </h4>
            </div>
            <div class="modal-body bottom" style="padding-bottom:20px;">
                <div class="cardList clearfix">
                <{if $hasSubAccount==true}>
                <{foreach from=$bankAccount key=key item=item}>
                    <div class="item">
                        <p class="t clearfix">
                            <span class="span">
                                <{t}>bankCard<{/t}>
                            </span>
                            <a href="javascript:" class="m_icon set2 f_right margin_left8">
                            </a>
                        </p>
                        <div class="m">
                            <p class="name" title="">
                                <{$item.bank_name}>
                            </p>
                            <p class="number" title="">
                            </p>
                        </div>
                        <p class="b">
                            <{if $item.status==1 }>
                                <a href="javascript:" bNo="<{$item.bank_card_id}>" aNo="<{$accountNoId[$item.account_no]}>" bank_name="<{$item.bank_name}>" card_user_name="<{$item.bank_card_user_name}>" bank_card_no="<{$item.bank_card_no}>" class="link2"><{t}>activateBankCard<{/t}>
                                </a>
                            <{else}>
                                <a href="javascript:" bNo="<{$item.bank_card_id}>" aNo="<{$accountNoId[$item.account_no]}>" bank_name="<{$item.bank_name}>" card_user_name="<{$item.bank_card_user_name}>" bank_card_no="<{$item.bank_card_no}>" class="link2 select">
                                    <{t}>select<{/t}>
                                </a>
                            <{/if}>
                        </p>
                    </div>
                <{/foreach}>
                    <div class="item empty">
                        <i class="m_icon plus f_left margin_left40 margin_top50 addNewOne">
                        </i>
                        <a class="f_left margin_left8 blue_00a0e9 f14 margin_top50 addNewOne" href="/seller/bank/add-bank-card">
                            <{t}>addNewBankCard_U<{/t}>
                        </a>
                    </div>
                <{/if}>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    <{t}>close<{/t}>
                </button>
                <div></div>
            </div>
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

    $(function() {
        $('.select').on('click',
            function() {
                var bank_name = $(this).attr('bank_name'); //银行名称
                $('#bank_name').val(bank_name);
                $('#bank_name_text').html(bank_name);
                var bankCardNo = $(this).attr('bank_card_no'); //银行卡号
                $('#bank_card').val(bankCardNo);
                $('#bank_card_text').html(bankCardNo);
                var bank_card_user_name = $(this).attr('card_user_name'); //银行持卡人名称
                $('#bank_buyer_name').val(bank_card_user_name);
                $('#bank_buyer_name_text').html(bank_card_user_name);
                var bank_card_no = '';
                $('#dialog_bank').modal('hide');
           }
        );
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
                    url: '/seller/withdraw/internal-withdraw',
                    success: function(json) {
                        if (json.state == '1') {
                            alertTip(json.message, 3);
                            $('#cashForm')[0].reset();
                        } else {
                            $('#noticeWrap').empty();
                            if (json.message != '') {
                                alertTip(json.message, 2);
                            }
                            if (typeof(json.error) != 'undefined') {
                                $.each(json.error,
                                function(key, item) {
                                    alertTip(item.errorCode + ':' + item.errorMsg, 2);
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