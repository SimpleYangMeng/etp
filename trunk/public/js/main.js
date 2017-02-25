//拖动
function LinkDrag(dragid, ctrlid, leftmargin, topmargin) {
	var dragid = document.getElementById(dragid);
	var ctrlid = document.getElementById(ctrlid);
	dragid.style.position = "absolute";
	if (!leftmargin) {
		var leftmargin = 246;
	}
	if (!topmargin) {
		var topmargin = 200;
	}
	if (!dragid.style.left) {
		dragid.style.left = leftmargin + "px";
	}
	if (!dragid.style.top) {
		dragid.style.top = topmargin + "px";
	}
	var posX = "";
	var posY = "";
	var DragZindexNumber = 9999;// 拖动层位置
	ctrlid.onmousedown = function(e) {
		if (!e)
			e = window.event;
		dragid.style.zIndex = DragZindexNumber++;
		posX = e.clientX - parseInt(dragid.style.left);
		posY = e.clientY - parseInt(dragid.style.top);
		document.onmousemove = function(e) {
			if (!e)
				e = window.event;
			dragid.style.left = e.clientX - posX + "px";
			dragid.style.top = e.clientY - posY + "px";
		}
	}
	ctrlid.onmouseup = function(e) {
		document.onmousemove = null;
	}
	document.onmouseup = function(e) {
		document.onmousemove = null;
	}
}
function container_pop_hide(){
	$("#container_pop").hide();
}
function container_pop_show(title,html,drag,width,left,top) {
	$("#container_pop").show();
	// 拖动
	var offset = $("#wrap").offset();
	var topoff = offset.top;
	var leftoff = 246;
	
	if(title){
		$("#container_pop_title").text(title);
	}
	if(html){
		$("#container_content").html(html);
	}

	if(left){
		$("#container_pop").css({
			left : left + "px"
		});
	}
	if(top){
		$("#container_pop").css({
			top : top + "px"
		});
	}
	if(width){
		$("#container_pop").css({
			width : width + "px"
		});
	}
	if(drag){
		LinkDrag("container_pop", "container_pop_head",left,top);
	}
}
//所有产品图片自动缩放
function initProductImgAdapt(wrap_w,wrap_h){
	$(".imgWrap img").each(function(){
        var this_ = $(this);
    	var img = new Image();
    	img.src = $(this).attr("src");
    	var wrapWidth = wrap_w?wrap_w:140;
    	var wrapHeight = wrap_h?wrap_h:140;
    	var marginLeft = 0;
    	var marginTop = 0;
    	var width_ = height_ = 0;
    	img.onload = function () {
    		var width  = this.width;
    		var height = this.height;

    		var  scale_org = wrapWidth/wrapHeight;

    		if (wrapWidth / width > wrapHeight / height)
    		{
    			height_ = wrapHeight;
    			width_ = width  * wrapHeight/height;
    		} else
    		{
    			width_ = wrapWidth;
    			height_ = height * wrapWidth/width;
    		}
    		marginLeft = (wrapWidth-width_)/2+1;
    		marginTop = (wrapHeight-height_)/2+1;
    		//alert(height_);
    		this_.get(0).style.width=width_+"px";
    		this_.get(0).style.height=height_+"px";
    		this_.get(0).style.marginLeft=marginLeft+"px";
    		this_.get(0).style.marginTop=marginTop+"px";
    		this_.get(0).style.display="";
    	};            
    });
}
var global_alertTip = "";
function alertTip(tip,width,height,flush) {
    width = width?width:500;
    height = height?height:'auto';
    $('<div title="信息提示(Esc)"><p align="">' + tip + '</p></div>').dialog({
        autoOpen: true,
        width: width,
        height: height,
        modal: true,
		position:[50,50],
        show:"slide",
        buttons: {            
            'Close': function() {
                $(this).dialog('close');
                if(flush=='1'){
                    window.location.reload();
                }
            }
        },
        close: function() {
            
        },
		open:function(){
			global_alertTip = this;
		}
    });
}

function isTools(needle, array) {
    var l = array.length;
    var i = 0;
    for (; i < l; i++) {
        if (array[i].toLowerCase().indexOf(needle) > -1) {
            return array[i];
        }
    }
    return '';
}

$(function () {
    $('.ecg_learn_more').click(function () {
        var off = $(this).offset();
        var classSArr = $(this).attr('class').split(' ');
        var className = 'ecg_learn_more_content';
        var toolsClassName = 'tools_';
        var toolsContentId = isTools(toolsClassName, classSArr);
        if (toolsContentId == '') {
            return;
        }
        var contentE = $("#" + toolsContentId + '_content');
        if (contentE.size() > 0) {
            container_pop_show('Note', contentE.html(), false, 300, off.left, off.top + 20);
        } else {
            container_pop_show('Note', 'Sorry ,There is No Content.', false, 300, off.left, off.top + 20);
        }

    });

    $('body').keyup(function (e) {
        var myevent = e || window.event;
        var key = e.which;
        if (key == 27) {
            container_pop_hide();
        }
    });

    $('.miniaccount').hover(function () {
        $.get('/merchant/my-account/get-Custumer-Balance', function (data) {
            $('.miniaccount .money').html(data.cb_value+' '+data.currency_code);
        }, 'json');
        $('.userlayer').show();
        $('.userlabel').addClass('useLaHover');
        $('.ico').addClass('icoHover');
    }, function () {
        $('.userlayer').hide();
        $('.userlabel').removeClass('useLaHover');
        $('.ico').removeClass('icoHover');
    })

    var h = document.body.clientHeight;
    h = h - 150;
    //$('.center').css('height',h);
    $(".left_sub_menu").click(function(){
        if($(this).next().css('display')=='block'){
            $(this).next().slideUp('medium');
            $(this).find('span').addClass('show');
        }else{
            $(this).next().slideToggle('medium');
            $(this).find('span').removeClass('show');
        }
    });

});


//显示查询语句
function debug(json){
	var html = '';
	
	if(json.sql_select){
		html+=''+json.sql_select+'<br/>';
	}
/*
	if(json.sql_query){
		html+='所有数据库语句：<br/>'+json.sql_query+'<br/>';
	}
	*/
	if(html!=''){
		$('<div title="[Esc]&nbsp;Ajax进行了'+json.selectCount+'个数据库查询，耗时：'+json.time_consume+' s &nbsp;'+json.memory+'">'+html+'</div>').dialog({       
	        autoOpen: true,
	        width: 800,
	        height: 300,
	        modal: true,
	        show:"slide",
	        buttons: {            
	            'Close': function() {
	                $(this).dialog('close');
	            }
	        }
	    });
	}
	
	
}
//截取字符串，中英文通用  by jack 2013-4-11
function cutstr(str,len)
{
	var str_length = 0;
	var str_len = 0;
	str_cut = new String();
	str_len = str.length;
	for(var i = 0;i<str_len;i++)
	{
		a = str.charAt(i);
		str_length++;
		if(escape(a).length > 4)
		{
			//中文字符的长度经编码之后大于4
			str_length++;
		}
		str_cut = str_cut.concat(a);
		if(str_length>=len)
		{
			str_cut = str_cut.concat("...");
			return str_cut;
		}
	}
	//如果给定字符串小于指定长度，则返回源字符串；
	if(str_length<len){
		return str;
	}
}


//检查浏览器是否安装flash
function flashcheck(){
    var swf;
    if(navigator.userAgent.indexOf("MSIE")>0)
    {
        try {
               var swf=new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
               return true;
        } catch(e) {
            return false;
        }
    }
	
	if(navigator.userAgent.indexOf("Firefox")>0 || navigator.userAgent.indexOf("Chrome")>0){
        swf=navigator.plugins["Shockwave Flash"];
        if(swf){
            return true;
        }else{
            return false;
        }
    }
	
	if(navigator.userAgent.indexOf("Opera")>=0){		
		swf=navigator.plugins["Shockwave Flash"];       
	   if(swf){
            return true;
        }else{
            return false;
        }
		
	}

	if(navigator.userAgent.indexOf("Safari")>0){
		swf=navigator.plugins["Shockwave Flash"];       
	   if(swf){
            return true;
        }else{
            return false;
        }
		
	}

    return false;
};	

/*清除提示*/
function clearTip(){

	var clearTip = function() {
    $(".infoTips").html('');					
	clearTimeout(timeout); 
	} 
	var timeout = setTimeout(clearTip, 3000); 
}

/*定时跳转*/


function gotoUrl(url){

	var gotoUrlAction = function() {
    location.href=url;				
	clearTimeout(gotoUrltimeout); 
	} 
	var gotoUrltimeout = setTimeout(gotoUrlAction, 3000); 
}

function addDate(date,days,s){ 
    var d=new Date(date); 
    d.setDate(d.getDate()+days); 
    var month=d.getMonth()+1; 
    var day = d.getDate(); 
    if(month<10){ 
        month = "0"+month; 
    } 
    if(day<10){ 
        day = "0"+day; 
    } 
    if(typeof s == 'undefined') s = '';
    var val = d.getFullYear() + "" + s + "" + month + "" + s + "" + day; 
    return val; 
}