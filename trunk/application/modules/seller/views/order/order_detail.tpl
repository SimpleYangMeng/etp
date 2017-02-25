<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><a href="/seller/order/list"><{t}>tradeOrderList<{/t}></a> &gt; <{t}>orderDetail<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
        <div class="table border order_detail">
        <table width="100%" class="table table-bordered table-hover">
            <{if $return.state == 1}>
            <tr>
                <td class="tit_<{$language}>"><{t}>refNo<{/t}></td>
                <td><{$return.data.order_code}></td>
                <td class="tit_<{$language}>"><{t}>plateCode<{/t}></td>
                <td><{$return.data.platefrom}></td>
            </tr>
            <tr>
                <td class="tit_<{$language}>"><{t}>buyerName<{/t}></td>
                <td><{$return.data.buyer_name}></td>
                <td class="tit_<{$language}>"><{t}>accCode<{/t}></td>
                <td><{$return.data.reference_no}></td>
            </tr>
            <tr>
                <td class="tit_<{$language}>"><{t}>orderCurrency<{/t}></td>
                <td><{$return.data.order_currency}></td>
                <td class="tit_<{$language}>"><{t}>orderAmount<{/t}></td>
                <td><{$return.data.order_amount}></td>
            </tr>
            <tr>
                <td class="tit_<{$language}>"><{t}>orderStatus<{/t}></td>
                <td><{$return.data.status_text}></td>
                <td class="tit_<{$language}>"><{t}>shipMethod<{/t}></td>
                <td><{$return.data.sm_code}></td>
            </tr>
            <tr>
                <td class="tit_<{$language}>"><{t}>payCurrency<{/t}></td>
                <td><{$return.data.pay_currency}></td>
                <td class="tit_<{$language}>"><{t}>payAmount<{/t}></td>
                <td><{$return.data.pay_amount}></td>
            </tr>
            <tr>
                <td class="tit_<{$language}>"><{t}>payNo<{/t}></td>
                <td><{$return.data.pay_no}></td>
                <td class="tit"><{t}>changeTime<{/t}></td>
                <td><{$return.data.add_time}></td>
            </tr>
            <tr>
                <td class="tit_<{$language}>" style="height: 100px;"><{t}>remark<{/t}></td>
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
<{if $return.state == 1}>
<div class="top clearfix" style="margin-top: 40px;">
    <p class="dt"><{t}>log<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="tabCon">
    <div class="tabPanel all">
        <div class="table">
            <form id="searchForm" method="post" action="" onsubmit="return false">
                <input type="hidden" name="condition[order_id]" value="<{$return.data.order_id}>" />
            </form>
            <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                <thead>
                    <tr>
                        <th width="60"><{t}>beforeStatus<{/t}></th>
                        <th width="100"><{t}>afterStatus<{/t}></th>
                        <th width="100"><{t}>logContent<{/t}></th>
                        <th width="100"><{t}>operateTime<{/t}></th>
                    </tr>
                </thead>
                <tbody id="grid_body"></tbody>
            </table>
            <!-- 新增分页-->
            <div class="pageInfo">
                <ul class="pagination" id="pagination"></ul>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    ETP.indexAction = 'get-log';
    ETP.url = '/buyer/order/';
    ETP.getListData = function (json) {
        var html = '';
        $.each(json.data, function (key, val) {
            html += "<tr>";
            html += "<td>" + val.status_from + "</td>";
            html += "<td>" + val.status_to + "</td>";
            html += "<td>" + val.note + "</td>";
            html += "<td>" + val.add_time + "</td>";
            html += "</tr>";
        });
        return html;
    }
    $(function (){
    });
</script>
<{/if}>