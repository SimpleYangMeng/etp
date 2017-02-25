<div class="top clearfix">
    <p class="dt border_b_line">
        <{t}>cashAccountManagement<{/t}>
    </p>
</div>
<div class="bottom">
    <div class="cardList clearfix">
    <{if $hasSubAccount == true}>
    <{foreach from=$bankAccount key=key item=item}>
        <div class="item">
            <p class="t clearfix">
                <span class="span">
                    银行卡
                </span>
                <a href="javascript:" class="m_icon set2 f_right margin_left8">
                </a>
            </p>
            <div class="m">
                <p class="name" title="">
                    <{$item.bank_name}>
                </p>
                <p class="number" title="">
                    <{"/(\S{4})(?=\S)/"|preg_replace:"**** ":$item.bank_card_no}>
                </p>
            </div>
            
            <p class="b">
                <{if $item.status == 1}>
                <a href="javascript:" bNo="<{$item.bank_card_id}>" aNo="<{$accountNoId[$item.account_no]}>" class="link2">
                    激活账号
                </a>
                <{else}>
                &nbsp;
                <{/if}>

            </p>
            
        </div>
        <{/foreach}>
        <div class="item empty">
            <i class="m_icon plus f_left margin_left40 margin_top50 addNewOne"></i>
            <a class="f_left margin_left8 blue_00a0e9 f14 margin_top50 addNewOne" href="/portal/bank/add-bank-card">
                添加新的提现账户
            </a>
        </div>
        <{else}>
        <div class="form_item  clearfix" style="margin-top: 50px">
            <p class="f_left">
                <a href="/portal/bank/apply-sub-account" class="f_left blue_btn f16 blue_btn_h_32">
                    申请子账号
                </a>
            </p>
        </div>
        <{/if}>
    </div>
</div>
<form id="confirm-bank" action="/portal/bank/confirm-bank-card" method="post" style="display:none;">
    <input type="hidden" name="aNo" id="aNo" value="" >
    <input type="hidden" name="bNo" id="bNo" value="" >
</form>
<script type="text/javascript">
    $(function() {
        $('.addNewOne').click(function() {
            window.location = '/portal/account/add-bank-account';
        })
        $('.link2').click(function() {
            $('#aNo').val( $(this).attr('aNo') );
            $('#bNo').val( $(this).attr('bNo') );
            document.getElementById('confirm-bank').submit(); 
        });
    })
</script>