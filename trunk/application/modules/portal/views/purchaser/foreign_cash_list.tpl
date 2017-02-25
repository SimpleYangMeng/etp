<style type="text/css">
.m_colContainer .col-r .form_item .tit { width: auto; }
<{if $languageTpl == 'en_US'}>
.m_colContainer .col-r .bottom .tabBtnGroup .tabBtn { padding: 0 20px 0 20px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>withdrawList<{/t}></p>
    <div class="t_w2 border_b_line"></div>
    <div class="form_group clearfix">
        <form id="searchForm" method="post" action="" onsubmit="return false">
            <input type="hidden" value="" name="condition[status]" id="status" />
            <div class="cl">
                <div class="form_item clearfix f_left">
                    <span class="tit f_left"><{t}>cashAccount<{/t}>：</span>
                    <div class="dl f_left">
                        <input type="text" name="condition[bank_card]" class="input w198"/>
                    </div>
                </div>
                <div class="form_item  f_left margin_left20 clearfix">
                    <span class="tit f_left"><{t}>cashNo<{/t}>：</span>
                    <div class="dl f_left">
                        <input type="text" name="condition[withdraw_code]" class="input w198"/>
                    </div>
                </div>
            </div>
            <div class="cl">
                <div class="form_item f_left clearfix">
                    <span class="tit f_left"><{t}>changeTime<{/t}>：</span>
                    <div class="dl f_left">
                        <input type="text" name="condition[add_time_start]" class="input w160 f_left" value="" id="add_time_start"/>
                        <!--
                        <div class="input-group date form_datetime col-md-5" data-date="" data-date-format="yyyy-mm-dd hh:ii" data-link-field="dtp_input1">
                            <input class="form-control" size="16" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
                        </div>
                         -->
                        <span class="add-on"><i class="icon-th"></i></span>
                        <em class="em f_left"></em>
                        <input type="text" name="condition[add_time_end]" class="input w160 f_left" value="" id="add_time_end"/>
                    </div>
                </div>
            </div>
            <div class="form_item cl">
                <span class="tit f_left"><{t}>cashType<{/t}>：</span>
                <div class="dl f_left">
                    <select name="condition[cash_type]" id="" class="selBox" style="min-width: 80px;max-width: 245px;">
                        <{foreach from=$cashType key=key item=item}>
                            <option value="<{$key}>" <{if isset($condition.cash_type) && $condition.cash_type eq $key}>selected<{/if}>><{$item}></option>
                        <{/foreach}>
                    </select>
                </div>
                <div class="f_left">
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
        <{foreach from=$cashStatus key=key item=item}>
            <a href="javascript:;" data-value="<{$key}>" class="tabBtn" data-flag="all"><{$item}></a>
        <{/foreach}>
        <!--
        <a href="javascript:" class="tabBtn active" data-flag="cashing">提现中</a>
        <a href="javascript:" class="tabBtn" data-flag="suc-cash">提现成功</a>
        <a href="javascript:" class="tabBtn" data-flag="fail-cash">提现失败</a>
        -->
    </p>
    <div class="tabCon">
        <div class="tabPanel all">
            <!-- -->
            <div class="table">
                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <!--
                            <th class="table-checkbox" style="width:40px">
                                <input class="group-checkable" type="checkbox" />
                            </th>
                            -->
                            <th width="100"><{t}>cashNo<{/t}></th>
                            <th width="100"><{t}>cashAccount<{/t}></th>
                            <th width="80"><{t}>cashType<{/t}></th>
                            <th width="140"><{t}>changeTime<{/t}></th>
                            <th width="80"><{t}>cashAmount<{/t}></th>
                            <th width="60"><{t}>status<{/t}></th>
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
            <!-- 新增分页-->
            <!--
            <div class="pageBtn" id="pageBtn">
                <a class="prev">上一页</a>
                <a href="javascript:" class="cur">1</a>
                <a href="javascript:">2</a>
                <a href="javascript:">3</a>
                <a href="javascript:">4</a>
                <a href="javascript:">...</a>
                <a href="javascript:">99</a>
                <a href="javascript:" class="next">下一页</a>
                <input type="text" class="textPager" id="txt_gotoPager" placeholder="">
                <a class="submit" href="javascript:">查询</a>
            </div>
            -->
        </div>
    </div>
</div>

<!-- view Modal -->
<div class="modal fade" id="viewModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog" style="width:780px;">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel"><{t}>view<{/t}></h4>
        </div>
        <div class="modal-body">
            <div class="top clearfix">
                <p class="dt" style="padding:0;"><{t}>withdrawList<{/t}> &gt; <{t}>cashView<{/t}></p>
            </div>
            <div class="bottom" id="view_body">
                <!-- 标签页结构 依据data-flag属性变化显示的面板-->
                <table width="100%" class="table table-bordered table-hover">
                    <tr>
                        <td class="tit"><{t}>cashNo<{/t}></td>
                        <td><span id="withdraw_code_span"></span></td>
                        <td class="tit"><{t}>cashType<{/t}></td>
                        <td>境内提现</td>
                    </tr>
                    <tr>
                        <td class="tit"><{t}>cashType<{/t}></td>
                        <td><span id="status_text_span"></span></td>
                        <td class="tit"><{t}>cashBank<{/t}></td>
                        <td><span id="bank_name_span"></span></td>
                    </tr>
                    <tr>
                        <td class="tit"><{t}>bankCardName<{/t}></td>
                        <td><span id="bank_buyer_name_span"></span></td>
                        <td class="tit"><{t}>bankCardNum<{/t}></td>
                        <td><span id="bank_card_span"></span></td>
                    </tr>
                    <tr>
                        <td class="tit"><{t}>cashCurrency<{/t}></td>
                        <td><span id="currency_span"></span></td>
                        <td class="tit"><{t}>cashAmount<{/t}></td>
                        <td><span id="amount_span"></span></td>
                    </tr>
                    <tr>
                        <td class="tit" style="height: 100px;"><{t}>remark<{/t}></td>
                        <td colspan="3"><span id="note_span"></span></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><{t}>close<{/t}></button>
        </div>
    </div>
  </div>
</div>


<script type='text/javascript' src="/etp_style_v1.0/js/common-page.js"></script>
<script type="text/javascript">
    ETP.indexAction = 'cash-list';
    ETP.url = '/portal/purchaser/';
    ETP.getListData = function (json) {
        var cashStatus = json.cashStatus;
        var cashType = json.cashType;
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            var status = cashStatus[val.status] == undefined ? '<{t}>nodefined<{/t}>' : cashStatus[val.status];
            html += "<tr>";
            html += "<td>" + val.withdraw_code + "</td>";
            html += "<td>" + val.bank_card + "</td>";
            //暂时只有境外提现
            html += "<td>" + cashType[1] + "</td>";
            html += "<td>" + val.add_time + "</td>";
            html += "<td>" + val.currency +'&nbsp;'+ val.amount + "</td>";
            html += "<td>" + status + "</td>";
            //html += '<td><button type="button" class="btn btn-default btn-sm view-modal-btn" data-toggle="modal" data-target="#viewModal" title="<{t}>cashView<{/t}>" data-buyer_withdraw_id="'+val.buyer_withdraw_id+'"><span class="glyphicon glyphicon-list-alt"></span></button></td>';
            html += '<td><a href="/portal/purchaser/cash-view-detail?parmId='+val.buyer_withdraw_id+'" class="view_link" data-toggle="tooltip" data-placement="right" title="<{t}>cashView<{/t}>"><span class="glyphicon glyphicon glyphicon-list-alt"></span></a></td>';
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
        //tips
        $('.view_link').tooltip();
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