<style type="text/css">
.ntitle {	
	padding: 0 10px;
	background: #F1F1F1;
	height: 30px;
	line-height: 30px;
}

h2.ntitle {
	font-size: 14px;
	font-weight: bold;
	line-height: 30px;
}

/*index*/
.nbox_c {	
	float: left;
	margin: 0px 0px 20px 0px;
	padding: 0px;
	width: 100%;
	border: 0px solid #DDD;
	overflow: hidden;
	border: 1px solid #D8D8D8;
}


.formtable {
	width: 100%;
	/*table-layout: fixed;*/
	border: 0px;
}

.formtable th, .formtable td {
	padding: 5px 10px;
	border-bottom: 0px solid #F2F2F2;
	vertical-align: top;
	line-height: 1.5em;
	word-wrap: break-word;
	word-break: break-all;
}


.right-title {
	background: #F1F1F1;
	font-size: 14px;
	font-weight: bold;
	height: 20px;
	padding: 12px 0 8px 13px;
	text-shadow: 1px 1px 1px #FFFFFF;
}
</style>


<div class="content-box  ui-tabs  ui-corner-all">
 		<div class="content-box-header">
        	<h3 style="margin-left:5px">快速看板浏览</h3>
        	<div class="clear"></div>
 		</div>	
	
		<div style=" width: 45%;  float: left;  margin: 10px 0px 0px 10px; ">
			<div class="nbox_c">
				<div class="ntitle">
					<span style="display:block; float: left;">
						<h2 class="ntitle" style="padding-left: 0px;">余额信息</h2>
					</span>
				</div>
				<table cellspacing="0" cellpadding="0" class="formtable">
					<tbody>
						<tr>
							<td>可用金额(<{$currency}>)</td>
							<td width="120" style="text-align:right;"><{$aBalance.cb_value}></td>
						</tr>					
						<tr>
							<td>冻结金额(<{$currency}>)</td>
							<td width="120" style="text-align:right;"><{$aBalance.cb_hold_value}></td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:right;">
								<a href="/merchant/finance/list" onclick="parent.openMenuTab('/merchant/finance/list','<{t}>CurrencyBalance<{/t}>','CurrencyBalance');return false;">More</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>			
		</div>
		
		<div style='width:47%; float:right; margin: 10px 10px 0px 0px;'>
			
			<div class="nbox_c" style="height:116px;">
				<div class="ntitle">
					<span style="display:block; float: left;">
						<h2 class="ntitle" style="padding-left: 0px;">接口信息</h2>
					</span>
                    <span id="interface" style="display:block; float: right; ">
                        <{if $customerAPIArray.ca_token }>
                            <a onclick="changeToken('<{$customer_id}>');" href="javascript:void(0);">变更接口信息</a>
                        <{else}>
                            <a onclick="requireToken('<{$customer_id}>');" href="javascript:void(0);">申请接口信息</a>
                        <{/if}>
                    </span>
				</div>
				<table cellspacing="0" cellpadding="0" class="formtable">
					<tbody>
						<tr>
							<td style="width:50px;">Token</td>
							<td id="ca_token"><{$customerAPIArray.ca_token}></td>
						</tr>					
						<tr>
							<td>Key</td>
							<td id="ca_key"><{$customerAPIArray.ca_key}></td>
						</tr>
					</tbody>
				</table>
			</div>
									
		</div>			
			
		<div class='clear'></div>
		
		<div class="right-title">您的未完成任务</div>
		
		
		<div style=" width: 45%;  float: left;  margin: 10px 0px 0px 10px; ">			
		<div class="nbox_c">
			<div class="ntitle">
				<span style="display:block; float: left;">
					<h2 class="ntitle" style="padding-left: 0px;">备货入库</h2>
				</span> 
				<span style="display:block; float: right; ">
					<select style="margin-top: 5px;" name="bhasn" onchange="getAsnDataBH(this.value)">
						<option value="0">-All-</option>
						<{foreach from=$warehouseBH key="k" item="v" }>
						<option value="<{$v.warehouse_id}>"><{$v.warehouse_code}></option>
						<{/foreach}>
					</select>					
				</span>
			</div>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tbody id="asnDataBH">
				<{foreach from=$asnStatBHAll key="k" item="v" }>
					<tr><td style="width:50%;"><{$v.text}></td><td style="text-align:right;"><{$v.num}></td></tr>					
				<{/foreach}>					
					<tr>
						<td colspan="2" style="text-align:right;">
							<a href="/merchant/receiving/listbh" onclick="parent.openMenuTab('/merchant/receiving/listbh','<{t}>StockingASNList<{/t}>','StockingASNList');return false;">More</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
			
		<div class="nbox_c">
			<div class="ntitle">
				<span style="display:block; float: left;">
					<h2 class="ntitle" style="padding-left: 0px;">集货入库</h2>
				</span> 
				<span style="display:block; float: right; ">
					<select style="margin-top: 5px;" name="bhasn" onchange="getAsnDataJH(this.value)">
						<option value="0">-All-</option>
						<{foreach from=$warehouseJH key="k" item="v" }>
						<option value="<{$v.warehouse_id}>"><{$v.warehouse_code}></option>
						<{/foreach}>
					</select>					
				</span>
			</div>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tbody id="asnDataJH">
				<{foreach from=$asnStatJHAll key="k" item="v" }>
					<tr><td style="width:50%;"><{$v.text}></td><td style="text-align:right;"><{$v.num}></td></tr>					
				<{/foreach}>					
					<tr>
						<td colspan="2" style="text-align:right;">
							<a href="/merchant/receiving/listjh"  onclick="parent.openMenuTab('/merchant/receiving/listjh','<{t}>CollectionASNList<{/t}>','CollectionASNList');return false;">More</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
	
	<div style='width:47%; float:right; margin: 10px 10px 0px 0px;'>
	
		<div style="float: right;" class="nbox_c">
			<div class="ntitle">
				<span style="display:block; float: left;">
					<h2 class="ntitle" style="padding-left: 0px;">备货订单</h2>
				</span> 
				<span style="display:block; float: right; ">
					<select style="margin-top: 5px;" name="bhorder" onchange="getOrderData(0, this.value)">
						<option value="0">-All-</option>
						<{foreach from=$warehouseBH key="k" item="v" }>
						<option value="<{$v.warehouse_id}>"><{$v.warehouse_code}></option>
						<{/foreach}>
					</select>					
				</span>
			</div>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tbody id="orderDataBH">
				<{foreach from=$orderStatBH key="k" item="v" }>
					<tr><td style="width:50%;"><{$v.text}></td><td style="text-align:right;"><{$v.num}></td></tr>					
				<{/foreach}>					
					<tr>
						<td colspan="2" style="text-align:right;">
							<a href="/merchant/order/listbh" onclick="parent.openMenuTab('/merchant/order/listbh','<{t}>StockingOrderList<{/t}>','StockingOrderList');return false;">More</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	
		<div style="float: right;" class="nbox_c">
			<div class="ntitle">
				<span style="display:block; float: left;">
					<h2 class="ntitle" style="padding-left: 0px;">集货订单</h2>
				</span> 
				<span style="display:block; float: right; ">
					<select style="margin-top: 5px;" name="jhorder" onchange="getOrderData(1, this.value)">
						<option value="0">-All-</option>
						<{foreach from=$warehouseJH key="k" item="v" }>
						<option value="<{$v.warehouse_id}>"><{$v.warehouse_code}></option>
						<{/foreach}>
					</select>					
				</span>
			</div>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tbody id="orderDataJH">
				<{foreach from=$orderStatJH key="k" item="v" }>
					<tr><td style="width:50%;"><{$v.text}></td><td style="text-align:right;"><{$v.num}></td></tr>					
				<{/foreach}>					
					<tr>
						<td colspan="2" style="text-align:right;">
							<a href="/merchant/order/listjh" onclick="parent.openMenuTab('/merchant/order/listjh','<{t}>CollectingOrderList<{/t}>','CollectingOrderList');return false;">More</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	
	</div>
	<div class='clear'></div>
		
</div>

<!-- <div class="content-box  ui-tabs  ui-corner-all" style="margin-top:20px;">
	<div class="content-box-header">
		<h3 style="margin-left:5px">快速浏览您的未完成任务</h3>
		<div class="clear"></div>
	</div>
	
	<div style=" width: 45%;  float: left;  margin: 10px 0px 0px 10px; ">			
		<div class="nbox_c">
			<div class="ntitle">
				<span style="display:block; float: left;">
					<h2 class="ntitle" style="padding-left: 0px;">备货ASN</h2>
				</span> 
				<span style="display:block; float: right; ">
					<select style="margin-top: 5px;" name="bhasn" onchange="getAsnDataBH(this.value)">
						<option value="0">-All-</option>
						<{foreach from=$warehouseBH key="k" item="v" }>
						<option value="<{$v.warehouse_id}>"><{$v.warehouse_name}></option> 
						<{/foreach}>
					</select>					
				</span>
			</div>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tbody id="asnDataBH">
				<{foreach from=$asnStatBHAll key="k" item="v" }>
					<tr><td style="width:50%;"><{$v.text}></td><td style="text-align:right;"><{$v.num}></td></tr>					
				<{/foreach}>					
					<tr>
						<td colspan="2" style="text-align:right;">
							<a href="/merchant/receiving/listbh">More</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
			
		<div class="nbox_c">
			<div class="ntitle">
				<span style="display:block; float: left;">
					<h2 class="ntitle" style="padding-left: 0px;">集货ASN</h2>
				</span> 
				<span style="display:block; float: right; ">
					<select style="margin-top: 5px;" name="bhasn" onchange="getAsnDataJH(this.value)">
						<option value="0">-All-</option>
						<{foreach from=$warehouseJH key="k" item="v" }>
						<option value="<{$v.warehouse_id}>"><{$v.warehouse_name}></option> 
						<{/foreach}>
					</select>					
				</span>
			</div>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tbody id="asnDataJH">
				<{foreach from=$asnStatJHAll key="k" item="v" }>
					<tr><td style="width:50%;"><{$v.text}></td><td style="text-align:right;"><{$v.num}></td></tr>					
				<{/foreach}>					
					<tr>
						<td colspan="2" style="text-align:right;">
							<a href="/merchant/receiving/listjh">More</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
		
	</div>
	
	<div style='width:47%; float:right; margin: 10px 10px 0px 0px;'>
	
		<div style="float: right;" class="nbox_c">
			<div class="ntitle">
				<span style="display:block; float: left;">
					<h2 class="ntitle" style="padding-left: 0px;">备货订单</h2>
				</span> 
				<span style="display:block; float: right; ">
					<select style="margin-top: 5px;" name="bhorder" onchange="getOrderData(0, this.value)">
						<option value="0">-All-</option>
						<{foreach from=$warehouseBH key="k" item="v" }>
						<option value="<{$v.warehouse_id}>"><{$v.warehouse_name}></option> 
						<{/foreach}>
					</select>					
				</span>
			</div>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tbody id="orderDataBH">
				<{foreach from=$orderStatBH key="k" item="v" }>
					<tr><td style="width:50%;"><{$v.text}></td><td style="text-align:right;"><{$v.num}></td></tr>					
				<{/foreach}>					
					<tr>
						<td colspan="2" style="text-align:right;">
							<a href="/merchant/order/listbh">More</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	
		<div style="float: right;" class="nbox_c">
			<div class="ntitle">
				<span style="display:block; float: left;">
					<h2 class="ntitle" style="padding-left: 0px;">集货订单</h2>
				</span> 
				<span style="display:block; float: right; ">
					<select style="margin-top: 5px;" name="jhorder" onchange="getOrderData(1, this.value)">
						<option value="0">-All-</option>
						<{foreach from=$warehouseJH key="k" item="v" }>
						<option value="<{$v.warehouse_id}>"><{$v.warehouse_name}></option> 
						<{/foreach}>
					</select>					
				</span>
			</div>
			<table cellspacing="0" cellpadding="0" class="formtable">
				<tbody id="orderDataJH">
				<{foreach from=$orderStatJH key="k" item="v" }>
					<tr><td style="width:50%;"><{$v.text}></td><td style="text-align:right;"><{$v.num}></td></tr>					
				<{/foreach}>					
					<tr>
						<td colspan="2" style="text-align:right;">
							<a href="/merchant/order/listjh">More</a>
						</td>
					</tr>
				</tbody>
			</table>
		</div>
	
	</div>
	<div class='clear'></div>
</div> -->

<script type="text/javascript">
//集货ASN
var asnStatJH = <{$asnStatJH}>;
function getAsnDataJH(warehouse_id) {
	var trs = '';
	$.each(asnStatJH[warehouse_id], function(key, row){
		trs += '<tr><td style="width:50%;">'+row.text+'</td><td style="text-align:right;">'+row.num+'</td></tr>';
	});
	trs += '<tr><td colspan="2" style="text-align:right;"><a href="/merchant/receiving/listjh">More</a></td></tr>';
	$('#asnDataJH').html(trs);
}
//备货ASN
var asnStatBH = <{$asnStatBH}>;
function getAsnDataBH(warehouse_id) {
	var trs = '';
	$.each(asnStatBH[warehouse_id], function(key, row){
		trs += '<tr><td style="width:50%;">'+row.text+'</td><td style="text-align:right;">'+row.num+'</td></tr>';
	});
	trs += '<tr><td colspan="2" style="text-align:right;"><a href="/merchant/receiving/listbh">More</a></td></tr>';
	$('#asnDataBH').html(trs);
}
//订单统计
function getOrderData(mode_type, warehouse_id) {
	$.post('/merchant/order/stat',{'mode_type':mode_type, 'warehouse_id':warehouse_id},function(data){
		var trs = '';
		$.each(data, function(key, row){
			trs += '<tr><td style="width:50%;">'+row.text+'</td><td style="text-align:right;">'+row.num+'</td></tr>';
		});
		if(mode_type==0) {
			trs += '<tr><td colspan="2" style="text-align:right;"><a href="/merchant/order/listbh">More</a></td></tr>';
			$('#orderDataBH').html(trs);
		} else if(mode_type==1) {
			trs += '<tr><td colspan="2" style="text-align:right;"><a href="/merchant/order/listjh">More</a></td></tr>';
			$('#orderDataJH').html(trs);
		}
	},'json');
}

function changeToken(id){
    $.ajax({
        async:true,
        type:'POST',
        url:'/merchant/customer/change-token/id/'+id,
        dataType:'json',
        success:function(json){
            if(json.state=="1"){
                $("#ca_token").html(json.data.token);
                $("#ca_key").html(json.data.key);
                alertTip('接口变更成功!');
            }else{
                alertTip('接口变更失败!');
            }
        }
    });
}

function requireToken(id){
    $.ajax({
        async:true,
        type:'POST',
        url:'/merchant/customer/require-token/id/'+id,
        dataType:'json',
        success:function(json){
            if(json.state=="1"){
                $("#ca_token").html(json.data.token);
                $("#ca_key").html(json.data.key);
                alertTip('接口申请成功!');
                $("#interface").html('<a onclick="changeToken(\'<{$customer_id}>\');" href="javascript:void(0);">变更接口信息</a>');
            }else{
                alertTip('接口申请失败!');
            }
        }
    });
}
</script>