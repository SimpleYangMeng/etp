<style type="text/css">
.m_colContainer .col-r .form_item .tit { width: auto; }
<{if $language == 'en_US'}>
.m_colContainer .col-r .bottom .tabBtnGroup .tabBtn { padding: 0 20px 0 20px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>tradeOrderDetail<{/t}></p>
    <div class="t_w2 border_b_line"></div>
    <div class="form_group clearfix">
        <form id="searchForm" method="post" action="" onsubmit="return false">
            <input type="hidden" value="" name="condition[status]" id="status" />
            <div class="cl">
                <div class="form_item clearfix f_left">
                    <span class="tit f_left"><{t}>refNo<{/t}>：</span>
                    <div class="dl f_left">
                        <input type="text" name="condition[reference_code]" class="input w198"/>
                    </div>
                </div>
                <div class="form_item  f_left margin_left20 clearfix">
                    <span class="tit f_left"><{t}>tradeType<{/t}>：</span>
                    <div class="dl f_left">
                        <select name="condition[change_type]" id="" class="selBox" style="min-width: 80px;max-width: 245px;">
                            <option value=""><{t}>all<{/t}></option>
                            <{foreach from=$changeType key=key item=item}>
                                <option value="<{$key}>"><{$item}></option>
                            <{/foreach}>
                        </select>
                    </div>
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
                    <input class="submit margin_left10" type="submit" value="<{t}>Confirm<{/t}><{t}>submit<{/t}>" id="searchSubmit" />
                </div>
            </div>
        </form>
    </div>
</div>
<div class="bottom">
    <!--
    <p class="tabBtnGroup clearfix margin_top30">
        <a href="javascript:;" data-value="" class="tabBtn active" data-flag="all"><{t}>all<{/t}></a>
        <{foreach from=$payStatus key=key item=item}>
            <a href="javascript:;" data-value="<{$key}>" class="tabBtn" data-flag="all"><{$item}></a>
        <{/foreach}>
    </p>
    -->
    <div class="tabCon">
        <div class="tabPanel all">
            <div class="table">
                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th width="100"><{t}>refNo<{/t}></th>
                            <th width="80"><{t}>type<{/t}></th>
                            <th width="120"><{t}>changeTime<{/t}></th>
                            <th width="100"><{t}>AvaBalance<{/t}></th>
                            <th width="100"><{t}>frozenValue<{/t}></th>
                            <th width="100"><{t}>logisticsChangeValue<{/t}></th>
                            <th width="100"><{t}>localAccountBalance<{/t}></th>
                            <th width="100"><{t}>presentValue<{/t}></th>
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
<script type='text/javascript' src="/etp_style_v1.0/js/common-page.js"></script>
<script type="text/javascript">
    ETP.indexAction = 'trade-order';
    ETP.url = '/portal/purchaser-order/';
    ETP.getListData = function (json) {
        var changeType = json.changeType;
        var html = '';
        $.each(json.data, function (key, val) {
            var rowchangeType = changeType[val.change_type] == undefined ? '<{t}>nodefined<{/t}>' : changeType[val.change_type];
            html += "<tr>";
            html += "<td>" + val.reference_code + "</td>";
            html += "<td>" + rowchangeType + "</td>";
            html += "<td>" + val.add_time + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.cb_value+'<br /><{t}>changeAfter<{/t}>:'+ val.cb_value_change + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.cb_hold_value+'<br /><{t}>changeAfter<{/t}>:'+ val.cb_hold_value_change + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.cb_debit_value+'<br /><{t}>changeAfter<{/t}>:'+ val.cb_debit_value_change + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.cb_withdraw_hold_value+'<br /><{t}>changeAfter<{/t}>:'+ val.cb_withdraw_hold_value_change + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.cb_withdraw_value+'<br /><{t}>changeAfter<{/t}>:'+ val.cb_withdraw_value_change + "</td>";
            //html += '<td><button type="button" class="btn btn-default btn-sm view-modal-btn" data-toggle="modal" data-target="#viewModal" title="<{t}>cashView<{/t}>" data-buyer_withdraw_id="'+val.buyer_withdraw_id+'"><span class="glyphicon glyphicon-list-alt"></span></button></td>';
            //html += '<td><a href="/portal/transaction/purchaser-pay-order-detail?parmId='+val.order_pay_id+'" class="view_link" data-toggle="tooltip" data-placement="right" title="<{t}>detail<{/t}>"><span class="glyphicon glyphicon glyphicon-list-alt"></span></a></td>';
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
        //tips
        $('.view_link').tooltip();
    });
</script>