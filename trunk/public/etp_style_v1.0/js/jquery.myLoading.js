/*
 *
 * jquery.myLoading
 *
 * $("xx").myLoading();
 * $("xx").myLoading({height:100});
 *
 * */
(function ($) {
    var theme = {
        normal: function () {
            var opts = this.opts;
            var icon = opts.icons.normal;
            opts.height = opts.height == 0 ? icon.height : opts.height;
            this.ui.css({
                width: opts.width,
                height: opts.height,
                margin: "auto",
                textAlign: "center",
                verticalAlign: "middle",
                fontSize: 12 + "px"
            });
            this.iconUI.css({
                background: "url(" + icon.path + ") 5px 50% no-repeat",
                height: opts.height,
                lineHeight: opts.height + "px",
                paddingRight: 5,
                textIndent: (icon.width + 10) + "px"
            });
            this.ui.css({display: "block", width: this.ui.width()});
        }
    };
    var methods = {
        init: function (params) {
            var settings = {
                text: "Loading...",
                theme: "normal",
                icons: {
                    normal: {path: "/images/loading.gif", width: 30, height: 30}
                }
            };
            return this.each(function (i) {
                var $this = $(this);
                var height = $this.height();
                if (!(params && params.height) && height == 0) {
                    $this.parents().each(function () {
                        height = $(this).height();
                        if (height > 0) {
                            return false;
                        }
                    });
                }
                var opts = $.extend({width: $this.width(), height: height}, settings, params);
                if (height < opts.icons[opts.theme].height) {
                    opts.height = opts.icons[opts.theme].height;
                }
                $this.opts = opts;
                var hObj = $this.html('');
                if ($this.attr('id') == 'listData') {
                    hObj = $this.html('<tr><td colspan=' + $this.prev().children("tr").children("th").length + '></td></tr>').find("td");
                }
                $this.ui = $("<span class='loading' style='/*display: inline-block;*/background: #fff;'><i style='display: inline-block;font-style: normal;'>" + opts.text + "</i></span>").appendTo(hObj);
                $this.iconUI = $this.ui.find("i");
                theme[opts.theme] && theme[opts.theme].call($this);
            });
        }
    };
    $.fn.myLoading = function (method) {
        if (methods[method]) {
            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist on jQuery.tooltip');
        }
    };
})(jQuery);