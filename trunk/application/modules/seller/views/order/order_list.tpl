<style type="text/css">
.m_colContainer .col-r .form_item .tit { width: auto; }
<{if $language == 'en_US'}>
.m_colContainer .col-r .bottom .tabBtnGroup .tabBtn { padding: 0 20px 0 20px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>tradeOrderList<{/t}></p>
    <div class="t_w2 border_b_line"></div>
    <div class="form_group clearfix">
        <form id="searchForm" method="post" action="" onsubmit="return false">
            <input type="hidden" value="" name="condition[order_status]" id="status" />
            <table>
                <tr class="height50">
                    <td class="td_l_<{$language}> <{if $language=='zh_CN'}>width100<{else}>width130<{/if}>"><{t}>refNo<{/t}><{t}>colon<{/t}></td>
                    <td class="width240 td_r_<{$language}>"><input type="text" name="condition[order_code]" class="input width200"/></td>
                    <td class="td_l_<{$language}> <{if $language=='zh_CN'}>width100<{else}>width130<{/if}>"><{t}>accCode<{/t}><{t}>colon<{/t}></td>
                    <td class="width240 td_r_<{$language}>"><input type="text" name="condition[reference_no]" class="input width200"/></td>
                </tr>
                <tr class="height50">
                    <td class="td_l_<{$language}>"><{t}>plateCode<{/t}><{t}>colon<{/t}></td>
                    <td class="td_r_<{$language}>">
                    <select name="condition[plate_code]" id="plate_code" class="selBox" style="min-width: 80px;max-width: 245px;">
                        <option value=""><{t}>all<{/t}></option>
                        <{foreach from=$platefrom key=key item=item}>
                            <option value="<{$key}>"><{$item}></option>
                        <{/foreach}>
                    </select>
                    </td>
                    <td class="td_l_<{$language}>"><{t}>payStatus<{/t}><{t}>colon<{/t}></td>
                    <td class="td_r_<{$language}>">
                    <select name="condition[pay_status]" id="pay_status" class="selBox" style="min-width: 80px;max-width: 245px;">
                        <option value=""><{t}>all<{/t}></option>
                        <{foreach from=$ordersPayStatus key=key item=item}>
                            <option value="<{$key}>"><{$item}></option>
                        <{/foreach}>
                    </select>
                    </td>
                </tr>
                <tr class="height50">
                    <td class="td_l_<{$language}>"><{t}>changeTime<{/t}><{t}>colon<{/t}></td>
                    <td colspan=2 class="td_r_<{$language}>">
                        <input type="text" name="condition[add_time_start]" class="input width150 f_left" value="" id="add_time_start"/>
                        <em class="line5 f_left"></em>
                        <input type="text" name="condition[add_time_end]" class="input width150 f_left" value="" id="add_time_end"/>
                    </td>
                    <td class="td_r_<{$language}>"><input class="submit height35" type="submit" value="<{t}>search<{/t}>" id="searchSubmit" /></td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="bottom">
    <p class="tabBtnGroup clearfix margin_top30">
        <!-- 根据data-flag切换面板 可以自行定义-->
        <a href="javascript:;" data-value="" class="tabBtn active" data-flag="all"><{t}>all<{/t}></a>
        <{foreach from=$ordersStatus key=key item=item}>
            <a href="javascript:;" data-value="<{$key}>" class="tabBtn" data-flag="all"><{$item}></a>
        <{/foreach}>
    </p>
    <div class="tabCon">
        <div class="tabPanel all">
            <div class="table">
                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th width="140"><{t}>refNo<{/t}></th>
                            <th width="140"><{t}>accCode<{/t}></th>
                            <th width="120"><{t}>plateCode<{/t}></th>
                            <th width="100"><{t}>changeTime<{/t}></th>
                            <th width="110"><{t}>orderAmount<{/t}></th>
                            <th width="100"><{t}>orderStatus<{/t}></th>
                            <th width="100"><{t}>payStatus<{/t}></th>
                            <th width="100"><{t}>operate<{/t}></th>
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
</div>
<!-- page -->
<script type="text/javascript">
    ETP.indexAction = 'list';
    ETP.url = '/seller/order/';
    ETP.getListData = function (json) {
        var ordersStatus = json.ordersStatus;
        var ordersPayStatus = json.ordersPayStatus;
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            var status = ordersStatus[val.E10] == undefined ? '<{t}>nodefined<{/t}>' : ordersStatus[val.E10];
            var payStatus = ordersPayStatus[val.E14] == undefined ? '<{t}>nodefined<{/t}>' : ordersPayStatus[val.E14];
            html += "<tr>";
            html += "<td>" + val.E1 + "</td>";
            html += "<td>" + val.E3 + "</td>";
            html += "<td>" + val.E2 + "</td>";
            html += "<td>" + val.E21 + "</td>";
            html += "<td>" + val.E9 +'&nbsp;'+ val.E11 + "</td>";
            html += "<td>" + status + "</td>";
            html += "<td>" + payStatus + "</td>";
            html += '<td>';
            html += '<a href="/seller/order/detail?parmId='+val.E0 +'" class="view_link" data-toggle="tooltip" data-placement="right" title="<{t}>orderDetail<{/t}>"><span class="glyphicon glyphicon glyphicon-list-alt"></span></a>';
            /*
            if(val.pay_status != 1){
            html += '<a href="/seller/order/pay-order?orderCode='+val.E1 +'" class="view_link margin_left10" data-toggle="tooltip" data-placement="right" title="<{t}>payNow<{/t}>"><span class="glyphicon glyphicon glyphicon-shopping-cart"></span></a>';
            }
            */
            html += '</td>';
            html += "</tr>";
        });
        return html;
    }
    $(function (){
        //时间控件
        $('#add_time_start').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            <{if $language == 'zh_CN'}>language: 'zh-CN',<{/if}>
        });
        $('#add_time_end').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            <{if $language == 'zh_CN'}>language: 'zh-CN',<{/if}>
        });
        //获取详情数据
        /*
        $('.view-modal-btn').click(function (){
            var buyer_withdraw_id = $(this).attr('data-buyer_withdraw_id');
            alert(buyer_withdraw_id);
            var view_body = $('#view_body');
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                url: '/seller/portal/cash-view',
                data: {'buyer_withdraw_id': buyer_withdraw_id},
                error: function () {
                },
                success: function (json) {
                    console.log(json);
                    if(json.state == 1){
                        $.each( json.data, function(key, val) {
                            //写入数据
                            $('#'+key+'_span').html(val);
                        });
                    }else {
                        view_body.empty();
                        view_body.html(json.msg);
                    }
                }
            });
            //显示dialog
            //$('#viewModal').modal('show');
        });
        */
    });
</script>