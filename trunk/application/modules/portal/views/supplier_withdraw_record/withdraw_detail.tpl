<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><{t}>withdrawList<{/t}> &gt; <{t}>viewWithdraw<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <{if !empty($withdraw)}>
    <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <tr>
                <td class="tit"><{t}>withdrawCode<{/t}></td>
                <td><{$withdraw.withdraw_code}></td>
                <td class="tit"><{t}>transactionNo<{/t}></td>
                <td><{$withdraw.transaction_no}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>withdrawType<{/t}></td>
                <td><{$withdraw.withdraw_type}></td>
                <td class="tit"><{t}>status<{/t}></td>
                <td><{$withdraw.status}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>bankName<{/t}></td>
                <td><{$withdraw.bank_name}></td>
                <td class="tit"><{t}>bankCardNum<{/t}></td>
                <td><{"/(\S{4})(?=\S)/"|preg_replace:"**** ":$withdraw.bank_card}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>bankCardName<{/t}></td>
                <td><{$withdraw.bank_buyer_name}></td>
                <td class="tit"><{t}>cashAmount<{/t}></td>
                <td><{if $currency != false }><{$currency['currency_symbol_left']}><{else}><{$withdraw.currency}><{/if}><{$withdraw.amount}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>changeTime<{/t}></td>
                <td><{$withdraw.add_time}></td>
                <td class="tit"><{t}>updateTime<{/t}></td>
                <td><{$withdraw.update_time}></td>
            </tr>
            <tr>
                <td class="tit" style="height: 100px;"><{t}>remark<{/t}></td>
                <td colspan="3"><{$withdraw.note}></td>
            </tr>
        </table>
    </div>
    <{else}>
    <div>
        <div id="success-div" style="margin-top:15%;text-align:center;font-size:15px">
            <p><i class="errorIcon"></i> 查询提现详情失败，请重试。</p>
    </div>
    </div>
    <{/if}>
</div>