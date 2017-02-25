<style type="text/css">
#registerinfo { margin-top: 10px; text-align: center; }
</style>
<div class="common_wrap">
    <div class="reg_wrap">
        <div class="reg_select"><{t}>RegTerms<{/t}></div>
        <div class="reg_form_wrap reg_email_ver_content">
        	<form id="registerForm" class="fm-layout" method="post" action="/register/step?current=3_1&visitor_type=<{$visitor_type}>"  onsubmit="return docheck();">
        		<h2 class="tk_title"><{t}>etpPsP<{/t}></h2>
	            <div class="text-input" type="text" id="provision">
					<div class="tk_in_title">1.商标</div>
					<p class="tk_tiao">
						“保宏”的注册商标的中文简体、繁体和英文“”，包括其文字及图形的组合，我公司已经向国家工商总局商标局申请商标注册，并获得批准。在该域名下的网页内容未经我公司授权允许，擅自使用 “保宏”注册商标，属于恶意侵权行为。
					</p>
					<div class="tk_in_title">2.网站内容准确性</div>
					<p class="tk_tiao">
						本公司网页可能包括由于疏忽大意的不准确现象或排版错误。一旦发现错误，保宏将进行纠正。网页上的内容将定期进行更新，但是在未更新前可能出现不准确。全球独立运行的国际互联网站有成千上万之多，因此通过本网站而访问的某些信息可能来自于保宏之外。因此，保宏对这些内容不承担任何义务或责任。
					</p>
					<div class="tk_in_title">3.免责声明</div>
					<p class="tk_tiao">
						本网站中的服务、内容和信息在法律允许的最大范围内保宏不提供任何陈述和保证，不论是明示的或是暗示的，包括但不限于适用于某特定用途、适销性和非侵权的暗示保证。保宏以及许可方不保证本站点或系统提供的服务、内容和信息的准确性、完整性、安全性或及时性。通过保宏系统或站点获取的信息不应构成任何在保宏使用条款中没有明示的保证。一些具司法管辖权的地区不容许排除暗示保证，因此部分上述的排他条款可能不适用于您的情况。如果您是作为消费者面对免责条款，则这些规定不会影响您的法定权利，如果出现冲突，则您的权利不会被免除。您同意并声明这些使用条款中规定的对责任和保证的限制和排除是公平并且合理的。
					</p>
					<div class="tk_in_title">4.责任限制</div>
					<p class="tk_tiao">
						在法律允许的最大范围内，在任何情况下，无论是根据担保、合同、侵权行为或其它任何法律理论，也无论保宏是否被告知有此类损害的可能性，保宏及其许可方或此站点中提到的其它第三方均不对由于此站点、保宏系统或者包含在站点中的服务、内容或信息的使用、无法使用或使用结果而造成的任何损害负责，包括但不限于由利润损失、数据丢失或业务中断所造成的损害。在适用法律允许的最大范围内，并不对上述内容构成限制，您同意在任何情况下，无论是根据合同、侵权行为或其他，也无论起诉或索赔的方式，保宏对从库内收货起到交至客户物流渠道商终的任何损坏（直接或非直接）或者丢失承担的全部责任不超过商品采购价格，并以保宏仓库实际收货数量和情况为准；对使用保宏提供的物流渠道的任何损坏（直接或非直接）或者丢失承担的全部责任不超过100美元，并以每个物流渠道商提供的赔偿标准为准。最终解释权归保宏所有。在法律允许的最大范围内，在这些使用条款中为您陈述的补救条款将被排除并受限于这些使用条款中的明示内容。
					</p>
					<div class="tk_in_title">5．账户及密码的安全性</div>
					<p class="tk_tiao">
						用户注册后即成为我司会员，将对用户名和密码安全负全部责任，每个用户都要对以其用户名进行的所有活动和事件负全责，用户若发现任何非法使用用户账户或存在安全漏洞的情况，请立即通告本站。
					</p>
					<div class="tk_in_title">6． 信息披露</div>
					<p class="tk_tiao">
						由访问者向保宏网页提供的所有信息都将被视为保密信息，除非由于提供服务所需，保宏将不会将这些信息向任何第三方披露。
					</p>
	       		</div>	
				<p class=""> 
					<label class="agree_label cl">
						<input type="checkbox" class="option-input leftloat" value="1" name="is_agree"/>
						<span class="agree_text leftloat"><{t}>Agree<{/t}></span>
					</label>
				 </p>
				<p style="text-align: center;"> 
					<input type="submit" class="button" style="padding: 8px 12px;" value="<{t}>NextStep<{/t}>" />
				</p>
				<div id="registerinfo"></div>
			</form>
        </div>
    </div>
</div>
<script>
    function alertTip(tip) {  
		$('#registerinfo').empty();
		$('#registerinfo').show();
		$('<span class="error">'+tip+'</span>').appendTo($('#registerinfo'));
		return false;
    }
	function docheck(){	
		var is_agree_bl = $("input[name='is_agree']").attr("checked");
		is_agree_bl = is_agree_bl || 'unchecked';
		if(is_agree_bl=='unchecked'){
			alertTip('<{t}>NoAgree<{/t}>');
			return false;
		}
		return true;
	}
	$(document).ready(function(){
		$("input[name='is_agree']").click(function(){
			var is_agree_bl = $("input[name='is_agree']").attr("checked");
			is_agree_bl = is_agree_bl || 'unchecked';
			if(is_agree_bl=='checked'){				
				$('#submit_button').removeClass('buttongray');				
			}else{
				$('#submit_button').addClass('buttongray');	
			}
		});
	});	
</script>