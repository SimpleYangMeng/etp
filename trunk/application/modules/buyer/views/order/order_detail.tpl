<div class="top clearfix">
    <p class="dt" style="padding-left: 60px;"><a href="/buyer/order/list"><{t}>tradeOrderList<{/t}></a> &gt; <{t}>orderDetail<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="table border order_detail">
        <{include file="buyer/views/order/order_base_detail.tpl"}>
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