<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><{t}>payOrder<{/t}> &gt; <{t}>payOrderDetail<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <{if $return.state == 1}>
            <tr>
                <td class="tit"><{t}>payNo<{/t}></td>
                <td><{$return.data.pay_no}></td>
                <td class="tit"><{t}>status<{/t}></td>
                <td><{$return.data.status_text}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>seller<{/t}></td>
                <td><{$return.data.seller_code}></td>
                <td class="tit"><{t}>buyer<{/t}></td>
                <td><{$return.data.buyer_code}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>payAmount<{/t}></td>
                <td><{$return.data.pay_amount}></td>
                <td class="tit"><{t}>currency<{/t}></td>
                <td><{$return.data.pay_currency}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>orderCode<{/t}></td>
                <td><{$return.data.order_code}></td>
                <td class="tit"><{t}>payTime<{/t}></td>
                <td><{$return.data.pay_time}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>changeTime<{/t}></td>
                <td><{$return.data.add_time}></td>
                <td class="tit"><{t}>updateTime<{/t}></td>
                <td><{$return.data.update_time}></td>
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