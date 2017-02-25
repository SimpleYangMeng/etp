<div class="menuList">
    <p class="menu-dt clearfix">
        <i class="m_icon recharge f_left"></i>
        <span class="span f_left margin_left5"><{t}>recharge<{/t}></span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/portal/purchaser-charge/recharge" class="recharge"><{t}>rechargeApplication<{/t}></a>
        </p>
        <p class="p">
            <a href="/portal/purchaser-charge/recharge-list" class="rechargeList"><{t}>rechargeList<{/t}></a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon exchange f_left"></i>
        <span class="span f_left margin_left5"><{t}>wantPay<{/t}></span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/portal/purchaser-pay-order-record/pay-order-list" class="menu_purchaser_pay_order"><{t}>payOrder<{/t}></a>
        </p>
        <p class="p">
            <a href="/portal/purchaser-order/list" class="menu_order_list"><{t}>tradeOrderList<{/t}></a>
        </p>
        <p class="p">
            <a href="/portal/purchaser-order/trade-order" class="menu_buyer_trade_order"><{t}>tradeOrderDetail<{/t}></a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon cash f_left"></i>
        <span class="span f_left margin_left5"><{t}>withdraw<{/t}></span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/portal/purchaser/foreign-cash" class="menu_cash"><{t}>appOWithdraw<{/t}></a>
        </p>
        <p class="p">
            <a href="/portal/purchaser-withdraw-record/withdraw-list" class="menu_cash_list"><{t}>withdrawList<{/t}></a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon set3 f_left"></i>
        <span class="span f_left margin_left5"><{t}>accountManagement<{/t}></span>
    </p>
    <div class="menu-dl clearfix">
        <{if $account['has_pay_password'] == 1}>
        <p class="p">
            <a href="/portal/account/payment-password" class="menu_setppwd"><{t}>setPaymentPassword<{/t}></a>
        </p>
        <{/if}>
        <{if $account['status'] != 12}>
        <p class="p">
            <a href="/portal/account/edit-account-info" class="menu_companyinfo"><{t}>companyInfoMange<{/t}></a>
        </p>
        <{else}>
        <p class="p">
            <a href="/portal/purchaser/purchaser-detail" class="menu_purchaser_detail"><{t}>purchaserDetail<{/t}></a>
        </p>
        <{/if}>
    </div>
</div>