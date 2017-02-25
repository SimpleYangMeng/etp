<div id="register_body">

<div class="hyzxzc_mmmmt"><div class="functiontitle">完善资料</div></div>

<div class="grid-780 grid-780-pd fn-hidden fn-clear">
<div style="height:26px; margin-top:20px;background:url(/images/register_step.png); background-repeat:no-repeat; background-position:0 -75px;"></div>
    <div class="grid-780 fn-clear" >
        
        <form id="registerForm" class="fm-layout"  method="post" action="/register/complete" >
            <fieldset>			
			<table  border="0" class="register_form_table" style="width:100%;">
        	<tr>
                <td class="formlabel1">账号：</td>
                <td style="width:230px"><input disabled="disabled" class="text-input " type="text"  id="username" name="username" value="<{$data['code']}>"/><strong class="form-strong">*</strong></td>
                <td class="formlabel1">邮箱：</td>
                <td style=""><input class="text-input" type="text" id="email" name="email" value="<{$data['email']}>" disabled="disabled"/><strong class="form-strong">*</strong></td>                
        	</tr>
			

        	<tr>
                <td class="formlabel1" >公司名称：</td>
                <td colspan=3><input class="text-input" type="text" id="companyname" name="companyname"/><strong class="form-strong">*</strong></td>
                                
        	</tr>

            <{if $customer.customer_type eq "0"}>
        	<tr>
                <td class="formlabel1">Logo地址：</td>
                <td ><input type="file" id="logo" name="logo"  class="text-input2" /></td>
                <td class="formlabel1"><{t}>BusinessName<{/t}>：</td> 
				<td ><input class="text-input" type="text" id="trade_name" name="trade_name"/><strong class="form-strong">*</strong></td>              
        	</tr>
            <{/if}>


            <{if $customer.customer_type eq "0"}>
        	<tr>
                <td class="formlabel1"><{t}>BusinessCode<{/t}>：</td>
                <td colspan=3><input class="text-input" type="text" id="trade_co" name="trade_co">
                     <strong class="form-strong">*</strong> <{t}>BusinessCode<{/t}>为10位.
				</td>
                             
        	</tr>
            <{/if}>

            <{if $customer.customer_type eq "0"}>
			<tr>
                <td class="formlabel1"><{t}>EShopPlatform<{/t}>：</td>
                 <td ><input class="text-input" type="text" id="eshop_platform" name="eshop_platform"></td>
				<td class="formlabel1"><{t}>EShopName<{/t}>：</td>
				<td><input class="text-input" type="text" id="eshop_name" name="eshop_name">
                     
				</td>
                             
        	</tr>
            <{/if}>



            <{if $customer.customer_type eq "0"}>
        	<tr>
                <td class="formlabel1">交易币种：</td>
                <td colspan=3>
                    <select id="currency" name="currency" class="text-input2">
                    <option value="">请选择...</option>
                    <option value="RMB">人民币</option>
                    <{* <!-- 先固定为人民币 -->
                    <{if $currency neq ""}>
                    <{foreach from=$currency item=item}>
                        <option value="<{$item['currency_code']}>"><{$item["currency_name"]}></option>
                        <{/foreach}>
                    <{/if}>
                    *}>
                    </select>
				
                     <strong class="form-strong">*</strong> 
				</td>
                             
        	</tr>
            <{/if}>
            <{if $customer.customer_type eq "0"}>
			<tr>
                <td class="formlabel1">营业执照：</td>
                 <td ><input type="file" id="license" class="text-input2" name="license" /></td>
				<td class="formlabel1">身份证件：</td>
				<td><input type="file" id="identity" name="identity"  class="text-input2" />
                     
				</td>
                             
        	</tr>
            <{/if}>




        	<tr>
                <{if $customer.customer_type eq "0"}>
                <td class="formlabel1">报关注册登记证：</td>
                <td ><input type="file" id="customlsn" name="customlsn"  class="text-input2" /></td>
                <{/if}>
                <td class="formlabel1">姓氏：</td>
                <td ><input class="text-input" type="text" id="lastname" name="lastname" /><strong class="form-strong">*</strong></td>                
        	</tr>



        	<tr>
                <td class="formlabel1">名字：</td>
                <td ><input class="text-input" type="text" id="firstname" name="firstname"/><strong class="form-strong">*</strong></td>
                <td class="formlabel1">电话：</td>
                <td ><input class="text-input" type="text" id="telphone" name="telphone" /><strong class="form-strong">*</strong></td>                
        	</tr>
			
        	<tr>
                <td class="formlabel1">传真：</td>
                <td > <input class="text-input" type="text"id="fax" name="fax"/></td>
                <td class="formlabel1">国家：</td>
                <td >
				
				     <select id="country" name="country" class="text-input2">
                        <option value="">请选择国家</option>
                        <{if $country neq ""}>
                        <{foreach from=$country item=item}>
                            <option value="<{$item['country_id']}>" <{if $item['country_name'] eq "中国"}>selected="selected"<{/if}>><{$item['country_name']}></option>
                            <{/foreach}>
                        <{/if}>
                    </select><strong class="form-strong">*</strong></td>                
        	</tr>
			
			

        	<tr>
                <td class="formlabel1">省份：</td>
                <td ><input class="text-input" type="text" id="province" name="province"><strong class="form-strong">*</strong></td>
                <td class="formlabel1">城市：</td>
                <td >
				
				<input class="text-input" type="text" id="city" name="city"><strong class="form-strong">*</strong>
				</td>                
        	</tr>	
			
			
        	<tr>
                <td class="formlabel1">地址：</td>
                <td ><input class="text-input" type="text" id="address" name="address"/><strong class="form-strong">*</strong></td>
                <td class="formlabel1">邮编：</td>
                <td >
				
				<input class="text-input" type="text" id="postno" name="postno"/>
				</td>                
        	</tr>	
			
			<tr>
 				<td class="formlabel1"></td>			
				<td colspan="3">
					<input type="button" class="button text-input" value="提交" style="width:80px;" id="registersub"/>				
				<td>
			</tr>					
			<tr>
 				<td class="formlabel1"></td>			
				<td colspan="3">
				<ul id="registerinfo">
						
				</ul>				
				<td>
			</tr>				

			</table>         
		
		

			

				
            </fieldset>
        </form>
    </div>
</div>
</div>
<script type="text/javascript" language="javascript">
	$(function(){
		//$("#regform").validationEngine();
		$('#registersub').bind('click',checkForm);
	})

    function alertTip(tip, reloadinfo) {
        var reloadinfo =  reloadinfo||1;
		if(reloadinfo==1){$('#registerinfo').empty();}
		if(reloadinfo==3){
			$('#registerinfo').empty();
			$('<li class="success">'+tip+'</li>').appendTo($('#registerinfo').show());
			return;
		}
		$('<li class="error">'+tip+'</li>').appendTo($('#registerinfo').show());
		
	//	alert(tip);
		return false;
    }
    var customer_type = "<{$customer.customer_type}>";

    function checkForm(){
        var companyname = $("[name='companyname']").val();
        var currency = $("[name='currency']").val();
        var firstname = $("[name='firstname']").val();
        var lastname = $("[name='lastname']").val();
        var telphone = $("[name='telphone']").val();
        var country = $("[name='country']").val();
        var state = $("[name='province']").val();
        var city = $("[name='city']").val();
        var postcode = $("[name='postcode']").val();
        var address = $("[name='address']").val();
		
		var trade_name = $("[name='trade_name']").val();
		var trade_co = $("[name='trade_co']").val();
		var reg = /^[A-Za-z0-9]{10}$/g;
		/*
		var license = $("#identity").val();
		var identity = $("#license").val();
		var customlsn = $("#customlsn").val();
		*/
        if(companyname==""){
            alertTip("公司名称不能为空！");
            return false;
        }
		if(customer_type=="0"){
            if(trade_name==""){
                alertTip("经营单位名称不能为空!");
                return false;
            }
            if(trade_co==""){
                alertTip("经营单位编码不能为空!");
                return false;
            }
            if(!reg.test(trade_co)){
                alertTip("<{t}>BusinessCode<{/t}>为10位");
                return false;
            }
            if(currency==""){
                alertTip("交易币种不能为空！");
                return false;
            }
        }
		/*
		var eshop_platform = $("[name='eshop_platform']").val();
        if(eshop_platform==""){
            alertTip("销售电商平台不能为空!");
            return false;
        }		
		var eshop_name = $("[name='eshop_name']").val();
        if(eshop_name==""){
            alertTip("电商店铺名称不能为空!");
            return false;
        }		
			
        if(license==""){
           alertTip("营业执照必须上传！");
            return false;
        }
		
        if(identity==""){
            alertTip("身份证必须上传！");
            return false;
        }	
        if(customlsn==""){
            alertTip("报关注册登记证必须上传！");
            return false;
        }	
		*/

        if(lastname==""){
             alertTip("姓氏不能为空！");
            return false;
        }		
        if(firstname==""){
           alertTip("名字不能为空！");
            return false;
        }		

		


        if(telphone==""){
            alertTip("电话不能为空！");
            return false;
        }
        if(country==""){
            alertTip("国家不能为空！");
            return false;
        }
        if(state==""){
            alertTip("省份不能为空！");
            return false;
        }
        if(city==""){
            alertTip("城市不能为空！");
            return false;
        }
        if(postcode==""){
            alertTip("邮编不能为空！");
            return false;
        }
        if(address==""){
            alertTip("地址不能为空!");
            return false;
        }
		
		alertTip("");
 		
                $('#registerForm').ajaxSubmit(
				{
                    type:"POST",                    
                    dataType:"json",                    
                    url:'/register/complete',
                    success:function(json) {
						
						
                        var html = '';
                        if(json.ask=='1'){
                           
                            alertTip(json.message,3);
							var gotoURL ='window.location.href="/register/step?current=4"';
							var t = setTimeout(gotoURL,2000);
							
                        }else{
						
							if(typeof(json.authcodeError) != 'undefined' && json.authcodeError ==1){
								$(".verifyChange").trigger('click');
							}
                            html +=json.message;
                            if(typeof(json.error) != 'undefined'){
							
								$('#registerinfo').empty();
                                $.each(json.error,function(key,item){
                                  
								   alertTip(item,2);
								    //html += "<p class='messageFail'><image src='/images/icons/icon_missing.png' /> "+item+"</p>";
                                });
                                //$('.orderMessage').html(html).show();
                            }
                           
                        }
                        //$('.submit').attr('disabled',false);
                    }
                });		
		

    }
	
	
</script>