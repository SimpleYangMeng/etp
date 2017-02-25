<div class="menuList">
    <p class="menu-dt clearfix">
        <i class="m_icon cash f_left"></i>
        <span class="span f_left margin_left5">
            <{t}>withdraw<{/t}>
        </span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/portal/supplier-with-draw/internal-with-draw" class="menu_app_withdraw">
                <{t}>appWithdraw<{/t}>
            </a>
        </p>
        <p class="p">
            <a href="/portal/supplier-with-draw/foreign-with-draw" class="menu_app_owithdraw">
                <{t}>appOWithdraw<{/t}>
            </a>
        </p>
        <p class="p">
            <a href="/portal/supplier-withdraw-record/withdraw-list" class="menu_withdraw">
                <{t}>withdrawList<{/t}>
            </a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon exchange f_left">
        </i>
        <span class="span f_left margin_left5">
            <{t}>settlement<{/t}>
        </span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="javascript:" class="menu_app_settlement">
                <{t}>appSettlement<{/t}>
            </a>
        </p>
        <p class="p">
            <a href="javascript:" class="menu_settlement">
                <{t}>settlementList<{/t}>
            </a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon history f_left">
        </i>
        <span class="span f_left margin_left5">
            <{t}>tradeRecord<{/t}>
        </span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/portal/supplier-order/trade-order" class="menu_tradeorder">
                <{t}>tradeOrderList<{/t}>
            </a>
        </p>
        <p class="p">
            <a href="/portal/supplier-order/trade-record" class="menu_sellier_trade_order">
                <{t}>tradeOrderDetail<{/t}>
            </a>
        </p>
    </div>
    <!-- -->
    <p class="menu-dt clearfix">
        <i class="m_icon set3 f_left">
        </i>
        <span class="span f_left margin_left5">
            <{t}>accountManagement<{/t}>
        </span>
    </p>
    <div class="menu-dl clearfix">
        <p class="p">
            <a href="/portal/bank/card" class="menu_bankaccount">
                <{t}>cashAccountManagement<{/t}>
            </a>
        </p>
        <p class="p">
            <a href="/portal/account/payment-password" class="menu_setppwd">
                <{t}>setPaymentPassword<{/t}>
            </a>
        </p>
        <p class="p">
            <{if $account['status'] != 12}>
            <a href="/portal/account/edit-account-info" class="menu_companyinfo">
                <{t}>companyInfoMange<{/t}>
            </a>
            <{else}>
                <a href="/portal/supplier/supplier-detail" class="menu_supplier_detail"><{t}>purchaserDetail<{/t}></a>
            <{/if}>
        </p>
    </div>
</div>