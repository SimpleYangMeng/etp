<div class="grid-780 grid-780-pd fn-hidden fn-clear">
    <div class="flow-steps">
        <p class="forgetpassword3">
           
        </p>
    </div>
    <div class="grid-780 fn-clear password-reset_successbox">
        	
			<p class="p1"><span class="dui"></span>您的新密码已设置成功!</p>
       
    </div>
	
    <div class="grid-780 fn-clear password-reset_successbox">
        	
			<p class="p2"><span></span><a href="/login" class="floginbutton"></a></p>
       
    </div>	
</div>



<script type="text/javascript" language="javascript">
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
	
    function alertTip2(tip, reloadinfo) {
	   var reloadinfo =  reloadinfo||1;        
		if(reloadinfo==1){$('#registerinfo2').empty();}
		
		if(reloadinfo==3){
			$('#registerinfo2').empty();
			$('<li class="success">'+tip+'</li>').appendTo($('#registerinfo2').show());
			return;
		}
		$('<li class="error">'+tip+'</li>').appendTo($('#registerinfo2').show());
		
	//	alert(tip);
		return false;
    }	
	
</script>