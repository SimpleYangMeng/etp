<div class="top clearfix">
    <p class="dt"><{t}>cashAccountManagement<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="cardList clearfix">
    <{if $hasSubAccount == true}>
        <{foreach from=$bankAccount key=key item=item}>
            <div class="item">
                <p class="t clearfix">
                    <span class="span">
                        <{t}>bankCard<{/t}>
                    </span>
                    <{if $item.status == 1}>
                    <a href="javascript:" class="m_icon set2 f_right margin_left8" bNo="<{$item.bank_card_id}>" aNo="<{$accountNoId[$item.account_no]}>">
                    </a>
                    <{/if}>
                </p>
                <div class="m">
                    <p class="name" title="">
                        <{$item.bank_name}>
                    </p>
                    <p class="number" title="">
                        <{((($item.bank_card_no|substr:-4)|str_pad:($item.bank_card_no|strlen):'*':$smarty.const.STR_PAD_LEFT)|str_split:4)|implode:" "}>
                    </p>
                </div>
                <p class="b">
                    <{if $item.status == 1}>
                    <a href="javascript:" bNo="<{$item.bank_card_id}>" aNo="<{$accountNoId[$item.account_no]}>" class="link2">
                        <{t}>activateBankCard<{/t}>
                    </a>
                    <{else}>
                    &nbsp;
                    <{/if}>

                </p>
            </div>
        <{/foreach}>
        <{if count($bankAccount) < 20}>
            <div class="item empty">
                <i class="m_icon plus f_left margin_left30 margin_top50"></i>
                <a class="f_left margin_left8 blue_00a0e9 f14 margin_top50" href="/seller/bank/add-bank-card" target="_self">
                    <{t}>addBankAccount<{/t}>
                </a>
            </div>
        <{/if}>
        <{else}>
            <div class="form_item  clearfix" style="margin: 20px 0 0 30px;">
                <p class="f_left">
                    <a href='#' id="timeOutAgree" data-toggle="modal" data-target="#dialog_service_agreement" class="f_left blue_btn f16 blue_btn_h_32">
                        <{t}>applySubAccount<{/t}>
                    </a>
                </p>
            </div>
            <div id="dialog_service_agreement" class="modal fade" role="dialog" aria-labelledby="dialog_bankLabel" aria-hidden="true">
                <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h4 class="modal-title" id="myModalLabel">
                            <{t}>serviceAgreement<{/t}>
                        </h4>
                    </div>
                    <div class="modal-body">
                        <{include file="seller/views/bank/pingan_epay_xieyi.tpl"}>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="exportDataBtn" data-dismiss="modal"><{t}>Agree<{/t}><span id="second_span" style="margin-left: 4px;">10m</span></button>
                        <button type="button" class="btn btn-default" data-dismiss="modal"><{t}>cancel<{/t}></button>
                    </div>
                </div>
                </div>
            </div>
            <script type="text/javascript">
                var timeOutIn;
                var secondNum = 10;
                var runSecond = function () {
                    if( secondNum > 0 ){
                        $('#second_span').text(secondNum+'m');
                    }else {
                        window.location.href =  '/seller/bank/apply-sub-account';
                    }
                    secondNum = secondNum - 1;
                }

                $(function(){
                    $('#timeOutAgree').click(function (){
                        secondNum = 10;
                        timeOutIn = setInterval(runSecond, 60000);
                    });

                    //取消
                    $('#dialog_service_agreement').on('hide.bs.modal', function () {
                        clearInterval(timeOutIn);
                    });

                    $('#exportDataBtn').click(function (){
                        window.location.href = '/seller/bank/apply-sub-account';
                    });
                });
            </script>
        <{/if}>
    </div>
</div>
<form id="hidde-form" action="" method="post" style="display:none;">
    <input type="hidden" name="aNo" id="aNo" value="" >
    <input type="hidden" name="bNo" id="bNo" value="" >
</form>
<script type="text/javascript">
    $(function() {
        $('.addNewOne').click(function() {
            window.location = '/seller/bank/add-bank-account';
        })
        $('.link2').click(function() {
            $('#hidde-form').attr('action','/seller/bank/confirm-bank-card');
            $('#aNo').val( $(this).attr('aNo') );
            $('#bNo').val( $(this).attr('bNo') );
            document.getElementById('hidde-form').submit(); 
        });

        $('.set2').click(function() {
            $('#hidde-form').attr('action','/seller/bank/edit-bank-card');
            $('#aNo').val( $(this).attr('aNo') );
            $('#bNo').val( $(this).attr('bNo') );
            document.getElementById('hidde-form').submit(); 
        });
    })
</script>