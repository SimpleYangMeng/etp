<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><{t}>withdrawList<{/t}> &gt; <{t}>cashView<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <{if $return.state == 1}>
            <tr>
                <td class="tit"><{t}>cashNo<{/t}></td>
                <td><{$return.data.withdraw_code}></td>
                <td class="tit"><{t}>cashType<{/t}></td>
                <td>境内提现</td>
            </tr>
            <tr>
                <td class="tit"><{t}>cashType<{/t}></td>
                <td><{$return.data.status_text}></td>
                <td class="tit"><{t}>cashBank<{/t}></td>
                <td><{$return.data.bank_name}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>bankCardName<{/t}></td>
                <td><{$return.data.bank_buyer_name}></td>
                <td class="tit"><{t}>bankCardNum<{/t}></td>
                <td><{$return.data.bank_card}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>cashCurrency<{/t}></td>
                <td><{$return.data.currency}></td>
                <td class="tit"><{t}>cashAmount<{/t}></td>
                <td><{$return.data.amount}></td>
            </tr>
            <tr>
                <td class="tit" style="height: 100px;"><{t}>remark<{/t}></td>
                <td colspan="3"><{$return.data.note}></td>
            </tr>
            <{else}>
            <tr>
                <td colspan="4"><{$return.message}></td>
            </tr>
            <{/if}>
        </table>
    </div>
</div>
