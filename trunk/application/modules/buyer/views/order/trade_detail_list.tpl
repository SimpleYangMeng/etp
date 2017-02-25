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
                    <span class="tit f_left">　<{t}>refNo<{/t}><{t}>colon<{/t}></span>
                    <div class="dl f_left">
                        <input type="text" name="condition[reference_code]" class="input w198"/>
                    </div>
                </div>
                <div class="form_item f_left clearfix margin_left20">
                    <span class="tit f_left"><{t}>changeTime<{/t}><{t}>colon<{/t}></span>
                    <div class="dl f_left">
                        <input type="text" name="condition[add_time_start]" class="input w160 f_left" value="" id="add_time_start"/>
                        <span class="add-on"><i class="icon-th"></i></span>
                        <em class="em f_left"></em>
                        <input type="text" name="condition[add_time_end]" class="input w160 f_left" value="" id="add_time_end"/>
                    </div>
                </div>
            </div>
            <div class="cl">
                <div class="form_item  f_left clearfix">
                    <span class="tit f_left"><{t}>tradeType<{/t}><{t}>colon<{/t}></span>
                    <div class="dl f_left">
                        <select name="condition[change_type]" id="" class="selBox198">
                            <option value=""><{t}>all<{/t}></option>
                            <{foreach from=$changeType key=key item=item}>
                                <option value="<{$key}>"><{$item}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
                <div class="form_item f_left clearfix">
                    <input class="submit margin_left10" type="submit" value="<{t}>search<{/t}>" id="searchSubmit" />
                    <input class="submit margin_left10" type="button" value="<{t}>exportData<{/t}>" id="exportBtn" data-toggle="modal" data-target="#dialog_export"/>
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
                <form name="exportForm" id="exportForm">
                    <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                                <th class="table-checkbox" style="width:40px"><input class="checkAll" type="checkbox" /></th>
                                <th width="100"><{t}>refNo<{/t}></th>
                                <th width="80"><{t}>type<{/t}></th>
                                <th width="120"><{t}>changeTime<{/t}></th>
                                <th width="100"><{t}>AvaBalance<{/t}></th>
                                <th width="100"><{t}>forFrozenValue<{/t}></th>
                                <th width="100"><{t}>presentValue<{/t}></th>
                            </tr>
                        </thead>
                        <tbody id="grid_body"></tbody>
                    </table>
                </form>
                <!-- 新增分页-->
                <div class="pageInfo">
                    <ul class="pagination" id="pagination"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dialog_export" class="modal fade" role="dialog" aria-labelledby="dialog_bankLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">
                <{t}>exportData<{/t}>
            </h4>
        </div>
        <div class="modal-body">
            <input type="hidden" name="exportPostData" id="exportPostData" value="" />
            <label><input type="radio" name="exportType" value="1" checked="checked"><{t}>selectRow<{/t}></label>
            <label class="margin_left15"><input type="radio" name="exportType" value="0"><{t}>all<{/t}></label>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="exportDataBtn" data-dismiss="modal"><{t}>exportData<{/t}></button>
            <button type="button" class="btn btn-default" data-dismiss="modal"><{t}>cancel<{/t}></button>
        </div>
    </div>
    </div>
</div>

<!-- 未选择提示 begin -->
<input class="submit margin_left10" type="button" value="<{t}>notice<{/t}>" id="noticeBtn" data-toggle="modal" data-target="#oneNotice" style="display: none;"/>
<div id="oneNotice" class="modal fade" role="dialog" aria-labelledby="dialog_bankLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h4 class="modal-title" id="myModalLabel">
                <{t}>notice<{/t}>
            </h4>
        </div>
        <div class="modal-body">
            <{t}>pleaseSelectedOne<{/t}>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><{t}>cancel<{/t}></button>
        </div>
    </div>
    </div>
</div>
<!-- 未选择提示 end -->

<script type="text/javascript">
    ETP.url = '/buyer/order/trade-detail-';
    ETP.getListData = function (json) {
        var changeType = json.changeType;
        var html = '';
        $.each(json.data, function (key, val) {
            var rowchangeType = changeType[val.E13] == undefined ? '<{t}>nodefined<{/t}>' : changeType[val.E13];
            html += "<tr>";
            html += '<td><input class="cblidArr" name="cblidArr[]" type="checkbox" value="'+val.E0 +'"/></td>'
            html += "<td>" + val.E2 + "</td>";
            html += "<td>" + rowchangeType + "</td>";
            html += "<td>" + val.E14 + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.E3 +'<br /><{t}>changeAfter<{/t}>:'+ val.E4 + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.E9 +'<br /><{t}>changeAfter<{/t}>:'+ val.E10 + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.E11 +'<br /><{t}>changeAfter<{/t}>:'+ val.E12 + "</td>";
            //html += '<td><button type="button" class="btn btn-default btn-sm view-modal-btn" data-toggle="modal" data-target="#viewModal" title="<{t}>cashView<{/t}>" data-buyer_withdraw_id="'+val.buyer_withdraw_id+'"><span class="glyphicon glyphicon-list-alt"></span></button></td>';
            //html += '<td><a href="/buyer/pay-order-record/purchaser-pay-order-detail?parmId='+val.order_pay_id+'" class="view_link" data-toggle="tooltip" data-placement="right" title="<{t}>detail<{/t}>"><span class="glyphicon glyphicon glyphicon-list-alt"></span></a></td>';
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
        //全选
        $(".checkAll").click(function () {
            $(this).EzCheckAll($(".cblidArr"));
        });
        //数据导出
        $('#exportDataBtn').click(function (){
            var exportType = $('[name=exportType]:checked').val();
            var postData = '';
            if(exportType=='1'){
                //console.log($('.cblidArr:checked'));
                var checkedSizesize = $('.cblidArr:checked').size();
                if(checkedSizesize<=0){
                    $('#noticeBtn').click();
                    return;
                }
                /*
                var cblidValueArr = [];
                $('.cblidArr:checked').each(function (){
                    cblidValueArr.push($(this).val());
                });
                postData = {'exportTypeValue': exportType, 'cblidArr': cblidValueArr};
                */
                $('#exportForm').attr('action', '/buyer/order/trade-detail-export/exportType/'+exportType);
                $('#exportForm').attr('method', 'POST');
                $('#exportForm').submit();
                $('#exportForm').removeAttr('action');
                $('#exportForm').removeAttr('method');
            }else if(exportType=='0'){
                /*
                $('#exportTypeValue').val(exportType);
                postData = ETP.searchObj.serializeArray();
                $('#exportPostData').val(postData);
                */
                $('#exportForm').attr('action', '/buyer/order/trade-detail-export/exportType'+exportType);
                $('#exportForm').attr('method', 'POST');
                $('#exportForm').submit();
            }
            /*
            $.ajax({
                type: "POST",
                async: false,
                dataType: "jsonp",
                url: '/buyer/order/trade-detail-export',
                data: postData,
                beforeSend: function (request){
                    request.setRequestHeader("Pragma", "public");
                    request.setRequestHeader("Content-Type", "application/x-msexecl;name=aa.xls");
                    request.setRequestHeader("Content-Disposition", "inline;filename=aa.xls");
                },
                error: function () {},
                success: function (json) {
                    window.open(json);
                }
            });
            */
        });
    });
</script>