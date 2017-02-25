<style type="text/css">
.m_colContainer .col-r .form_item .tit { width: auto; }
<{if $languageTpl == 'en_US'}>
.m_colContainer .col-r .bottom .tabBtnGroup .tabBtn { padding: 0 20px 0 20px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>withdrawList<{/t}></p>
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
                </div>
            </div>
            <div class="form_item cl">
                <span class="tit f_left"><{t}>cashType<{/t}>：</span>
                <div class="dl f_left">
                    <select name="condition[cash_type]" id="" class="selBox" style="min-width: 80px;max-width: 245px;">
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
        <{foreach from=$payStatus key=key item=item}>
            <a href="javascript:;" data-value="<{$item.bussiness_value}>" class="tabBtn" data-flag="all"><{if language=='zh_CN'}><{$item.bussiness_value_name}><{else}><{$item.bussiness_value_en}><{/if}></a>
        <{/foreach}>
        <a href="javascript:;" data-value="" class="tabBtn" data-flag="all">全部</a>
    </p>
    <div class="tabCon">
        <div class="tabPanel all">
            <div class="table">
                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th height="30" width="16%">
                                流水号
                            </th>
                            <th width="16%">
                                关联单号
                            </th>
                            <th width="16%">
                                交易平台
                            </th>
                            <th width="16%">
                                创建时间
                            </th>
                            <th width="16%">
                                交易金额
                            </th>
                            <th width="16%">
                                状态
                            </th>
                        </tr>
                    </thead>
                    <tbody id="grid_body"><tr><td colspan=6 height="30px"></td></tr></tbody>
                </table>
                <!-- 新增分页-->
                <div class="pageInfo">
                    <ul class="pagination" id="pagination"></ul>
                </div>
            </div>
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
    ETP.url = '/portal/record/trade-order-';
    ETP.getListData = function (json) {
        var cashStatus = json.cashStatus;
        var cashType = json.cashType;
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {

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
        $('.view_link').tooltip();
    });
</script>