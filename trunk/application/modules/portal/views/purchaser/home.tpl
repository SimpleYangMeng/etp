<div class="bottom">
    <div class="panel_ls clearfix">
        <!-- -->
        <div class="item margin_left20">
            <p class="tit clearfix">
                <span class="f_left span margin_left10"><{t}>accountBalance<{/t}></span>
            </p>
            <div class="dl">
                <li class="li clearfix">
                    <{t}>fcBalance<{/t}>：<strong class="num"><{$account['currency']}> <{$bBalance}></strong>
                </li>
            </div>
        </div>
        <!-- -->
        <div class="item margin_left10">
            <p class="tit clearfix">
                <span class="f_left margin_left10"><{t}>inoutList<{/t}></span>
            </p>
            <div class="dl">
                <li class="li clearfix">
                    <{t}>incomeToday<{/t}>：<strong class="num"><{$account['currency']}> <{$incomeToday}></strong>
                </li>
                <li class="li clearfix">
                    <{t}>incomeMonth<{/t}>：<strong class="num"><{$account['currency']}> <{$incomeMonth}></strong>
                </li>
            </div>
        </div>
        <!-- -->
    </div>
</div>