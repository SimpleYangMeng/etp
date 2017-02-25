<div class="bottom">
    <div class="panel_ls clearfix">
        <!-- -->
        <div class="item">
            <p class="tit clearfix">
                <span class="f_left span margin_left10">
                    账户余额
                </span>
            </p>
            <div class="dl">
                <li class="li clearfix">
                    境内可提现余额：
                    <strong class="num">
                        <{if !empty( $sBalance ) }><{$sBalance['internal_value_currency']}> <{$sBalance['internal_value']}><{else}><{$account['currency']}> 0.00<{/if}>
                    </strong>
                </li>
                <li class="li clearfix">
                    境外可提现余额：
                    <strong class="num">
                        <{if !empty( $sBalance ) }><{$sBalance['foreign_value_currency']}> <{$sBalance['foreign_value']}><{else}><{$account['currency']}> 0.00<{/if}>
                    </strong>
                </li>
            </div>
        </div>
        <!-- -->
        <div class="item margin_left10">
            <p class="tit clearfix">
                <span class="f_left margin_left10">
                    结汇金额
                </span>
            </p>
            <div class="dl">
                <li class="li clearfix">
                    可结汇金额：
                    <strong class="num">
                        USD <{if !empty($sBalance)}><{$sBalance['settling_value']}><{else}>0.00<{/if}>
                    </strong>
                </li>
            </div>
        </div>
        <!-- -->
        <div class="item margin_left10">
            <p class="tit clearfix">
                <span class="f_left margin_left10">
                    收入明细
                </span>
            </p>
            <div class="dl">
                <li class="li clearfix">
                    今日收入：
                    <strong class="num">
                        <{$account['currency']}> <{$todayIncome}>
                    </strong>
                </li>
                <li class="li clearfix">
                    本月收入总计：
                    <strong class="num">
                        <{$account['currency']}> <{$monthIncome}>
                    </strong>
                </li>
            </div>
        </div>
        <!-- -->
    </div>
</div>