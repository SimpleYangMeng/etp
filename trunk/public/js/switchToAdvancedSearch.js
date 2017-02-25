(function($) {
    $.fn.extend({
        "switchToAdvancedSearch":function(options){
            //设置默认值			
            option=$.extend({              
                button_id:"#switch_search_model",
				advanced_element:".advanced_element"				
            },options); //注意这个options 同上面的function(options)中的option是同一个对象
          	
			if(typeof($(this).attr('id'))=='undefined'){return;}
			//alert($(option.advanced_element).size());

			function init(){				
				$('.simplesearchsubmit').css({'marginLeft':10});
			}
			init();
			
			if(typeof($.cookie('search_mode'))!='undefined'){
				if($.cookie('search_mode')=='advanced'){
					switchtoadvanced();
				}else if($.cookie('search_mode')=='common'){
					switchsimple();
				}else{
					if($(option.advanced_element).size()>0){
						switchsimple();
					}					
					
				}				
			
			
			}
			
			function switchtoadvanced(){
					$(option.advanced_element).show();
					$(option.button_id).html('切换到普通搜索');
					$('.simplesearchsubmit').hide();
					$('.advancedsearchsubmit').show();
				
			}
			
			function switchsimple(){
					$(option.advanced_element).hide();
					$(option.button_id).html('切换到高级搜索');
					$('.simplesearchsubmit').show();
					$('.advancedsearchsubmit').hide();
			}			
			
			
			
			
			//----------------------------------------------
			$(option.button_id).click(function(event){				
				if($(option.advanced_element+':hidden').size()>0){
					 switchtoadvanced();
					 $.cookie('search_mode','advanced');
				}else{
					switchsimple();
					$.cookie('search_mode','common');
				}			
				event.stopPropagation();				
				
			}); 
		 //------------------------------------------------
            return this;  //返回this，使方法可链
        }
   
    });

})(jQuery);