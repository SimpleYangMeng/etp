<style type="text/css">
.m_colContainer .col-r .form_item .tit { width: auto; }
<{if $language == 'en_US'}>
.m_colContainer .col-r .bottom .tabBtnGroup .tabBtn { padding: 0 20px 0 20px; }
<{/if}>
</style>
<div class="top clearfix">
    <p class="dt"><{t}>settlementList<{/t}></p>
    <div class="t_w2 border_b_line"></div>
    <div class="form_group clearfix">
        <form id="searchForm" method="post" action="" onsubmit="return false">
            <input type="hidden" value="" name="status" id="status" />
            <div class="cl">
                <div class="form_item clearfix f_left">
                    <span class="tit f_left"><{t}>cashAccount<{/t}><{t}>colon<{/t}></span>
                    <div class="dl f_left">
                        <input type="text" name="cardNo" class="input w198"/>
                    </div>
                </div>
                <div class="form_item f_left clearfix margin_left20">
                    <span class="tit f_left"><{t}>changeTime<{/t}><{t}>colon<{/t}></span>
                    <div class="dl f_left">
                        <input type="text" name="cDateStart" class="input w160 f_left" value="" id="add_time_start"/>
                        <span class="add-on"><i class="icon-th"></i></span>
                        <em class="em f_left"></em>
                        <input type="text" name="cDateEnd" class="input w160 f_left" value="" id="add_time_end"/>
                    </div>
                </div>
            </div>
            <div class="form_item cl">
                <{if !empty($withdrawType)}>
                <span class="tit f_left"><{t}>cashType<{/t}>：</span>
                <div class="dl f_left">
                    <select name="withdrawType" id="" class="selBox" style="min-width: 80px;max-width: 245px;">
                    <option value=""><{t}>pleaseSelected<{/t}></option>
                    <{foreach from=$withdrawType key=key item=item}>
                    <option value="<{$key}>"><{$item}></option>
                    <{/foreach}>
                    </select>
                </div>
                <{/if}>
                <div class="f_left">
                    <input class="submit" type="submit" value="<{t}>search<{/t}>" id="searchSubmit" />
                </div>
            </div>
        </form>
    </div>
</div>
<div class="bottom">
    <p class="tabBtnGroup clearfix margin_top30">
        <a href="javascript:;" data-value="" class="tabBtn active" data-flag="all"><{t}>all<{/t}></a>
        <{foreach from=$status key=key item=item}>
            <a href="javascript:;" data-value="<{$key}>" class="tabBtn" data-flag="all"><{if $language == 'zh_CN'}><{$item.bussiness_value_name}><{else}><{$item.bussiness_value_en}><{/if}></a>
        <{/foreach}> 
    </p>
    <div class="tabCon">
        <div class="tabPanel all">
            <div class="table">
                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                    <thead>
                        <tr>
                            <th height="30" width="16%">
                                <{t}>settlementCode<{/t}>
                            </th>
                            <th width="16%">
                                <{t}>applyTime<{/t}>
                            </th>
                            <th width="18%">
                                <{t}>needsettlingValue<{/t}>
                            </th>
                            <th width="16%">
                                <{t}>status<{/t}>
                            </th>
                            <th width="16%">
                                <{t}>operate<{/t}>
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
<script type="text/javascript">
    ETP.url = '/seller/settlement/';
    ETP.getListData = function (json) {
        var html = '';
        var i = paginationCurrentPage < 1 ? 1 : paginationPageSize * (paginationCurrentPage - 1) + 1;
        $.each(json.data, function (key, val) {
            html += '<tr><td>'+ val.E1 +'</td>';
            html += '<td>'+val.E17+'</td>';
            html += '<td>'+ val.E10 +' ' + val.E11  +'</td>';
            html += '<td>'+ val.E2_0 +'</td>';
            html += '<td><a href="/seller/settlement/view-detail?paramId='+val.E0+'" class="view_link" data-toggle="tooltip" data-placement="right" title="<{t}>detail<{/t}>"><span class="glyphicon glyphicon glyphicon-list-alt"></span></a></td></tr>';

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