$(function(){
    $('.statusBtn').bind('click',function(){
        var status = $(this).attr('ref');
        $('.status').val(status);
        $('.statusBtn').removeClass('btn-active');
        $(this).addClass('btn-active');
        $('#pagerForm').submit();
    });
    $(".order_product").hide();
    $("#foldToggle").click(function(){
        var v = $(this).attr("value");
        if(v=="1"){
            $(".order_product").hide();
            $(this).attr("value","0");
            $(".order_product").each(function(){
               $(this).attr("status","0");
            });
        }else{
            $(".order_product").show();
            $(this).attr("value","1");
            $(".order_product").each(function(){
                $(this).attr("status","1");
            });
        }
    })
    //处理订单
    $('.ordercheckAll').die('click').live('click',function(){
        if ($(this).is(':checked')) {
            $(".orderArr").attr('checked', true);
        } else {
            $(".orderArr").attr('checked', false);
        }
    });

    $('#batchSubmit').die().bind('click',function(){
        if($('#batchSelect').val()==''){
            alertTip("必须选择操作",'500','auto','1');
        }else{
            switch($('#batchSelect').val()){
                case "submitOrder":
                    submitOrder();
                    break;
                case "bacthConfirm":
                    bacthConfirm();
                    break;
                case "bacthDelete":
                    bacthDelete();
                    break;
                case 'movedraft':
                    movedraft();
                    break;
                default:
                    alertTip('无效的参数','500','auto','1');
            }
        }
    })

});
function showProduct(ordersCode){
    var status = $("#"+ordersCode).attr("status");
    if(status=="1"){
        $("#"+ordersCode).attr("status","0");
        $("#"+ordersCode).hide();
    }else{
        $("#"+ordersCode).attr("status","1");
        $("#"+ordersCode).show();
    }
}
function bacthConfirm(){
    var checkedSizesize = $('.orderArr:checked').size();
    if(checkedSizesize<=0){
        alertTip("请至少选择一个订单",'500','auto','1');
        return;
    }
    var param = $("#orderDataForm").serialize();
    $.ajax({
        type:"post",
        async:false,
        dataType:"json",
        url:"/merchant/order/confirm",
        data:param,
        success:function (json) {
            var html = "<strong>"+json.message+"</strong>";
            if(json.ask=='1'){
                alertTip(html);
            }else{
                if(json.error){
                    html+=":<br/>";
                    $.each(json.error,function(k,v){
                        html+="<span class='red'>*</span>"+v+"<br/>";
                    });
                }
                alertTip(html);
            }
            $('#searchorderForm').submit();
        }
    });
}
function submitOrder(){
    var checkedSizesize = $('.orderArr:checked').size();
    if(checkedSizesize<=0){
        alertTip("请至少选择一个订单",'500','auto','1');
        return;
    }
    var param = $("#orderDataForm").serialize();
    $.ajax({
        type:"post",
        async:false,
        dataType:"json",
        url:"/merchant/order/submit",
        data:param,
        success:function (json) {
            var html = "<strong>"+json.message+"</strong>";
            if(json.ask=='1'){
                if(json.error){
                    html+=":<br/>";
                    $.each(json.error,function(k,v){
                        html+="<span class='red'>*</span>"+v+"<br/>";
                    });
                }
                alertTip(html);
            }else{
                if(json.error){
                    html+=":<br/>";
                    $.each(json.error,function(k,v){
                        html+="<span class='red'>*</span>"+v+"<br/>";
                    });
                }
                alertTip(html);
            }
            $('#searchorderForm').submit();
        }
    });
}
function movedraft(){
    var checkedSizesize = $('.orderArr:checked').size();
    if(checkedSizesize<=0){
        alertTip("请至少选择一个订单",'500','auto','1');
        return;
    }
    var param = $("#orderDataForm").serialize();
    $.ajax({
        type:"post",
        async:false,
        dataType:"json",
        url:"/merchant/order/draft",
        data:param,
        success:function (json) {
            var html = "<strong>"+json.message+"</strong>";
            if(json.ask=='1'){
                if(json.error){
                    html+=":<br/>";
                    $.each(json.error,function(k,v){
                        html+="<span class='red'>*</span>"+v+"<br/>";
                    });
                }
                alertTip(html);
            }else{
                if(json.error){
                    html+=":<br/>";
                    $.each(json.error,function(k,v){
                        html+="<span class='red'>*</span>"+v+"<br/>";
                    });
                }
                alertTip(html);
            }
            $('#searchorderForm').submit();
        }
    });
}
function bacthDelete(){
    var checkedSizesize = $('.orderArr:checked').size();
    if(checkedSizesize<=0){
        alertTip("请至少选择一个订单",'500','auto','1');
        return;
    }
    var param = $("#orderDataForm").serialize();
    $.ajax({
        type:"post",
        async:false,
        dataType:"json",
        url:"/merchant/order/delete",
        data:param,
        success:function (json) {
            var html = "<strong>"+json.message+"</strong>";
            if(json.ask=='1'){
                if(json.error){
                    html+=":<br/>";
                    $.each(json.error,function(k,v){
                        html+="<span class='red'>*</span>"+v+"<br/>";
                    });
                }
                alertTip(html);
            }else{
                if(json.error){
                    html+=":<br/>";
                    $.each(json.error,function(k,v){
                        html+="<span class='red'>*</span>"+v+"<br/>";
                    });
                }
                alertTip(html);
            }
            $('#searchorderForm').submit();
        }
    });
}
function alertTip(tip,width,height,notflash) {
    width = width?width:500;
    height = height?height:'auto';
    $('<div title="Note(Esc)"><p align="">' + tip + '</p></div>').dialog({
        autoOpen: true,
        width: width,
        height: height,
		position:[50,50],
        modal: true,
        show:"slide",
        buttons: {
            'Close': function() {
                $(this).dialog('close');
                if(!(typeof(notflash)!="undefined" && notflash=='1')){
                    $('#pagerForm').submit();
                }
            }
        },
        close: function() {

        }
    });
}