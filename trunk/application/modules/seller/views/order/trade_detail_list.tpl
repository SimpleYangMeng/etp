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
            <table>
                <tr class="height50">
                    <td class="td_l_<{$language}> <{if $language=='zh_CN'}>width130<{else}>width130<{/if}>"><{t}>refNo<{/t}><{t}>colon<{/t}></td>
                    <td class="width240 td_r_<{$language}>"><input type="text" name="condition[reference_code]" class="input width200"/></td>
                    <td class="td_l_<{$language}> <{if $language=='zh_CN'}>width130<{else}>width130<{/if}>"><{t}>tradeType<{/t}><{t}>colon<{/t}></td>
                    <td class="width240 td_r_<{$language}>">
                        <select name="condition[change_type]" id="" class="selBox" style="min-width: 80px;max-width: 245px;">
                            <option value=""><{t}>all<{/t}></option>
                            <{foreach from=$changeType key=key item=item}>
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
                    <td class="td_r_<{$language}>">
                        <input class="submit height35" type="submit" value="<{t}>search<{/t}>" id="searchSubmit" />
                        <input class="submit height35" type="button" value="<{t}>exportData<{/t}>" id="exportBtn" data-toggle="modal" data-target="#dialog_export"/>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>
<div class="bottom">
    <div class="tabCon">
        <div class="tabPanel all">
            <div class="table">
                <form name="exportForm" id="exportForm">
                    <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                        <thead>
                            <tr>
                                <th class="table-checkbox" style="width:40px"><input class="checkAll" type="checkbox" /></th>
                                <th width="100"><{t}>refNo<{/t}></th>
                                <th width="100"><{t}>type<{/t}></th>
                                <th width="120"><{t}>changeTime<{/t}></th>
                                <th width="100"><{t}>AvaBalance<{/t}></th>
                                <{if $language =='zh_CN'}>
                                <th width="100"><{t}>settlingValue<{/t}></th>
                                <th width="100"><{t}>settlingHoldValue<{/t}></th>
                                <{/if}>
                                <th width="100"><{t}>localAccountBalance<{/t}></th>
                                <th width="100"><{t}>foreignValue<{/t}></th>
                            </tr>
                        </thead>
                        <tbody id="grid_body"></tbody>
                    </table>
                    <div class="pageInfo">
                        <ul class="pagination" id="pagination"></ul>
                    </div>
                </form>
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
    ETP.url = '/seller/order/trade-detail-';
    ETP.getListData = function (json) {
        var changeType = json.changeType;
        var html = '';
        $.each(json.data, function (key, val) {
            var rowchangeType = changeType[val.E27] == undefined ? '<{t}>nodefined<{/t}>' : changeType[val.E27];
            html += "<tr>";
            html += '<td><input class="cblidArr" name="cblidArr[]" type="checkbox" value="'+val.E0 +'"/></td>'
            html += "<td>" + val.E1 + "</td>";
            html += "<td>" + rowchangeType + "</td>";
            html += "<td>" + val.E28 + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.E3 +'<br /><{t}>changeAfter<{/t}>:'+ val.E4 + "</td>";
            <{if $language =='zh_CN'}>
            html += "<td><{t}>changeBefore<{/t}>:" +val.E6 +'<br /><{t}>changeAfter<{/t}>:'+ val.E7 + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.E10 +'<br /><{t}>changeAfter<{/t}>:'+ val.E11 + "</td>";
            <{/if}>
            html += "<td><{t}>changeBefore<{/t}>:" +val.E20 +'<br /><{t}>changeAfter<{/t}>:'+ val.E21 + "</td>";
            html += "<td><{t}>changeBefore<{/t}>:" +val.E13 +'<br /><{t}>changeAfter<{/t}>:'+ val.E14 + "</td>";
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
                $('#exportForm').attr('action', '/seller/order/trade-detail-export/exportType/'+exportType);
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
                $('#exportForm').attr('action', '/seller/order/trade-detail-export/exportType'+exportType);
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