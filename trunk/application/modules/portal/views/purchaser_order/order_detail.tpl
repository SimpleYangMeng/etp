<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><a href="/portal/purchaser-order/list"><{t}>tradeOrderList<{/t}></a> &gt; <{t}>orderDetail<{/t}></p>
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

