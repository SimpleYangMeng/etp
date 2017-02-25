//设置总页数.
var paginationTotal = 0;
//每页显示数据条数
var paginationPageSize = 5;
//设置控件显示的页码数.即：类型为"page"的操作按钮的数量。
var numberOfPages = 5;
//当前页数
var paginationCurrentPage = 1;
var totalCount = 0;
var ETP = {
    version: '13.15.2.'+new Date().getDate(),
    exDate: new Date().getDate(),
    edit: '编辑',
    del: '删除',
    create: '添加',
    deleteMessage: '确定要删除吗？',
    searchMessage: '没有找到记录，请调整搜索条件。',
    searchDefaultMessage: '请搜索...',
    url: '',
    indexAction: 'list',
    listDate: '#grid_body',
    searchObj: '',
    searchSubmit: '',
    pageObj: '',
    loadingObj: '',
    loadingColor: '#00a0e9',
    callback: function () {
        return ''
    }
}

$(function () {
    ETP.searchObj = $("#searchForm");
    ETP.searchSubmit = $("#searchSubmit");
    ETP.pageObj = $('#pagination');
    ETP.loadingObj = $('.loading');
    //初始化数据
    //setTimeout(
        //function() {
            loadData(paginationCurrentPage, paginationPageSize);
            showPage();
        //}
    //, 1000);
    //搜索按钮
    ETP.searchSubmit.click(function (){
        submitSearch();
    });
    //类型
    $('.tabBtnGroup').find('a.tabBtn').each(function (){
        $(this).click(function (){
            $('.tabBtnGroup').find('a.tabBtn').each(function (){
                $(this).removeClass('active');
            });
            $(this).addClass('active');
            $('#status').val($(this).attr('data-value'));
            submitSearch();
        });
    });
});

function loadData(page, pageSize) {
    $(ETP.listDate).showLoading({addClass:'loading-indicator-circle-1'});
    $.ajax({
        type: "POST",
        async: false,
        dataType: "json",
        url: ETP.url + ETP.indexAction +"/page/" + page + "/pageSize/" + pageSize,
        data: ETP.searchObj.serializeArray(),
        error: function () {
            paginationTotal = 0;
            return;
        },
        success: function (json) {
            //
            paginationTotal = json.pageTotal;
            totalCount = json.total;
            if (json.state == '1' && totalCount > 0) {
                $(ETP.listDate).html(ETP.getListData(json));
            } else {
                var t = $(ETP.listDate).parent().find('tr');
                var l = $(t[0]).children().length;
                $(ETP.listDate).html('<tr><td colspan="'+l+'">no data</td></tr>');
            }
        }
    });
    $(ETP.listDate).hideLoading();
    //提示
    $('.view_link').tooltip();
}

//页面搜索
function submitSearch() {
    loadData(1, paginationPageSize);
    showPage();
}

//显示分页
function showPage () {
    if(totalCount > 0 && paginationTotal > 1){
        var pageDefaultOptions = {
            bootstrapMajorVersion: 3,
            currentPage: paginationCurrentPage,
            numberOfPages: numberOfPages,
            totalPages: paginationTotal,
            onPageChanged: function (event, oldPage, newPage){
                loadData(newPage, paginationPageSize);
            }
        }
        ETP.pageObj.bootstrapPaginator(pageDefaultOptions);
    }else {
        ETP.pageObj.empty();
    }
}

//注册全选事件
jQuery.fn.EzCheckAll = function (obj) {
    if ($(this).is(':checked')) {
        obj.attr('checked', true);
    } else {
        obj.attr('checked', false);
    }
}

/** [页面调用] */
/*
$(".checkAll").click(function () {
    $(this).EzCheckAll($(".ceive_code"));
});
*/