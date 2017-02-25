<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><a href="/buyer/charge/recharge-list"><{t}>rechargeList<{/t}></a> &gt; <{t}>chargeView<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <{if $return.state == 1}>
            <tr>
                <td class="tit"><{t}>RechargeNo<{/t}></td>
                <td><{$return.data.recharge_code}></td>
                <td class="tit"><{t}>charge_type<{/t}></td>
                <td><{$type[$return.data.charge_type]}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>FromBankName<{/t}></td>
                <td><{$return.data.charge_bank_name}></td>
                <td class="tit"><{t}>FromBankAccount<{/t}></td>
                <td><{$return.data.charge_bank_card_name}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>fromBankCard<{/t}></td>
                <td><{((($return.data.charge_bank_card|substr:-4)|str_pad:($return.data.charge_bank_card|strlen):'*':$smarty.const.STR_PAD_LEFT)|str_split:4)|implode:" "}></td>
                <td class="tit"><{t}>chargeValue<{/t}></td>
                <td><{$return.data.charge_value}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>actualchargeValue<{/t}></td>
                <td><{$return.data.actual_charge_value}></td>
                <td class="tit"><{t}>chargeCurrency<{/t}></td>
                <td><{$return.data.charge_currency}></td>
            </tr>
            <tr>
                <td class="tit"><{t}>chargeaddTime<{/t}></td>
                <td><{$return.data.add_time}></td>
                <td class="tit"><{t}>chargeStatus<{/t}></td>
                <td><{$return.data.status_text}></td>

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
