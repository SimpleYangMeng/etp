;(function ($) {
    $.fn.extend({
        placeholder : function () {
            if ("placeholder" in document.createElement("input")) {
                return this //如果原生支持placeholder属性，则返回对象本身
            } else {
				return;
                return this.each(function () {
                    var _this = $(this);
					if(!_this.attr("placeholder")){
						return;
					}
					
					if(_this.val()==''){
						_this.val(_this.attr("placeholder")).css('color','#666');
					}					
					
                    _this.focus(function () {
                        if (_this.val() === _this.attr("placeholder")) {                            
							_this.val("");
							_this.css('color','#000');
                        }
                    }).blur(function () {
                        return;
						if (_this.val().length === 0) {
                            _this.val(_this.attr("placeholder"));
							_this.css('color','#666');
                        }
                    })
                })
            }
        }
    })
})(jQuery);