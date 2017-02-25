$(function(){
    $('.statusBtn').bind('click',function(){
        var status = $(this).attr('ref');
        $('[name=receiving_status]').val(status);
        $('.statusBtn').removeClass('btn-active');
        $(this).addClass('btn-active');		
        $('#pagerForm').submit();
    });
    //处理ASN
     $(".asncheckAll").die('click').live('click',function () {
         if ($(this).is(':checked')) {
             $(".AsnArr").attr('checked', true);
         } else {
             $(".AsnArr").attr('checked', false);
         }
     });
    $('#batchSubmit').die().bind('click',function(){
        if($('#batchSelect').val()==''){
            alertTip("必须选择操作",'500','auto','1');
        }else{
            switch($('#batchSelect').val()){
                case "bacthConfirm":
                    bacthConfirm();
                    break;
                case "movepending":
                    movepending();
                    break;
                case "movedraft":
                    movedraft();
                    break;
                default:
                    alertTip('无效的参数','500','auto','1');
            }
        }
    })
});

 function bacthConfirm(){
     var checkedSizesize = $('.AsnArr:checked').size();
     if(checkedSizesize<=0){
         alertTip("请至少选择一个ASN",'500','auto','1');
         return;
     }
     var param = $("#asnDataForm").serialize();
     $.ajax({
         type:"post",
         async:false,
         dataType:"json",
         url:"/merchant/receiving/confirm",
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
             //$('#pagerForm').submit();
         }
     });
 }
 function movepending(){
     var checkedSizesize = $('.AsnArr:checked').size();
     if(checkedSizesize<=0){
         alertTip("请至少选择一个ASN",'500','auto','1');
         return;
     }
     var param = $("#asnDataForm").serialize();
     $.ajax({
         type:"post",
         async:false,
         dataType:"json",
         url:"/merchant/receiving/pending",
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

         }
     });
 }
 function movedraft(){
     var checkedSizesize = $('.AsnArr:checked').size();
     if(checkedSizesize<=0){
         alertTip("请至少选择一个ASN",'500','auto','1');
         return;
     }
     var param = $("#asnDataForm").serialize();
     $.ajax({
         type:"post",
         async:false,
         dataType:"json",
         url:"/merchant/receiving/draft",
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
             //$('#pagerForm').submit();
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
function deleteAsn(url){
    $('<div title="Note(Esc)"><p align="">你确定删除该ASN</p></div>').dialog({
        autoOpen: true,
        width: 300,
        height: 'auto',
        modal: true,
        show:"slide",
        buttons: {
            '取消':function(){
                $(this).dialog("close");
            },
            '确定': function() {
                $(this).dialog("close");
                $.ajax({
                    type:'POST',
                    url:url,
                    dataType:"json",
                    cache:false,
                    success:function(json){
                        if(json.ask=='1'){
                            alertTip(json.message);
                        }else{
                            var html = '';
                            html+=json.message;
                            alertTip(json.message,'500','auto','1');
                        }
                    },
                    error:function(){
                        alertTip('错误');
                    }
                });
            }
        },
        close: function() {

        }
    });

}
