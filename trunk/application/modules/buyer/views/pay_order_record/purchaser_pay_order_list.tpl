<style type="text/css">
.m_colContainer .col-r .form_item .tit { width: auto; }
<{if $languageTpl == 'en_US'}>
.m_colContainer .col-r .bottom .tabBtnGroup .tabBtn { padding: 0 20px 0 20px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>payOrder<{/t}></p>
    <div class="t_w2 border_b_line"></div>
    <div class="form_group clearfix">
        <form id="searchForm" method="post" action="" onsubmit="return false">
            <input type="hidden" value="" name="condition[status]" id="status" />
            <div class="cl">
                <div class="form_item clearfix f_left">
                    <span class="tit f_left" style="width:130px;"><{t}>payNo<{/t}><{t}>colon<{/t}></span>
                    <div class="dl f_left">
                        <input type="text" name="condition[pay_no]" class="input w198"/>
                    </div>
                </div>
                <div class="form_item f_left clearfix margin_left20">
                    <span class="tit f_left"><{t}>payTime<{/t}><{t}>colon<{/t}></span>
                    <div class="dl f_left">
                        <input type="text" name="condition[pay_time_start]" class="input w160 f_left" value="" id="pay_time_start"/>
                        <span class="add-on"><i class="icon-th"></i></span>
                        <em class="em f_left"></em>
                        <input type="text" name="condition[pay_time_end]" class="input w160 f_left" value="" id="pay_time_end"/>
                    </div>
                </div>
            </div>
            <div class="cl">
                <div class="form_item  f_left clearfix">
                    <span class="tit f_left" style="width:130px;"><{t}>orderCode<{/t}><{t}>colon<{/t}></span>
                    <div class="dl f_left">
                        <input type="text" name="condition[order_code]" class="input w198"/>
                    </div>
                </div>
                <div class="form_item f_left clearfix">
                    <div class="f_left margin_left20">
                        <input class="submit" type="submit" value="<{t}>search<{/t}>" id="searchSubmit" />
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="bottom">
    <p class="tabBtnGroup clearfix margin_top30">
        <!-- 根据data-flag切换面板 可以自行定义-->
        <a href="javascript:;" data-value="" class="tabBtn active" data-flag="all"><{t}>all<{/t}></a>
        <{foreach from=$payStatus key=key item=item}>
            <a href="javascript:;" data-value="<{$key}>" class="tabBtn" data-flag="all"><{$item}></a>
        <{/foreach}>
    </p>
    <div class="tabCon">
        <div class="tabPanel all">
            <!-- -->
            <div class="table">
                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th width="100"><{t}>payNo<{/t}></th>
                            <th width="80"><{t}>buyer<{/t}></th>
                            <th width="80"><{t}>seller<{/t}></th>
                            <th width="100"><{t}>orderCode<{/t}></th>
                            <th width="80"><{t}>orderAmount<{/t}></th>
                            <th width="140"><{t}>payTime<{/t}></th>
                            <th width="40"><{t}>operate<{/t}></th>
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
<script type="text/javascript">
    ETP.indexAction = 'pay-order-list';
    ETP.url = '/buyer/pay-order-record/';
    ETP.getListData = function (json) {
        //var status = json.status;
        var html = '';
        $.each(json.data, function (key, val) {
            //var rowStatus = status[val.E7] == undefined ? '<{t}>nodefined<{/t}>' : status[val.E7];
            html += "<tr>";
            html += "<td>" + val.E5 + "</td>";
            html += "<td>" + val.E2 + "</td>";
            html += "<td>" + val.E4 + "</td>";
            html += "<td>" + val.E10 + "</td>";
            html += "<td>" + val.E8 +'&nbsp;'+ val.E6 + "</td>";
            html += "<td>" + val.E13 + "</td>";
            //html += '<td><button type="button" class="btn btn-default btn-sm view-modal-btn" data-toggle="modal" data-target="#viewModal" title="<{t}>cashView<{/t}>" data-buyer_withdraw_id="'+val.buyer_withdraw_id+'"><span class="glyphicon glyphicon-list-alt"></span></button></td>';
            html += '<td><a href="/buyer/pay-order-record/pay-order-detail?parmId='+val.E0 +'" class="view_link" data-toggle="tooltip" data-placement="right" title="<{t}>detail<{/t}>"><span class="glyphicon glyphicon glyphicon-list-alt"></span></a></td>';
            html += "</tr>";
        });
        return html;
    }
    $(function (){
        //时间控件
        $('#pay_time_start').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            <{if $languageTpl == 'zh_CN'}>language: 'zh-CN',<{/if}>
        });
        $('#pay_time_end').datetimepicker({
            format: 'yyyy-mm-dd hh:ii',
            <{if $languageTpl == 'zh_CN'}>language: 'zh-CN',<{/if}>
        });
        //tips
        $('.view_link').tooltip();
    });
</script>