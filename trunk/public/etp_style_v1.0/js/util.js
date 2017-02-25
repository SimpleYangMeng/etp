/**
 * Created by Administrator on 2016/11/3.
 */
/**
 * 公共方法函数
 */

/**
 * 根据像素值，获取数值。
 * @param pixel
 * @returns {number}
 */

var util = {
    getNumPixel: function (pixel) {
        if(typeof pixel == 'string'){
            return Number(pixel.replace('px', ''));
        }
    },
    mouseCoords: function (e) {
        var self = this;
        e = e || window.event;
        if (e.pageX) {
            return {x: e.pageX, y: e.pageY};
        }
        return {
            x: e.clientX + document.body.scrollLeft - document.body.clientLeft,
            y: e.clientY + document.body.scrollTop - document.body.clientTop
        }
    },
    mouseShowTip: function (e, con) {
        var self = this;
        var tipWrap = $('.floatTips');
        var leftOffset = self.mouseCoords(e).x + 15;
        var topOffset = self.mouseCoords(e).y + 10;
        tipWrap.html(con);
        tipWrap.css({'top': topOffset + 'px', 'left': leftOffset + 'px'}).fadeIn(600);
    },
    /**
     * 倒计时显示
     * @param end_time 倒计时 格式：2014/11/22 18:00:00 或者 秒数值
     * @param day_elem 显示天的Jquery对象
     * @param hour_elem 显示时的Jquery对象
     * @param minute_elem 显示分的Jquery对象
     * @param second_elem 显示秒的Jquery对象
     * @param now_time  指定当前时间 格式：2014/11/22 18:00:00 或者 秒数值
     * @param callback  倒计时完成后回调函数
     */
    timerCountDown: function (end_time, day_elem, hour_elem, minute_elem, second_elem, now_time, callback) {
        if (!Number(end_time)) {
            end_time = new Date(end_time).getTime() / 1000;
        }
        if (now_time) {
            if (!Number(now_time)) {
                now_time = new Date(now_time).getTime() / 1000;
            }
        } else {
            now_time = new Date().getTime() / 1000;
        }
        var sys_second = end_time - now_time;
        var timer = setInterval(function () {
            if (sys_second > 1) {
                sys_second -= 1;
                var day = Math.floor((sys_second / 3600) / 24);
                var hour = Math.floor((sys_second / 3600) % 24);
                var minute = Math.floor((sys_second / 60) % 60);
                var second = Math.floor(sys_second % 60);
                day_elem && day_elem.text(day); //计算天
                hour_elem && hour_elem.text(hour < 10 ? "0" + hour : hour); //计算小时
                minute_elem && minute_elem.text(minute < 10 ? "0" + minute : minute); //计算分
                second_elem && second_elem.text(second < 10 ? "0" + second : second); // 计算秒
            } else {
                clearInterval(timer);
                if (callback.constructor == Function) {
                    callback();
                }
            }
        }, 1000)
    },
    topMenuToggle: function () {
        var topRight = $('.topRight');
        topRight.find('li').mouseenter(function () {
            $(':animated').stop(true, true);
            $(this).addClass('active');
            $(this).find('.subMenu').slideDown();
        }).mouseleave(function () {
            $(':animated').stop(true, true);
            $(this).find('.subMenu').slideUp();
            $(this).removeClass('active');
        });
    },
    //tab切换
    tabSwitch: function (abs) {
        if (abs && typeof abs == 'string') {
            var tabBtn = $(abs).find(".tabBtn");
            var tabCon = $(abs).find(".tabCon");
            tabCon.children().first().css("display", 'block');
            tabBtn.bind("click", function () {
                var conFlag = $(this).attr('data-flag');
                $(":animated").stop(true, true);
                $(conFlag).siblings().hide();
                tabCon.find(conFlag).fadeIn();
            });
        }
    },
    //会员中心左侧菜单效果
    memberNav: function () {
        var $memberNav = $('.memberNav');
        $memberNav.find('.dt').bind('click', function () {
            $(':animated').stop(true, true);
            if(!$(this).hasClass('active')){
                $(this).addClass('active');
                $(this).next('.dd').slideUp(600);
            }else{
                $(this).removeClass('active');
                $(this).next('.dd').slideDown(600);
            }
        });
        //简单判断菜单选中状态 根据实际URL规则调整
        var currentUrl = window.location.pathname;
        $memberNav.find('.dd a').each(function(){
            if($(this).attr('href').trim() == currentUrl) {
                $(this).addClass('active');
            }
        });
    },
    doAjax: function (options) {
        if (options && options.constructor === Object) {
            $.ajax(options);
        }
    },
// * @returns {XML|string}
//   @适用于失焦事件 不适用于keyup事件
    toMoneyFormat: function(value) {
        value += "";
        value = value.replace(/,/g, "");
        var point = value.indexOf(".");
        var len = value.length;
        if (point < 0) {
            value += ".00";
        } else if (point == len - 1) {
            value += "00";
        } else if (point == len - 2) {
            value += "0";
        } else if (point < len - 3) {
            value = value.substring(0, point) + ".00";
        }
        value = value.replace(/^(\d+)(\.\d+)$/, function (s, s1, s2) {
            return s1.replace(/\d{1,3}(?=(\d{3})+$)/g, "$&,") + s2;
        });
        return value;
    },
    //产品页头部搜索下拉框
    plsSelect: function(){
        $('.sSelect').bind('mouseenter',function(e){
            $(':animated').stop(true,true);
            $(this).find('.fore').addClass('hover');
            var foreId = $(this).find('.fore').attr('data-id');
            var foreVal = $(this).find('.fore').attr('data-value');
            $(this).find('.dropDown').slideDown(300);
        });
        $('.sSelect').bind('mouseleave',function(e){
            $(':animated').stop(true,true);
            $(this).find('.fore').removeClass('hover');
            $(this).find('.dropDown').slideUp(300);
        });
        $('.sSelect').find('.dropDown').on('click','li',function(){
            $(':animated').stop(true,true);
            var currentId = $(this).attr('data-id');
            var currentVal = $(this).attr('data-value');
            $(this).parent().parent().find('.fore').attr('data-id',currentId);
            $(this).parent().parent().find('.fore').attr('data-value',currentVal);
            $(this).parent().parent().find('.fore').find('span').text(currentVal);
            $(this).parent().slideUp(300);
        });
    },
    //右侧浮动框
    floatBox:{
        backTop: function(){
            var self = this;
            var floatBox = $('.floatBox');
            var $body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
            floatBox.find('.floatTopBox').click(function(){
                $body.animate({'scrollTop':'0px'},{
                    easing: 'swing',
                    duration: 1000
                })
            });
            function backTopStatus(){
                var scrollTopH = document.body.scrollTop || document.documentElement.scrollTop;
                if(scrollTopH - 200 > 0){
                    floatBox.find('.floatTopBox').show();
                }else{
                    floatBox.find('.floatTopBox').hide();
                }
            }
            $(window).scroll(function(){
                backTopStatus();
            });
            backTopStatus();
        }
    }
}

//    * 字符串函数扩展
//* @type {{toFloat: toFloat, toInt: toInt}}
//*/
String.prototype.toFloat = function () {
    return isNaN(parseFloat(this)) ? 0 : parseFloat(this);
};
String.prototype.toInt = function () {
    return isNaN(parseInt(this)) ? 0 : parseInt(this);
};
$(function(){
    util.floatBox.backTop();
})



///**
// * 阻止页面文字被选中
// * input标签除外
// * 如果需要时文字可以被选中，加上属性：allow="1"；
// */
//function forbidTextChecked() {
//    if (typeof(document.onselectstart) != "undefined") {
//        // IE下禁止元素被选取
//        document.onselectstart = function (event) {
//            event = event || window.event;
//            var ele = $(event.srcElement).parent();
//            if (event.srcElement.tagName != "INPUT") {
//                if (ele.attr("allow") != "1") {
//                    return false;
//                }
//            }
//        }
//    } else {
//        // firefox下禁止元素被选取的变通办法
//        document.onmousedown = function (event) {
//            var ele = $(event.target);
//            if (event.target.tagName != "INPUT" && event.target.tagName != "SELECT") {
//                if (ele.attr("allow") != "1") {
//                    return false;
//                }
//            }
//        };
//        document.onmouseup = function (event) {
//            var ele = $(event.target);
//            if (event.target.tagName != "INPUT" && event.target.tagName != "SELECT") {
//                if (ele.attr("allow") != "1") {
//                    return false;
//                }
//            }
//        }
//    }
//}
///**
// * 获取当前鼠标位置
// * @param e
// * @returns {*}
// */
//function mouseCoords(e) {
//    e = e || window.event;
//    if (e.pageX) {
//        return {x: e.pageX, y: e.pageY};
//    }
//    return {
//        x: e.clientX + document.body.scrollLeft - document.body.clientLeft,
//        y: e.clientY + document.body.scrollTop - document.body.clientTop
//    };
//}
///**
// * 获取当前窗口的大小
// * @returns {{}}
// */
//function pageBox() {
//    return window.innerWidth ? {width: window.innerWidth, height: window.innerHeight} :
//        document.compatMode == "CSS1Compat" ? {
//            width: document.documentElement.clientWidth,
//            height: document.documentElement.clientHeight
//        } :
//        {width: document.body.clientWidth, height: document.body.clientHeight};
//}
//
///**
// * 将16进制颜色转化为rgb颜色
// * 例子：hexToRgb("#fff",0.6,false);返回rgba(255,255,255,0.6)
// * @param hexStr    16进制字符串
// * @param opacity   透明度
// * @param flag      true返回数组，false返回字符串，为空表示false
// */
//function hexToRab(hexStr, opacity, flag) {
//    var hex = /^(?:#)?([\dA-Fa-f]{6})$/;
//    var splitHex = /(?:[\dA-Fa-f]){2}/g;
//    var result = [];
//    var getMatch = "";
//    //讲3位颜色转化为6位
//    if (hexStr.length === 3 || hexStr.length === 4) {
//        hexStr = hexStr.replace(/([\dA-Fa-f])/g, "$1$1");
//    }
//    if (getMatch = hex.exec(hexStr)) {
//        getMatch = getMatch[1].match(splitHex);
//        for (var i = 0; i < getMatch.length; i++) {
//            result.push(parseInt(getMatch[i], 16));
//        }
//        if (opacity) {
//            opacity = Number(opacity);
//            result.push(opacity);
//        }
//        if (flag) {
//            return result;
//        } else {
//            return (opacity <= 1 && opacity >= 0) ? "rgba(" + result + ")" : "rgb(" + result + ")";
//        }
//    }
//    return false;
//}
//
///**
// * 将数字格式化
// * @param value 数字或数字组成的字符串
// * @returns {XML|string}
// */
//function toMoneyFormat(value) {
//    value += "";
//    value = value.replace(/,/g, "");
//    var point = value.indexOf(".");
//    var len = value.length;
//    if (point < 0) {
//        value += ".00";
//    } else if (point == len - 1) {
//        value += "00";
//    } else if (point == len - 2) {
//        value += "0";
//    } else if (point < len - 3) {
//        value = value.substring(0, point) + ".00";
//    }
//    value = value.replace(/^(\d+)(\.\d+)$/, function (s, s1, s2) {
//        return s1.replace(/\d{1,3}(?=(\d{3})+$)/g, "$&,") + s2;
//    });
//    return value;
//}
//
///**
// * 获取url的参数对象
// * @param url
// * @returns {{}}
// */
//function getUrlParam(url) {
//    var paramStr = url.substring(url.indexOf("?") + 1, url.length);
//    var paramArr = paramStr.split("&");
//    var obj = {};
//    for (var i = 0; i < paramArr.length; i++) {
//        var param = paramArr[i].split("=");
//        obj[param[0]] = param[1];
//    }
//    return obj;
//}
//
///**
// * 获取url指定key的值
// * @param url
// * @param key
// * @returns {*}
// */
//function getUrlValue(url, key) {
//    var reg = new RegExp("(^|&|\\?)" + key + "=([^&]*)(&|$)");
//    var r;
//    if (r = url.match(reg))
//        return unescape(r[2]);
//    return null;
//}
//
//
//
//function switchKFStatus(eles, offlineImg) {
//    var index = 0;
//    var d = new Date();
//    var timeOut = 1000;
//    //第一次载入页面，快速检测所有客服状态
//    get_qqkf_status(index);
//    function get_qqkf_status(i) {
//        $.ajax({
//            'url': 'http://crm2.qq.com/cgi/portalcgi/get_kf_status.php?kfuin=938045598&aty=1&al=' + eles[i][0] + '&cb=window.qqkfStatus',
//            type: 'get',
//            dataType: 'jsonp'
//        });
//    }
//
//    window.qqkfStatus = function (data) {
//        var iframe = $('#' + eles[index][1]).find('iframe');
//        if (iframe.length > 0) {
//            if (data.data.list[eles[index][0]] == 1) {
//                $(iframe[0].contentWindow.document).find('#launchBtn').removeAttr('style');
//            } else {
//                $(iframe[0].contentWindow.document).find('#launchBtn').attr('style', 'background:url(' + offlineImg + ')');
//            }
//            index++;
//            if (index > eles[0].length) {
//                index = 0;
//                if (d.getHours() > 9 && d.getHours() < 18) {
//                    timeOut = 60000;
//                }
//            }
//        }
//        setTimeout(function () {
//            get_qqkf_status(index);
//        }, timeOut);
//    };
//}
//
///**
// * 获取字符串长度，特殊字符占两位
// * @param str
// * @returns {number}
// */
//function getLen(str) {
//    var byteLen = 0, len = str.length;
//    if (str) {
//        for (var i = 0; i < len; i++) {
//            if (str.charCodeAt(i) > 255) {
//                byteLen += 2;
//            } else {
//                byteLen++;
//            }
//        }
//        return byteLen;
//    } else {
//        return 0;
//    }
//}
//
///**
// * Date对象扩展函数 时间格式化
// * @param format 格式化的样子，Y/y-年 M-月 d-天 h-小时 m-分钟 s-秒 q-季度 S-毫秒
// * @returns {*}
// */
//Date.prototype.format = function (format) {
//    var o = {
//        "M+": this.getMonth() + 1, //month
//        "d+": this.getDate(), //day
//        "h+": this.getHours(), //hour
//        "m+": this.getMinutes(), //minute
//        "s+": this.getSeconds(), //second
//        "q+": Math.floor((this.getMonth() + 3) / 3), //quarter
//        "S": this.getMilliseconds() //millisecond
//    };
//    if (o["d+"].toString() == "NaN" || this.getFullYear() == "1970") {
//        return "— —";
//    }
//    if (/(y+)/i.test(format))
//        format = format.replace(RegExp.$1, (this.getFullYear() + "").substr(4 - RegExp.$1.length));
//    for (var k in o)
//        if (new RegExp("(" + k + ")").test(format))
//            format = format.replace(RegExp.$1, RegExp.$1.length == 1 ? o[k] : ("00" + o[k]).substr(("" + o[k]).length));
//    return format;
//};
//
///**
// * 字符串函数扩展
// * @type {{toFloat: toFloat, toInt: toInt}}
// */
//String.prototype.toFloat = function () {
//    return isNaN(parseFloat(this)) ? 0 : parseFloat(this);
//};
//String.prototype.toInt = function () {
//    return isNaN(parseInt(this)) ? 0 : parseInt(this);
//};
//String.prototype.trim = function () {
//    return $.trim(this);
//};
//
