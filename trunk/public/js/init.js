//init
var EC = $.myProject.attach({});
var paginationTotal = 10;
var paginationPageSize = 20;
var paginationCurrentPage = 1;
var EZ = {
    version: '13.15.2.'+new Date().getDate(),
    exDate: new Date().getDate(),
    edit: '编辑',
    del: '删除',
    search: '搜索',
    create: '添加',
    deleteMessage: '确定要删除吗？',
    searchMessage: '没有找到记录，请调整搜索条件。',
    searchDefaultMessage: '请搜索...',
    url: '',
    listDate: '',
    editDialog: '',
    searchObj: '',
    callback: function () {
        return ''
    }
}

Array.prototype.remove = function (dx) {  
    if (isNaN(dx) || dx > this.length) {  
        return false;  
    }  
    for (var i = 0, n = 0; i < this.length; i++) {  
        if (this[i] != this[dx]) {  
            this[n++] = this[i];  
        }  
    }  
    this.length -= 1;  
};

$(function () {
    EZ.listDate = $("#table-module-list-data");
    EZ.editDialog = $("#ez-wms-edit-dialog");
    EZ.searchObj = $("#searchForm");
    $(".keyToSearch").keyup(function (e) {
        var key = e.which;
        if (key == 13) {
            try {
                submitSearch();
            } catch (s) {
                alertTip(s);
            }
        }
    });

    $(".submitReturnFalse").submit(function () {
        return false;
    });
});
/*3秒后刷新*/
function refresh_location(){
	
	setTimeout(function(){location.reload();},3000);
	

}
//refresh_location();
function alertTip(tip, width, height,times,focusId,voice) {
    if(voice===0 || voice===1){
        if(voice){
            doneVoice();
        }else{
            warmmingVoice();
        }
    }
    width = width ? width : 400;
    height = height ? height : 'auto';
    $('<div title="提示(Tip)" id="dialog-auto-alert-tip"><p align="">' + tip + '</p></div>').dialog({
        autoOpen: true,
        width: width,
        height: height,
        modal: true,
        show: "slide",
        buttons: [
            {
                text: '取消(Cancel)',
                click: function () {
                    $(this).dialog("close");
                }
            }
        ],
        close: function () {
            $(this).detach();
        }
    });

	if (typeof(times) == "number" && times > 0) {
        var msgshow = setTimeout(function() {
			$('#dialog-auto-alert-tip').dialog('close');
			if(focusId){
				$('#'+focusId).focus().select();
			}
        },
        times);
    }
}

function openIframeDialog(url, width, height) {
    iframe = '<iframe  class="dialogIframe" name="dialogIframe" scrolling="no" src="' + url + '"/>';
    $(iframe).dialog({
        autoResize: true,
        resizable: false,
        width: width + 30,
        modal: true,
        position: 'top',
        close: function () {
            $(this).remove();
        }
    }).width(width).height(height);
}
//弹窗方法
function openIframeDialogForCustom(url, width, height,title,objName) {
    title = title?title:'';
    objName = objName?objName:'dialogIframe';
    iframe = '<iframe class="'+objName+'" name="'+objName+'" scrolling="yes" src="' + url + '"/>';
    $(iframe).dialog({
        autoResize: true,
        resizable: false,
        width: width + 30,
        modal: true,
        position: 'top',
        title:title,
        close: function () {
            $(this).remove();
        }
    }).width(width).height(height);
}
function initOperate(){}
jQuery.fn.EzWmsSetSearchData = function (options) {
    var defaults = {
        msg: EZ.searchDefaultMessage,
        state: 0
    }
    var options = $.extend(defaults, options);
    if (options.state == '1' && options.msg == EZ.searchDefaultMessage) options.msg = EZ.searchMessage;
    if ($(this).children("tr").length < 1 || options.state == '1') {
        $(this).html('<tr class="table-module-b1"><td colspan=' + $(this).prev().children("tr").children("td").length + '>' + options.msg + '</td></tr>');
    }
    $(".pagination").html('');
}

jQuery.fn.EzCheckAll = function (obj) {
    if ($(this).is(':checked')) {
        obj.attr('checked', true);
    } else {
        obj.attr('checked', false);
    }
}


$.EzWmsConfirmDialog = function (options, Yfuns, Nfuns) {
    var defaults = {
        funData: [],
        paramId: 0,
        dWidth: "400",
        dHeight: "auto",
        dTitle: "Tips",
        dMessage: EZ.delMessage
    }
    var options = $.extend(defaults, options);
    $('<div title="' + options.dTitle + '" class="dialog-confirm-alert-tip">' + options.dMessage + '</div>').dialog({
        autoOpen: true,
        width: options.dWidth,
        height: options.dHeight,
        modal: true,
        show: "slide",
        buttons: {
            '确定(Ok)': function () {
                if (typeof(Yfuns) == "function") {
                    Yfuns(options.paramId);
                }
                $(this).dialog('close');
            },
            '取消(Cancel)': function () {
                if (typeof(Nfuns) == "function") {
                    Nfuns();
                }

                $(this).dialog('close');
            }
        },
        close: function () {
            $(this).detach();
        }
    });
};

$.EzWmsDel = function (options, Yfuns, Nfuns) {
    var defaults = {
        funData: [],
        Field: 'id',
        paramId: 0,
        url: '/',
        dWidth: "400",
        dHeight: "auto",
        dTitle: "Tips",
        successMsg: "",
        dMessage: EZ.deleteMessage
    }
    var options = $.extend(defaults, options);
    $('<div title="' + options.dTitle + '" class="dialog-confirm-del-alert-tip"><p style="text-align:left;font-size: 14px;color: red;font-weight: bold;">' + options.dMessage + '</p></div>').dialog({
        autoOpen: true,
        width: options.dWidth,
        height: options.dHeight,
        modal: true,
        show: "slide",
        buttons: {
            '确定(Ok)': function () {
                $.ajax({
                    type: "post",
                    async: false,
                    dataType: "json",
                    url: options.url,
                    data: options.Field + "=" + options.paramId,
                    success: function (json) {
                        var state = json && json.state ? json.state : 0;
                        var message = json && json.message ? json.message : options.successMsg;
                        if (state && typeof(Yfuns) == "function") {
                            Yfuns();
                        }
                        alertTip('<p style="text-align:left;font-size: 14px;color: red;font-weight: bold;">' + message + '</p>');
                    }
                });

                $(this).dialog('close');
            },
            '取消(Cancel)': function () {
                if (typeof(Nfuns) == "function") {
                    Nfuns();
                }

                $(this).dialog('close');
            }
        },
        close: function () {
            $(this).detach();
        }
    });
};

jQuery.fn.EzWmsEditDataDialog = function (options) {
    var defaults = {
        jsonData: {},
        Field: 'paramId',
        paramId: 0,
        url: '/',
        editUrl: '/',
        dWidth: "550",
        dHeight: "auto",
        dTitle: "系统操作/Operations",
        successMsg: "",
        getJsonSuccess: function (json) {
                if (json.state) {
                    $.each(json.data, function (k, v) {
                        $("[name=" + k + "]", "#dialog-edit-alert-tip").val(v);
                    });
                }
            }
    }
    var options = $.extend(defaults, options);
    var div = $(this);
    $('<div title="' + options.dTitle + '" id="dialog-edit-alert-tip" class="dialog-edit-alert-tip"><form id="editDataForm" name="editDataForm" class="submitReturnFalse">' + div.html() + '</form><div class="validateTips" id="validateTips"></div></div>').dialog({
        autoOpen: true,
        width: options.dWidth,
        height: options.dHeight,
        modal: true,
        show: "slide",
        buttons: [
            {
                text: "确定(Ok)",
                click: function () {
                    if (options.editUrl == '/') {
                        return;
                    }
                    $("#editDataForm").submit();
                }
            },
            {
                text: "取消(Cancel)",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ], close: function () {
            $(this).detach();
        }
    });

    var getJson = function () {
        $.ajax({
            type: "post",
            async: false,
            dataType: "json",
            url: options.url,
            data: options.Field + "=" + options.paramId,
            success: options.getJsonSuccess
        });
    }

    var editSuccess = function (json) {
        switch (json.state) {
            case 1:
                $("#dialog-edit-alert-tip").dialog("close");
                initData(0);
                break;
            case 2:
                $("#dialog-edit-alert-tip").dialog("close");
                loadData(paginationCurrentPage, paginationPageSize);
                alertTip(json.message);
                break;
            default:
                var html = '';
                var tipObj = $("#validateTips");
                if (json.errorMessage == null)return;
                $.each(json.errorMessage, function (key, val) {
                    html += '<span class="tip-error-message">' + val + '</span>';
                });
                tipObj.html(html);
                break;
        }
    }
    if (options.url != '/' && options.paramId != '0') {
        getJson()
    }
    $("#editDataForm").myAjaxForm({api: options.editUrl, success: editSuccess});
}

function submitSearch() {
    initData(0);
}

function success(json) {
    switch (json.state) {
        case 1:
            initData(0);
            $(this).dialog('close');
            dialogClose = 1;
            break;
        case 2:
            loadData(paginationCurrentPage, paginationPageSize);
            dialogClose = 1;
            alertTip(json.message);
            break;
        default:
            var html = '';
            var tipObj = $("#validateTips");
            if (json.errorMsg == null)return;
            $.each(json.errorMsg, function (key, val) {
                html += '<span class="tip-error-message">' + val + '</span>';
            });
            tipObj.html(html);
            break;
    }
}

//Del
function deleteById(id) {
    if (id == '' || id == undefined) {
        return false;
    }
    $.EzWmsDel(
        {paramId: id,
            Field: "paramId",
            url: EZ.url + "delete"
        }, submitSearch
    );
}

//Edit
function editById(id,success) {
    var options = {
        paramId: id,
        url: EZ.url + "get-by-json",
        editUrl: EZ.url + "edit"
    }
    if(typeof success == 'function'){
        options.getJsonSuccess  =   success;
    }
    EZ.editDialog.EzWmsEditDataDialog(options);
}

function isJson(obj) {
    return typeof(obj) == "object" && Object.prototype.toString.call(obj).toLowerCase() == "[object object]" && !obj.length;
}

function loadData(page, pageSize) {
    EZ.listDate.myLoading();
    $.ajax({
        type: "POST",
        async: false,
        dataType: "json",
        url: EZ.url + "list/page/" + page + "/pageSize/" + pageSize,
        data: EZ.searchObj.serializeArray(),
        error: function () {			
            paginationTotal = 0;
            EZ.listDate.EzWmsSetSearchData({msg: 'The URL request error.'});
            return;
        },
        success: function (json) {
            if (!isJson(json)) {
                paginationTotal = 0;
                EZ.listDate.EzWmsSetSearchData({msg: 'Returns the data type error.'});
                return;
            }
			
            paginationTotal = json.total;			
            if (json.state == '1') {
                EZ.listDate.html(EZ.getListData(json));
            } else {
                json.state = 1;
                EZ.listDate.EzWmsSetSearchData(json);
            }

        }
    });
}

function windowHeight() {
    // Standard browsers (Mozilla, Safari, etc.)
    if (self.innerHeight)
        return self.innerHeight;
    // IE 6
    if (document.documentElement && document.documentElement.clientHeight)
        return document.documentElement.clientHeight;
    // IE 5
    if (document.body)
        return document.body.clientHeight;
    // Just in case.
    return 0;
}
function windowWidth() {
    // Standard browsers (Mozilla, Safari, etc.)
    if (self.innerWidth)
        return self.innerWidth;
    // IE 6
    if (document.documentElement && document.documentElement.clientWidth)
        return document.documentElement.clientWidth;
    // IE 5
    if (document.body)
        return document.body.clientWidth;
    // Just in case.
    return 0;
}

//头部选项卡菜单管理，注意ID必须加单引号传入
function leftMenu(id, title, url) {
	
	if(title=='二次分拣'){
		window.open(url); 
		return;
	}
    $(window.parent.document).find(".main-right>.guild>h2").css("background", "transparent");
    var menulen = $(window.parent.document).find(".main-right>.guild>h2").length;

    //读取菜单栏是否已经存在此标签，存在则不再添加
    obj = window.parent.document.getElementById("menu" + id);

    var showTitle;
    //标签太长则省略号
    if (title.length > 12) {
        showTitle = title.substring(0, 12) + "...";
    } else {
        showTitle = title;
    }
    if (obj == null) {
        if (menulen > 6) {
            saveAsMenu();
        }
        var tempOnclick = "leftMenu(" + "'" + id + "'" + ',\'' + title + '\',\'' + url + "\')";
        var tempOnclickLast = "closeMenu(this,'"+id+"')";
        var tempHtml = '<H2 style="cursor:pointer " id="' + "menu" + id + "" + '">';
        tempHtml = tempHtml + '<a style="float: left"  href="javascript:void(0)"';
        tempHtml = tempHtml + ' onclick="' + tempOnclick + '">' + showTitle + '</a>';
        tempHtml = tempHtml + '<span style="font-size:18px;padding-left: 8px;padding-right:0px;color:darkgray;float: left; " onclick="' + tempOnclickLast + '">×</span></H2>';

        $(window.parent.document).find(".main-right>.guild>h3").before(tempHtml);
    } else {
        obj.style.background = "#fff";
    }

    var tHtml = '';
    tHtml += '<iframe frameborder="0" src="' + url + '" width="100%" height="100%" id="iframe-container-' + id + '" name="iframe-container-' + id + '" class="iframe-container" ></iframe>';
	
    var iframeObj = $(window.parent.document).find(".iframe-container");
	
    iframeObj.hide();
    obj = $(window.parent.document).find("#iframe-container-" + id);
	
    if (obj.size() > 0) {
        if (url != obj.attr('src')) {
            obj.remove();
            $(window.parent.document).find("#main-right-container-iframe").append(tHtml);
        } else {
            obj.css('display', 'block');
        }
		
    } else {
        $(window.parent.document).find("#main-right-container-iframe").append(tHtml);
    }
    if (iframeObj.size() > 5) {
        iframeObj.eq(1).remove();
    }
    $.cookie('currentPage', id + '{|}' + url + '{|}' + title, {path: '/'});
}

function closeMenu(obj,thisId) {
    var id,title,url;
    var tmpOnclick=$(obj).parent().prev().children().attr("onclick");
   // alert(tmpOnclick);
    var tmpId=tmpOnclick.split(",")[0];
    id=tmpId.substring(tmpId.indexOf("'")+1,tmpId.length-1);

    var tmpTitle=tmpOnclick.split(",")[1];
    title=tmpTitle.substring(tmpTitle.indexOf("'")+1,tmpTitle.length-1);

    var tmpUrl=tmpOnclick.split(",")[2];
    url=tmpUrl.substring(tmpUrl.indexOf("'")+1,tmpUrl.length-2);
     $(obj).parent().remove();
    $(window.parent.document).find("#iframe-container-" + thisId).remove();
    leftMenu(id, title, url);
}
//关闭历史标签里的菜单
function closeHisMenu(obj){
    $(obj).parent().remove();
}

//历史区域点击事件
function leftMenuHis(id, title, url){
    showHistory();
    leftMenu(id, title, url);
}

//菜单保存到历史区域
function saveAsMenu() {
   // alert($(window.parent.document).find(".main-right>.guild>h2").eq(1).html());

    var id=$(window.parent.document).find(".main-right>.guild>h2").eq(1).attr("id");

    var obj= window.parent.document.getElementById("his"+id)
    if (obj==null)
    {
        //默认保存第二个元素页
        var saveHtml="<h4 id="+'his'+id+">"+$(window.parent.document).find(".main-right>.guild>h2").eq(1).html()+"</h4>";
        //替换关闭的方法，因为历史标签关闭时，不需要回到上一个标签
        saveHtml=saveHtml.replace("closeMenu","closeHisMenu");
        saveHtml=saveHtml.replace("leftMenu","leftMenuHis");

        $(window.parent.document).find(".main-right>.guild>h3>div").append(saveHtml);
    }
    $(window.parent.document).find(".main-right>.guild>h2").eq(1).remove();
}

function showHistory() {
    if ($(window.parent.document).find(".main-right>.guild>h3>div>h4").length > 0) {
        var menudisplay = document.getElementById("menuList").style.display;
        if (menudisplay == "none") {
            menudisplay = "block";
            $("#menuList").css("display", menudisplay);
            $("#menuBtn").attr("src", "/images/pack/bg_guild_drop02.gif");
        } else {
            menudisplay = "none";
            $("#menuBtn").attr("src", "/images/pack/bg_guild_drop01.gif");
        }
        $("#menuList").css("display", menudisplay);
    }
}

function clearHis(obj) {
    $(window.parent.document).find(".main-right>.guild>h3>div>h4").remove();
    $("#menuList").css("display", "none");
    $("#menuBtn").attr("src", "/images/pack/bg_guild_drop01.gif");
}

//过滤条件搜索
function searchFilterSubmit(inputname,value,obj){
    if(inputname!=null){
        $('input[name='+inputname+']',"#searchForm").attr('value',value);
        $(obj).parent().children("a").removeClass();
        $(obj).addClass('current');
        submitSearch();
    }
}

function toAdvancedSearch(){
    $("#search-module-baseSearch").hide();
    $(".input_text","#search-module-baseSearch").val('');
    $("#search-module-advancedSearch").show();
}

function toBaseSearch(){
    $("#search-module-baseSearch").show();
    $("#search-module-advancedSearch").hide();
    $(".input_text","#search-module-advancedSearch").val('');
}

function showThisSubMenu(obj,id){
    $(obj).children().children("a").addClass("menuiconahover");
    document.getElementById(id).style.display="block";
}

function closeThisSubMenu(obj,id){
    $(obj).children().children("a").removeClass("menuiconahover");
    document.getElementById(id).style.display="none";
}

function autoHeight() {
    var header_h = $("#header").height();
    // var w_ = windowWidth();
    var body_h = windowHeight();
    if (body_h < 600) {
        body_h = 600
    }
    var sidebarH=body_h - header_h - 14;
    $("#sidebar").css('height', sidebarH);
    $("#sidebarIcon").css('height', sidebarH);
    var menuObj=$("#menu-module");
    if(menuObj.height()>sidebarH-50){
        menuObj.css('overflow-y','auto').css('height',sidebarH-50);
    }
    $(".main-right-container").css('height', body_h - header_h - 69);
}
$(function () {
    autoHeight();
});
var resizeTimer = null;
window.onresize = function () {
    resizeTimer = resizeTimer ? null : setTimeout(autoHeight, 0);
}

//删除指定下标的元素
Array.prototype.remove=function(dx){
	if(isNaN(dx)||dx>this.length) return false;
    for(var i=0,n=0;i<this.length;i++){
		if(this[i]!=this[dx]){
			this[n++]=this[i]
        }
    }
    this.length-=1
}

function warmmingVoice(){
    warmmp3.play();
    return;
}

function doneVoice(){
    donemp3.play();
    return;
}