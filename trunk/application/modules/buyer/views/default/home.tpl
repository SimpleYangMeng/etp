<div class="bottom">
    <div class="panel_ls clearfix">
        <!-- -->
        <div class="item margin_left20">
            <p class="tit clearfix">
                <span class="f_left span margin_left10"><{t}>accountBalance<{/t}></span>
            </p>
            <div class="dl clearfix">
                <li class="li clearfix margin_top10 f_left">
                    <span class="f_left"><{t}>amount<{/t}><{t}>colon<{/t}></span>
                    <strong class="num" title="<{t}>fcBalance<{/t}>"><{$account['currency']}> <{$bBalance}></strong>
                </li>
            </div>
        </div>
        <!-- -->
        <div class="item margin_left10">
            <p class="tit clearfix">
                <span class="f_left margin_left10"><{t}>inoutList<{/t}></span>
            </p>
            <div class="dl clearfix">
                <li class="li clearfix margin_top10 f_left">
                    <span class="f_left"><{t}>today<{/t}><{t}>colon<{/t}></span>
                    <strong class="num" title="<{t}>incomeToday<{/t}>"><{$account['currency']}> <{$incomeToday}></strong>
                </li>
                <li class="li clearfix margin_top20 f_left">
                    <span class="f_left"><{t}>month<{/t}><{t}>colon<{/t}></span>
                    <strong class="num" title="<{t}>incomeMonth<{/t}>"><{$account['currency']}> <{$incomeMonth}></strong>
                </li>
            </div>
        </div>
        <!-- -->
    </div>
</div>