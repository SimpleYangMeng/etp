<div class="bottom">
    <div class="panel_ls clearfix">
        <!-- -->
        <div class="item">
            <p class="tit clearfix">
                <span class="f_left span margin_left10">
                    <{t}>accountBalance<{/t}>
                </span>
            </p>
            <div class="dl">
                <li class="li clearfix margin_top10">
                    <{t}>domestic<{/t}><{t}>colon<{/t}>
                    <strong class="num" title="<{t}>ChineseWithdrawBalance<{/t}>">
                        <{if !empty( $sBalance ) }><{$sBalance['internal_value_currency']}> <{$sBalance['internal_value']}><{else}><{$account['currency']}> 0.00<{/if}>
                    </strong>
                </li>
                <li class="li clearfix margin_top20">
                    <{t}>foreign<{/t}><{t}>colon<{/t}>
                    <strong class="num" title="<{t}>foreignWithdrawBalance<{/t}>">
                        <{if !empty( $sBalance ) }><{$sBalance['foreign_value_currency']}> <{$sBalance['foreign_value']}><{else}><{$account['currency']}> 0.00<{/if}>
                    </strong>
                </li>
            </div>
        </div>
        <!-- -->
        <div class="item margin_left10">
            <p class="tit clearfix">
                <span class="f_left margin_left10">
                    <{t}>settlementBalance<{/t}>
                </span>
            </p>
            <div class="dl">
                <li class="li clearfix margin_top10">
                    <{t}>amount<{/t}><{t}>colon<{/t}>
                    <strong class="num" title="<{t}>avalibleSettlementBalance<{/t}>">
                        USD <{if !empty($sBalance)}><{$sBalance['settling_value']}><{else}>0.00<{/if}>
                    </strong>
                </li>
            </div>
        </div>
        <!-- -->
        <div class="item margin_left10">
            <p class="tit clearfix">
                <span class="f_left margin_left10">
                    <{t}>inoutList<{/t}>
                </span>
            </p>
            <div class="dl">
                <li class="li clearfix margin_top10">
                    <{t}>today<{/t}><{t}>colon<{/t}>
                    <strong class="num" title="<{t}>incomeToday<{/t}>">
                        <{$account['currency']}> <{$todayIncome}>
                    </strong>
                </li>
                <li class="li clearfix margin_top20">
                    <{t}>month<{/t}><{t}>colon<{/t}>
                    <strong class="num" title="<{t}>incomeMonth<{/t}>">
                        <{$account['currency']}> <{$monthIncome}>
                    </strong>
                </li>
            </div>
        </div>
        <!-- -->
    </div>
</div>