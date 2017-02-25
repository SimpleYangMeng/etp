<div class="grid-780 grid-780-pd fn-hidden fn-clear">
    <div class="flow-steps">
        <p class="forgetpassword2">
           
        </p>
    </div>
    <div class="grid-780 fn-clear">
        <div class="hyzxzc_mmmmt">重置密码</div>
        <form id="registerForm" class="fm-layout" method="post" action="/forget-password/reset">
            <fieldset>
                <p class="form-p">
                    <label class="form-label">密码
                        <strong class="form-strong">*</strong>
                    </label>
                    <input  type="password" class="text-input validate[required]" id="password" name="password">
                    <strong></strong>
                </p>
 
                 <p class="form-p">
                    <label class="form-label">确认密码
                        <strong class="form-strong">*</strong>
                    </label>
                    <input  type="password" class="text-input validate[required]" id="con-password" name="con-password">
                    <strong></strong>
                </p>             
               
                <p class="form-p">
                    <label class="form-label">验证码
                        <strong class="form-strong">*</strong>
                    </label>
                    <input  type="text" class=" text-input validate[required]" id="verify" name="verify">
                    <img class="verifyChange" id="verifyImg" title="点击以更新验证码" src="/register/verify-code">
                    <strong style="color: #FF0000;"><a class="verifyChange" href="javascript:void(0);">看不清？换过一个</a></strong>
                </p>
                <p class="form-p">
                    <input type="submit" class="button text-input" value="确定" style="width:80px;" id="registersub" />
                </p>
				<p>
					<ul id="registerinfo"  <{if $errorinfo}>style="display:block" <{/if}>>
						<{$errorinfo}>
					</ul>
				
				</p>
				
            </fieldset>
        </form>
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
	
 	
	
</script>