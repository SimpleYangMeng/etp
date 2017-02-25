/*
制作：colin yang
时间：2013-12-11
依赖库：jquery库
功能:标签式浏览

对外主要函数: 
1.openMenuTab()
2.resetIrameHeight()  iframe内部调用
3.CloseMenu()  关闭
*/

var menuBox = "#menutablist";//放TAB浏览的区域
var menuContentbox = "#menuContentbox";//主体内容所在区
var iframeboxSuffix = '_menufather';//主体内容的标识的后缀

var defaultMenuid = 'System_summary';
var defaultMenutitle = '快速看板';
var defaultMenuUrl = '/merchant/index/global';
var currentMenuid = 'System_summary';
var documentMinHeight = 1100;
var menuidList = new Array();
var maxMenuNumber = 8;

var hightLightClass='.mentab_on';
/*打开一个菜单*/
function openMenuTab(url,label,keyid,is_replace){
		
		var url = url||"";
		var label = label ||"";	
		var is_replace = is_replace || "0";
		
		if(url=='' || label==''){return;}
		var idmode = /^[0-9a-zA-Z]*$/g;
		
		url = url||defaultMenuUrl;
		label = label||defaultMenutitle;
		keyid = keyid||generateMixed(20);
		//if((!idmode.test(keyid))){return;}
		if(is_replace=='1'){ 
				CloseMenuNotSetDefault(currentMenuid);				
		}	
		if(!check_exists(menuidList,keyid)){/*不存在*/
			CloseLastMenus();
			menuidList.push(keyid);			
			if(typeof(document.all[keyid+iframeboxSuffix])!='undefined'){
				document.all[keyid+iframeboxSuffix].src = url;		
			}
			//if(is_replace=='1'){refreshMenu(keyid,url); return;}
		}else{			
			
			
			//eval('ProductList_menufather.location.reload()');
			//document.all["ProductList_menufather"].src = url;
			refreshMenu(keyid,url);
		    SelectCurrentMenu(keyid);
		    return;		
		}
		
		
		
		
		if($('#'+keyid).size()==0){
			var html;
			if(currentMenuid==keyid){
				html  = '<div class="menutab_off"  style="float:left; overflow:hidden;display:inline;padding:8px 9px 4px 9px;border:1px solid #666;margin-top:8px;height:36px;margin-right:5px;" onclick="SelectCurrentMenu(this.id)"' + 'id ="'+keyid+'"><p style="float:left;" title="'+label+'">'+subString(label,10,true) + '</p></div>';	
			}else{
				html  = '<div class="menutab_off"  style="float:left; overflow:hidden;display:inline;padding:8px 2px 4px 9px;border:1px solid #666;margin-top:8px;height:36px;margin-right:5px;" onclick="SelectCurrentMenu(this.id)"' + 'id ="'+keyid+'"><p style="float:left;" title="'+label+'">'+subString(label,10,true) + '</p><a style="float:left;width:20px;height:30px;border:0px solid #ff0000;" onclick=CloseMenu("'+keyid+'")><img   src="/images/delete_box.png"></a></div>';				
				
			}
			$(html).appendTo(menuBox);
		}
		if($('#'+keyid+iframeboxSuffix).size()==0)
		{			
			
			var contentHtml = '<iframe  allowtransparency="true"   frameborder="0" width="100%" height="'+documentMinHeight+'" scrolling="no" ' + 'id="'+keyid+iframeboxSuffix+'"' +'name="'+keyid+iframeboxSuffix+'"' +'src="'+url+'"'+'></iframe>';
			$(contentHtml).appendTo(menuContentbox);		
		}
		
		
		CloseAllMenuIframe();	
		
		
		SelectCurrentMenu(keyid);
		//$('html, body').animate({scrollTop:0}, 'slow');
		//alert(keyid+iframeboxSuffix);
		
		

   			
		
	
};

//重新加载菜单
function refreshMenu(menuid,url){
	var is_found = menuidList.indexOf(menuid);
	if(is_found){
		if(typeof(document.all[menuid+iframeboxSuffix])!='undefined'){
			document.all[menuid+iframeboxSuffix].src = url;		
		}
			
	}
}
/*替换*/
function CloseCurrentMenu(){
	
	
}

function CloseLastMenus(){
	if(menuidList.length>=maxMenuNumber){	
		for(i=maxMenuNumber-1;i<menuidList.length;i++){
		   CloseMenuNotSetDefault(menuidList[i]);		
		}
	
	}
}

function SelectCurrentMenu(id){
	
	for(i=0;i<menuidList.length;i++){
		$('#'+menuidList[i]).removeClass('menutab_on');
		$('#'+menuidList[i]).addClass('menutab_off');
	}	
	$('#'+id).removeClass('menutab_off');
	$('#'+id).addClass('menutab_on');
	
	CloseAllMenuIframe();
	
	if($('#'+id).size()>0){
		$('#'+id).show();		
	};
	
	if($('#'+id+iframeboxSuffix).size()>0){
		$('#'+id+iframeboxSuffix).show();		
	};
	
	currentMenuid = id;

}
/*删除指定菜单并重新指定默认*/
function CloseMenu(id){
	if(id==defaultMenuid){return;}
	if(menuidList.length<=1){return;}  // 如果是最后一个菜单则不能删除
	
	menuidList.remove(id);
	$('#'+id).remove();
	$('#'+id+iframeboxSuffix).remove();	
	changeLastMenuAsCurrent();
}

/*删除指定菜单*/
function CloseMenuNotSetDefault(id){
	if(id==defaultMenuid){return;}
	if(menuidList.length<=1){return;}  // 如果是最后一个菜单则不能删除
	
	menuidList.remove(id);
	$('#'+id).hide();
	$('#'+id+iframeboxSuffix).hide();	
	
}


/*返回最后一个菜单作为当前菜单*/
function changeLastMenuAsCurrent(){
	var arrlen = menuidList.length;	
	
	if(arrlen==0){return false;}
	//alert("dsf");
	var id = menuidList[arrlen-1];	
	//SelectCurrentMenu(id);
	setTimeout("SelectCurrentMenu('"+id+"')",1);
	
	
}


/*让所有的网页的内容体隐藏*/
function CloseAllMenuIframe(){	
	$('iframe').hide();
}
/*判断是否重复打开*/
function check_exists(arr,val){
	//alert(arr+"/"+val)
	var arrlen = arr.length;	
	if(arrlen==0){return false;}
	
	for(i=0;i<arrlen;i++){	
		
		if(arr[i]==val){
			return true;
		}
		
	}
	return false;
}	



/*数组查找*/
Array.prototype.indexOf = function(val) {
            for (var i = 0; i < this.length; i++) {

                if (this[i] == val) return i;

            }
            return -1;

};
/*数组删除元素*/
Array.prototype.remove = function(val) {

            var index = this.indexOf(val);

            if (index > -1) {

                this.splice(index, 1);

            }

};


/*数组替换元素1,如果不存在则新增*/
Array.prototype.replaceElement = function(srcElement,targetElement) {
            var index = this.indexOf(srcElement);
            if (index > -1) {//存在
                this[index]=targetElement;
            }else{
				this.push(targetElement);		
			}
			

};

/*数组替换元素2*/
Array.prototype.replaceElement1 = function(srcElement,targetElement) {
            var index = this.indexOf(srcElement);
            if (index > -1) {//存在
                this[index]=targetElement;
            }			

};

String.prototype.trim   =   function(){  
  return   this.replace(/(^\s*)|(\s*$)/g,"");  
} 
		/*
		var arr = [1, 2, 3, 4, 5];

        alert(arr.toString());

        arr.remove(3);

        alert(arr.toString());
		
*/

var lastheight = documentMinHeight;
/*放在IFRAME内部的页面的代码中，根据IFRAME内容重新设定高度*/
function resetIrameHeight(){
	try{
			if(typeof(parent.menuidList)!='undefined'){
				//alert(parent.menuidList.length);
				if(parent.menuidList.length>=1){				
					for(i=0;i<parent.menuidList.length;i++){
						
						 if(parent.currentMenuid!=parent.menuidList[i]){continue;}	
						 if(document.body.scrollHeight){											
							
							if(typeof(parent.document.all(parent.menuidList[i]+parent.iframeboxSuffix).style)!='undefined'){
								if(document.body.scrollHeight<documentMinHeight){
									parent.document.all(parent.menuidList[i]+parent.iframeboxSuffix).style.height =documentMinHeight+'px';								
								}else if(document.body.scrollHeight==documentMinHeight){


								}else{
									if(lastheight==document.body.scrollHeight){									
										return;
									}									
									//alert(document.body.scrollHeight+'px');
									parent.document.all(parent.menuidList[i]+parent.iframeboxSuffix).style.height=document.body.scrollHeight+'px';
									lastheight = document.body.scrollHeight;
							   }
							   
							}
							
							
			   	 		}			
					}
				}
			}	


	}catch(e){	
	  
	}
	setTimeout("resetIrameHeight();",4000);

}	
/*放在IFRAME内部的页面的代码中，根据IFRAME内容重新设定高度,只改变当前页面*/
function resetCurrentIrameHeight(){	
		if(typeof(parent.document.all(parent.currentMenuid+parent.iframeboxSuffix).style)!='undefined'){
			var iframeNowHeight = parent.document.all(parent.currentMenuid+parent.iframeboxSuffix).style.height;
			var iframeFutureHeight = document.body.scrollHeight+'px';			
			if(iframeNowHeight.trim()!=iframeFutureHeight.trim()){
				parent.document.all(parent.currentMenuid+parent.iframeboxSuffix).style.height=document.body.scrollHeight+'px'; 				
			}		
				  
		}	 
	   
	
}

function recoverMenu(){	

	//alert($.cookie('cookie_menulist'));
}

function saveMenuLayout(){
	var arrlen = menuidList.length;
	if(arrlen==0){return false;}
	$.cookie('cookie_menulist', menuidList.toString());
	
}




//辅助函数

var chars = ['0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z'];
function generateMixed(n) {
     var res = "";
     for(var i = 0; i < n ; i ++) {
         var id = Math.ceil(Math.random()*35);
         res += chars[id];
     }
     return res;
}



function subString(str, len, hasDot) 
{ 
    var newLength = 0; 
    var newStr = ""; 
    var chineseRegex = /[^x00-xff]/g; 
    var singleChar = ""; 
    var strLength = str.replace(chineseRegex,"**").length; 
    for(var i = 0;i < strLength;i++) 
    { 
        singleChar = str.charAt(i).toString(); 
        if(singleChar.match(chineseRegex) != null) 
        { 
            newLength += 2; 
        }     
        else 
        { 
            newLength++; 
        } 
        if(newLength > len) 
        { 
            break; 
        } 
        newStr += singleChar; 
    } 
     
    if(hasDot && strLength > len) 
    { 
        newStr += "..."; 
    } 
    return newStr; 
} 


$(document).ready(function(){
	openMenuTab(defaultMenuUrl,defaultMenutitle,defaultMenuid);
});

	