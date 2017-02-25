<style type="text/css">
.m_colContainer .col-r .form_item .tit { width: auto; }
<{if $languageTpl == 'en_US'}>
.m_colContainer .col-r .bottom .tabBtnGroup .tabBtn { padding: 0 20px 0 20px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>tradeOrderList<{/t}></p>
    <div class="t_w2 border_b_line"></div>
    <div class="form_group clearfix">
        <form id="searchForm" method="post" action="" onsubmit="return false">
            <input type="hidden" value="" name="condition[order_status]" id="status" />
            <div class="cl">
                <div class="form_item clearfix f_left">
                    <span class="tit f_left"><{t}>refNo<{/t}>：</span>
                    <div class="dl f_left">
                        <input type="text" name="condition[order_code]" class="input w198"/>
                    </div>
                </div>
                <div class="form_item  f_left margin_left20 clearfix">
                    <span class="tit f_left"><{t}>accCode<{/t}>：</span>
                    <div class="dl f_left">
                        <input type="text" name="condition[reference_no]" class="input w198"/>
                    </div>
                </div>
            </div>
            <div class="form_item cl">
                <span class="tit f_left"><{t}>plateCode<{/t}>：</span>
                <div class="dl f_left">
                    <select name="condition[plate_code]" id="plate_code" class="selBox" style="min-width: 80px;max-width: 245px;">
                        <option value=""><{t}>all<{/t}></option>
                        <{foreach from=$platefrom key=key item=item}>
                            <option value="<{$key}>"><{$item}></option>
                        <{/foreach}>
                    </select>
                </div>
                <span class="tit f_left margin_left20"><{t}>payStatus<{/t}>：</span>
                <div class="dl f_left">
                    <select name="condition[pay_status]" id="pay_status" class="selBox" style="min-width: 80px;max-width: 245px;">
                        <option value=""><{t}>all<{/t}></option>
                        <{foreach from=$ordersPayStatus key=key item=item}>
                            <option value="<{$key}>"><{$item}></option>
                        <{/foreach}>
                    </select>
                </div>
            </div>
            <div class="cl">
                <div class="form_item f_left clearfix">
                    <span class="tit f_left"><{t}>changeTime<{/t}>：</span>
                    <div class="dl f_left">
                        <input type="text" name="condition[add_time_start]" class="input w160 f_left" value="" id="add_time_start"/>
                        <span class="add-on"><i class="icon-th"></i></span>
                        <em class="em f_left"></em>
                        <input type="text" name="condition[add_time_end]" class="input w160 f_left" value="" id="add_time_end"/>
                    </div>
                    <input class="submit margin_left30" type="submit" value="<{t}>Confirm<{/t}><{t}>submit<{/t}>" id="searchSubmit" />
                </div>
            </div>
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
                            <th width="120"><{t}>accCode<{/t}></th>
                            <th width="100"><{t}>plateCode<{/t}></th>
                            <th width="100"><{t}>changeTime<{/t}></th>
                            <th width="100"><{t}>orderAmount<{/t}></th>
                            <th width="80"><{t}>orderStatus<{/t}></th>
                            <th width="80"><{t}>payStatus<{/t}></th>
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
<script type='text/javascript' src="/etp_style_v1.0/js/common-page.js"></script>
<script type="text/javascript">
    ETP.indexAction = 'list';
    ETP.url = '/portal/purchaser-order/';
    ETP.getListData = function (json) {
        var ordersStatus = json.ordersStatus;
        var ordersPayStatus = json.ordersPayStatus;
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            var status = ordersStatus[val.order_status] == undefined ? '<{t}>nodefined<{/t}>' : ordersStatus[val.order_status];
            var payStatus = ordersPayStatus[val.pay_status] == undefined ? '<{t}>nodefined<{/t}>' : ordersPayStatus[val.pay_status];
            html += "<tr>";
            html += "<td>" + val.order_code + "</td>";
            html += "<td>" + val.reference_no + "</td>";
            html += "<td>" + val.plate_code + "</td>";
            html += "<td>" + val.add_time + "</td>";
            html += "<td>" + val.order_currency +'&nbsp;'+ val.order_amount + "</td>";
            html += "<td>" + status + "</td>";
            html += "<td>" + payStatus + "</td>";
            html += '<td>';
            html += '<a href="/portal/purchaser-order/detail?orderCode='+val.order_code+'" class="view_link" data-toggle="tooltip" data-placement="right" title="<{t}>orderDetail<{/t}>"><span class="glyphicon glyphicon-list-alt"></span></a>';
            if(val.pay_status != 1){
                html += '<a href="/portal/purchaser-order/pay-order?orderCode='+val.order_code+'" class="view_link margin_left10" data-toggle="tooltip" data-placement="right" title="<{t}>payNow<{/t}>"><span class="glyphicon glyphicon-shopping-cart"></span></a>';
            }
            if(val.order_status == 1 || val.order_status == 3){
                html += '<a href="/portal/purchaser-order/cancle-order?orderCode='+val.order_code+'" class="view_link margin_left10" data-toggle="tooltip" data-placement="right" title="<{t}>cancelOrder<{/t}>"><span class="glyphicon glyphicon-trash"></span></a>';
            }
            html += '</td>';
            html += "</tr>";
        });
        return html;
    }
    $(function (){
        //时间控件
        $('#add_time_start').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            <{if $languageTpl == 'zh_CN'}>language: 'zh-CN',<{/if}>
        });
        $('#add_time_end').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            <{if $languageTpl == 'zh_CN'}>language: 'zh-CN',<{/if}>
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
                url: '/portal/purchaser/cash-view',
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