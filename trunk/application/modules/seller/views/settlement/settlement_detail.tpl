<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"> <{t}>settlementView<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
        <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <{if $return.state == 1}>
            <tr>
                <td class="tit_<{$language}>"><{t}>settlementCode<{/t}></td>
                <td><{$return.data.settlement_code}></td>
                <td class="tit_<{$language}>"><{t}>needsettlingValue<{/t}></td>
                <td><{$return.data.settling_value}> <{$return.data.settling_currency}></td>
            </tr>
            <tr>
                <td class="tit_<{$language}>"><{t}>processingFee<{/t}></td>
                <td><{$return.data.handling_fee}> RMB</td>
                <td class="tit_<{$language}>"><{t}>nowRate<{/t}></td>
                <td><{$return.data.exchange_rate}></td>
            </tr>
            <tr>
                <td class="tit_<{$language}>" style="height: 100px;"><{t}>remark<{/t}></td>
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
