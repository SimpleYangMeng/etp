<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><a href="/buyer/pay-order-record/pay-order-list"><{t}>payOrder<{/t}></a> &gt; <{t}>payOrderDetail<{/t}></p>
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
<{if $return.state == 1}>
<div class="top clearfix" style="margin-top: 40px;">
    <p class="dt"><{t}>log<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="tabCon">
    <div class="tabPanel all">
        <div class="table">
            <form id="searchForm" method="post" action="" onsubmit="return false">
                <input type="hidden" name="condition[order_pay_id]" value="<{$return.data.order_pay_id}>" />
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
    ETP.url = '/buyer/pay-order-record/';
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