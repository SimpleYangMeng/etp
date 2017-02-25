<div id="bindding-data">
    <p class="title">
        <{t}>addNewBankCard_U<{/t}>
    </p>
    <form id="completeForm" class="fm-layout" method="post" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
        <div class="form_group">
            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit <{if $language=='en_US'}> tit_w300<{/if}>">
                    <{t}>bankType<{/t}><{t}>colon<{/t}>
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="radio" name="bankType" value="1" checked="checked" data-rule="<{t}>bankType<{/t}>:checked" data-tip="<{t}>pleaseChooseBankType<{/t}>"><{t}>pingAnBank<{/t}>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="bankType" value="2"><{t}>otherBank<{/t}>
                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                    <{t}>IdCardType<{/t}><{t}>colon<{/t}>
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <select name="idCardType" id="idCardType" class="selBox"  data-rule="<{t}>IdCardType<{/t}>:required" data-tip="<{t}>pleaseChooseIdCardType<{/t}>">
                        <option value=""><{t}>pleaseSelected<{/t}></option>
                        <{foreach from=$idCardType key=key item=item}>
                        <option value="<{$item.id_card_no}>"><{if $language == 'zh_CN'}><{$item.id_card_name}><{else}><{$item.id_card_name_en}><{/if}></option>
                        <{/foreach}>
                    </select>
                </div>
                </p>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                    <{t}>IdCardNum<{/t}><{t}>colon<{/t}>
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="idNo" id="idNo" placeholder="<{t}>IdCardNum<{/t}>" data-rule="<{t}>IdCardNum<{/t}>:required" data-tip="<{t}>pleaseInputIdCardNum<{/t}>"/>
                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                    <{t}>cardOwner<{/t}><{t}>colon<{/t}>
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="cardOwner" id="cardOwner" placeholder="<{t}>cardOwner<{/t}>" data-rule="<{t}>cardOwner<{/t}>:required" data-tip="<{t}>pleaseInputCardOwner<{/t}>"/>
                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                    <{t}>bankCardNum<{/t}><{t}>colon<{/t}>
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="bankAccountNo" id="bankAccountNo" placeholder="<{t}>bankCardNum<{/t}>" data-rule="<{t}>bankCardNum<{/t}>:required,bankAccount" data-tip="<{t}>pleaseInputBankCardNum<{/t}>"/>
                </div>
            </div>
            <!-- -->
            <div class="other-bank-div" style="display:none;">
                <div class="form_item margin_top25 clearfix">
                    <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                        <{t}>BankAttribute<{/t}><{t}>colon<{/t}>
                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <input type="radio" name="bankAttr" class="bankAttr" value="1" checked="checked"><{t}>branchBank<{/t}>
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="bankAttr" class="bankAttr" value="2"><{t}>superBank<{/t}>
                        <br/>
                    </div>
                    <div class="dl2" style="<{if $language == 'zh_CN'}>width:500px;margin-left:100px;<{else}>width:350px;margin-left:30px;<{/if}>font-size:13px;">
                        <p id="bank-note-1" class="blue_0054ed"><{t}>bankNote1<{/t}></p>
                        <p id="bank-note-2" class="blue_0054ed" style="display:none"><{t}>bankNote2<{/t}></p>
                    </div>
                </div>
                <!-- -->
                <div class="form_item margin_top10 clearfix bank-div">
                    <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                        <{t}>bankLocation<{/t}><{t}>colon<{/t}>
                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <div style="display:inline-block;">
                        <select name="province" id="province" class="selBox2">
                            <option value=""><{t}>pleaseSelected<{/t}></option>
                        <{foreach from=$provinces key=key item=item}>
                            <option value="<{$item.code}>"><{$item.name}></option>
                        <{/foreach}>
                        </select>
                        <select name="city" id="city" class="selBox2">、
                            <option value=""><{t}>pleaseSelected<{/t}></option>
                        </select>
                        <select name="district" id="district" class="selBox2">
                            <option value=""><{t}>pleaseSelected<{/t}></option>
                        </select>
                        </div>
                        <div style="display:inline-block;vertical-align:middle" class="searchDiv<{if $language=='en_US'}> width300<{/if}>">
                            <input class="searchInput keywords"<{if $language=='en_US'}> style="width: 270px;" <{/if}>placeholder="<{t}>inputKeywordToSearchBank<{/t}>" type="text" name="keyword" id="keyword">
                            <i class="blueSearchBtn"></i>
                        </div>
                    </div>
                </div>
                <!-- -->

                <!-- -->
                <div class="form_item margin_top10 clearfix bank-div">
                    <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                        <{t}>branchBank<{/t}><{t}>colon<{/t}>
                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <select name="bankNo" id="bankNo" class="selBox">
                            <option value=""><{t}>pleaseSelected<{/t}></option>
                        </select>
                    </div>
                </div>

                <!-- -->
                <div class="form_item margin_top25 clearfix sBank-div" style="display:none">
                    <div class="clearfix">
                        <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                            <{t}>superBank<{/t}><{t}>colon<{/t}>
                            <span class="blue_00a0e9">
                                *
                            </span>
                        </p>
                        <div class="dl2">
                            <select name="sBankNo" id="sBankNo" class="selBox"">
                                <option value=""><{t}>pleaseSelected<{/t}></option>
                                <{foreach from=$supperBank key=key item=item}>
                                <option value="<{$item.No}>"><{$item.name}></option>
                                <{/foreach}>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                    <{t}>phoneNumLeftForBank<{/t}><{t}>colon<{/t}>
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="mobilePhone" id="mobilePhone" placeholder="<{t}>inputPhoneNumLeftForBank<{/t}>" data-rule="<{t}>phoneNumLeftForBank<{/t}>:required,phoneCN" data-tip="<{t}>inputPhoneNumLeftForBank<{/t}>"/>
                </div>
            </div>

            <!-- 提交按钮-->
            <div class="form_item margin_top50 clearfix">
                <p class="tit<{if $language=='en_US'}> tit_w300<{/if}>">
                    &nbsp;
                </p>
                <div class="dl2" class="submitBtn">
                    <a href="javascript:" class="blue_btn submitBtn">
                        <{t}>submit<{/t}>
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="success-div" style="display:none;margin-top:15%;text-align:center;font-size:15px">
    <i class="sucIcon"></i> <{t}>addBankCardTip1<{/t}>
    <p class="margin_top25">
        <a href="javascript:" class="blue_btn blue_btn_h_32 cb"><{t}>addBankCardTip2<{/t}></a>
    </p>
    <p class="margin_top20"><a href="/seller/bank/card" class="blue_link f14">
    <{if $language=='zh_CN'}>
    系统将在 <span id="to">5</span>s 后自动跳转至提现账户管理界面
    <{else}>
    The system will automatically jump to the <{t}>cashAccountManagement<{/t}> after <span id="to">5s</span>
    <{/if}>
    </a></p>
</div>
<div id="error-div" style="display:none;margin-top:5px;" class="form_item margin_top25 clearfix" >
    <p class="tit">
        &nbsp;
    </p>
    <div class="dl2">
    </div>
</div>
<form id="confirm-bank" action="/seller/account/confirm-bank-card" method="post" style="display:none;">
    <input type="hidden" name="aNo" id="aNo" value="" >
    <input type="hidden" name="bNo" id="bNo" value="" >
</form>
<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/<{$language}>.js"></script>

<script type="text/javascript">
    $(function() {
        $('.submitBtn').click(function() {
            $('#completeForm').submit();
        });
        $('#completeForm').validator({
            rules: {
                phoneCN:[/^1[34578]\d{9}$/, '<{t}>wrongPhoneNum<{/t}>'],
                idCard:[/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/,'<{t}>wrongIdNum<{/t}>'],
                bankAccount:[/^(\d{0,4}\s*)+$/,'<{t}>wrongBankCardNum<{/t}>']
            },
            valid: function() {
                $('.submitBtn').showLoading({addClass:'loading-indicator-circle-1'});
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#completeForm').serialize(),
                    url: '/seller/bank/add-new-one',
                    success: function(json) {
                        if( json.state == 1) {
                            $('#bindding-data').hide();
                            document.getElementById('completeForm').reset();
                            $('#aNo').val(json.aNo);
                            $('#bNo').val(json.bNo);
                            $('#success-div').show();
                            timedCount();
                            $('#error-div > .dl2').html('');
                            $('#error-div').hide();
                        } else {
                            var html = '';
                            if( json.message )
                                html += '<p class="red_text"><i class="errorIcon"></i> '+ json.message +'</p>';
                            if( json.error.length > 0 ) {
                                $.each(json.error,function(k,v) {
                                    html += '<p class="red_text"><i class="errorIcon"></i> '+ v.errorMsg +'</p>';
                                });
                            }
                            $('#error-div > .dl2').html(html);
                            $('#error-div').show();
                        }
                    }
                });
                $('.submitBtn').hideLoading();
            }
        });
        $('#bankAccountNo').keyup(function() {
            var s = $.trim($(this).val());
            $(this).val(s.replace(/(\S{4})(?=\S)/g,"$1"+" "));
        });
        $('#idCardType').change(function(){
            if( $(this).val() == '1') {
                $('#idNo').attr({"data-rule":"<{t}>IdCard<{/t}>:required,idCard"});
            } else {
                $('#idNo').attr({"data-rule":"<{t}>paper<{/t}>:required"});
            }
        })
        $('#province').change(function() {
            getCity();
        })
        $('#city').change(function() {
            getDistrict();
        })
        $('#district').change(function() {
            getBank();
        })
        $('#keyword').keyup(function(event){
            var keycode = (event.keyCode ? event.keyCode : event.which);  
            console.log(keycode);
            if(keycode == '13'){  
                getBank();
            }  
        })
        $('.blueSearchBtn').click(function(){
            getBank();
        });
        $('.cb').click(function() {
            document.getElementById('confirm-bank').submit(); 
        });
        $('[name=bankType]').click(function(){
            if( $(this).val() == 1 ) {
                $('.other-bank-div').fadeOut();
                $('.bankAttr[value=1]').prop('checked',true);
                $('.other-bank-div .selBox').val('')
                $('.other-bank-div .selBox2').val('')
                //$('#province').removeAttr('data-rule').val('');
                //$('#city').removeAttr('data-rule').children('option:gt(0)').remove();
                //$('#district').removeAttr('data-rule').children('option:gt(0)').remove();
                $('#bankNo').removeAttr('data-rule').removeAttr('data-tip').children('option:gt(0)').remove();
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');
            } else {
                $('.other-bank-div').fadeIn();
                //$('#province').attr({"data-rule":"<{t}>province<{/t}>:required"});
                $('#bankNo').attr({"data-rule":"<{t}>branchBank<{/t}>:required","data-tip":'<{t}>pleaseChooseBranchBank<{/t}>'});
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');
                $('#bank-note-2').hide();
                $('#bank-note-1').show();
            }
        });
        $('[name=bankAttr]').click(function() {
            if( $(this).val() == 1 ) {
                $('#bank-note-2').hide();
                $('#bank-note-1').show();
                $('.sBank-div').hide();
                $('.bank-div').show();
                $('#sBankNo').val('')
                $('.other-bank-div .selBox2').val('');
                //$('#province').removeAttr('data-rule').val('');
                //$('#city').removeAttr('data-rule').children('option:gt(0)').remove();
                //$('#district').removeAttr('data-rule').children('option:gt(0)').remove();
                $('#bankNo').attr({"data-rule":"<{t}>branchBank<{/t}>:required","data-tip":'<{t}>pleaseChooseBranchBank<{/t}>'});
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');

            } else {
                $('#bank-note-1').hide();
                $('#bank-note-2').show();
                $('.bank-div').hide();
                $('.sBank-div').show();
                //$('#province').attr({"data-rule":"<{t}>province<{/t}>:required"});
                $('#bankNo').removeAttr('data-rule').removeAttr('data-tip').children('option:gt(0)').remove();
                $('#sBankNo').attr({"data-rule":"<{t}>super<{/t}>:required","data-tip":'<{t}>pleaseChooseSuperBank<{/t}>'});
            }
                
        })
    })
    function getCity() {
        if( $('#province').val() == '' ) {
            $('#city').children('option:gt(0)').remove();
            $('#district').children('option:gt(0)').remove();
            return;
        }
        //$('#city').attr({"data-rule":"<{t}>city<{/t}>:required"}).children('option:gt(0)').remove();
        $.ajax({
            type:'post',
            async:true,
            dataType:'json',
            url:'/common/area/get-city',
            data:{province:$('#province').val()},
            success:function( json ) {
               if( json.length > 0 ) {
                    var html = '';
                    $.each(json,function(k,v) {
                        html += '<option value="'+v.code+'">'+v.name+'</option>';
                    });
               }
               if(html)
                $('#city').append(html);
               getDistrict();
            }
        })
    }
    function getDistrict() {
        if( $('#city').val() === '' ) {
            $('#district').children('option:gt(0)').remove();
            return;
        }
        //$('#district').attr({"data-rule":"<{t}>town<{/t}>:required"}).children('option:gt(0)').remove();
        $.ajax({
            type:'post',
            async:true,
            dataType:'json',
            url:'/common/area/get-district',
            data:{city:$('#city').val()},
            success:function( json ) {
                var html = '';
               if( json.length > 0 ) {
                    $.each(json,function(k,v) {
                        html += '<option value="'+v.name+'">'+v.name+'</option>';
                    });
               }
               if(html)
                    $('#district').append(html);

               getBank();
            }
        })
    }
    function getBank() {
        $('#bankNo').children('option:gt(0)').remove();
        $.ajax({
            type:'post',
            async:true,
            dataType:'json',
            url:'/seller/bank/get-bank',
            data:{
                province:$('#province').val(),
                city:$('#city').val(),
                district:$('#district').val(),
                keyword:$('#keyword').val()
            },
            success:function( json ) {
                var html = '';
                if(json.length > 0 ){
                    $.each(json,function(k,v){
                        html += '<option value="'+ v.No +'">'+ v.Name +'</option>';
                    })
                }
                $('#bankNo').append(html);
            }
        })
    }
    function timedCount() {
        var c=parseInt($('#to').html())-1;
        $('#to').html(c);
        if(c == 0) {
            window.location = '/seller/bank/card';
            return;
        }
        setTimeout("timedCount()",1000)
    } 
</script>