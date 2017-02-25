<div id="bindding-data">
    <p class="title">
        绑定银行账户
    </p>
    <form id="completeForm" action='/portal/account/add-new-one' class="fm-layout" method="post" data-validator-option="{timely:2, theme:'yellow_right_effect'}">
        <div class="form_group">
            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit">
                    银行类别
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="radio" name="bankType" value="1" checked="checked" data-rule="银行类别:checked" data-tip="请选择证件类型">平安银行
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="bankType" value="2">其他银行
                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit">
                    证件类型
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <select name="idCardType" id="idCardType" class="selBox"  data-rule="证件类型:required" data-tip="请选择证件类型">
                        <option value="">请选择</option>
                        <{foreach from=$idCardType key=key item=item}>
                        <option value="<{$item.bussiness_value}>"><{if $language == 'zh_CN'}><{$item.bussiness_value_name}><{else}><{$item.bussiness_value_en}><{/if}></option>
                        <{/foreach}>
                    </select>
                </div>
                </p>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit">
                    证件号码
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="idNo" id="idNo" placeholder="证件号" data-rule="证件号:required" data-tip="请输入证件号"/>
                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit">
                    持卡人
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="cardOwner" id="cardOwner" placeholder="持卡人姓名" data-rule="持卡人姓名:required" data-tip="请输入持卡人姓名"/>
                </div>
            </div>
            <!-- -->

            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit">
                    银行账号
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="bankAccountNo" id="bankAccountNo" placeholder="银行卡账号" data-rule="银行卡账号:required,bankAccount" data-tip="请输入银行卡账号"/>
                </div>
            </div>
            <!-- -->
            <div class="other-bank-div" style="display:none;">
                <div class="form_item margin_top25 clearfix">
                    <p class="tit">
                        银行属性
                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <input type="radio" name="bankAttr" value="1" checked="checked">大小额行
                        &nbsp;&nbsp;&nbsp;&nbsp;
                        <input type="radio" name="bankAttr" value="2">超级网银行
                    </div>
                </div>

                <!-- -->
                <div class="form_item margin_top25 clearfix bank-div">
                    <p class="tit">
                        银行所在地
                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <div style="display:inline-block;">
                        <select name="province" id="province" class="selBox2">
                            <option value="">请选择</option>
                        <{foreach from=$provinces key=key item=item}>
                            <option value="<{$item.code}>"><{$item.name}></option>
                        <{/foreach}>
                        </select>
                        <select name="city" id="city" class="selBox2">、
                            <option value="">请选择</option>
                        </select>
                        <select name="district" id="district" class="selBox2">
                            <option value="">请选择</option>
                        </select>
                        </div>
                        <div style="display:inline-block;vertical-align:middle" class="searchDiv">
                            <input class="searchInput keywords" style="width: auto!important" placeholder="输入关键字查询收款行" type="text" name="keyword" id="keyword">
                            <i class="blueSearchBtn"></i>
                        </div>
                    </div>
                </div>
                <!-- -->

                <!-- -->
                <div class="form_item margin_top25 clearfix bank-div">
                    <p class="tit">
                        大小额行号
                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <select name="bankNo" id="bankNo" class="selBox">
                            <option value="">请选择</option>
                        </select>
                    </div>
                </div>

                <!-- -->
                <div class="form_item margin_top25 clearfix sBank-div" style="display:none">
                    <p class="tit">
                        超级网银号
                        <span class="blue_00a0e9">
                            *
                        </span>
                    </p>
                    <div class="dl2">
                        <select name="sBankNo" id="sBankNo" class="selBox"">
                            <option value="">请选择</option>
                            <{foreach from=$supperBank key=key item=item}>
                            <option value="<{$item.No}>"><{$item.name}></option>
                            <{/foreach}>
                        </select>
                    </div>
                </div>
            </div>
            <!-- -->
            <div class="form_item margin_top25 clearfix">
                <p class="tit">
                    银行预留手机号码
                    <span class="blue_00a0e9">
                        *
                    </span>
                </p>
                <div class="dl2">
                    <input type="text" class="input" name="mobilePhone" id="mobilePhone" placeholder="请输入手机号" data-rule="手机号:required,phoneCN" data-tip="请输入手机号"/>
                </div>
            </div>

            <!-- 提交按钮-->
            <div class="form_item margin_top50 clearfix">
                <p class="tit">
                    &nbsp;
                </p>
                <div class="dl2" class="submitBtn">
                    <a href="javascript:" class="blue_btn submitBtn">
                        确认提交
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="success-div" style="display:none;margin-top:15%;text-align:center;font-size:15px">
    <i class="sucIcon"></i> 绑定成功,你可进行以下操作：
    <p class="margin_top25">
        <a href="javascript:" class="blue_btn blue_btn_h_32 cb">打款测试</a>
    </p>
    <p class="margin_top20"><a href="/portal/supplier/index" class="blue_link f14">系统将在 <span id="to">5</span>s 后自动跳转至提现账户管理界面 </a></p>
</div>
<div id="error-div" style="display:none;margin-top:5px;" class="form_item margin_top25 clearfix" >
    <p class="tit">
        &nbsp;
    </p>
    <div class="dl2">
    </div>
</div>
<form id="confirm-bank" action="/portal/account/confirm-bank-card" method="post" style="display:none;">
    <input type="hidden" name="aNo" id="aNo" value="" >
    <input type="hidden" name="bNo" id="bNo" value="" >
</form>
<link rel="stylesheet" href="/etp_style_v1.0/js/nice-validator/jquery.validator.css"/>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/jquery.validator.js"></script>
<script type="text/javascript" src="/etp_style_v1.0/js/nice-validator/local/zh-CN.js"></script>

<script type="text/javascript">
    $(function() {
        $('.submitBtn').click(function() {
            $('#completeForm').submit();
        });
        $('#completeForm').validator({
            rules: {
                phoneCN:[/^1[34578]\d{9}$/, '手机号不正确'],
                idCard:[/(^\d{15}$)|(^\d{18}$)|(^\d{17}(\d|X|x)$)/,'证件号不正确'],
                bankAccount:[/^(\d{0,4}\s*)+$/,'银行账号不正确']
            },
            valid: function() {
                $('.submitBtn').showLoading({addClass:'loading-indicator-circle-1'});
                $.ajax({
                    type: "POST",
                    async: false,
                    dataType: "json",
                    data: $('#completeForm').serialize(),
                    url: '/portal/account/add-new-one',
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
                $('#idNo').attr({"data-rule":"身份证:required,idCard"});
            } else {
                $('#idNo').attr({"data-rule":"证件:required"});
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
                $('.bankAttr[value=1]').prop('checked');
                $('.other-bank-div .selBox').val('')
                $('.other-bank-div .selBox2').val('')
                //$('#province').removeAttr('data-rule').val('');
                //$('#city').removeAttr('data-rule').children('option:gt(0)').remove();
                //$('#district').removeAttr('data-rule').children('option:gt(0)').remove();
                $('#bankNo').removeAttr('data-rule').removeAttr('data-tip').children('option:gt(0)').remove();
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');
            } else {
                $('.other-bank-div').fadeIn();
                //$('#province').attr({"data-rule":"省份:required"});
                $('#bankNo').attr({"data-rule":"大小额行号:required","data-tip":'请选择大小额行号'});
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');
            }
        });
        $('[name=bankAttr]').click(function() {
            if( $(this).val() == 1 ) {
                $('.sBank-div').hide();
                $('.bank-div').show();
                $('#sBankNo').val('')
                $('.other-bank-div .selBox2').val('');
                //$('#province').removeAttr('data-rule').val('');
                //$('#city').removeAttr('data-rule').children('option:gt(0)').remove();
                //$('#district').removeAttr('data-rule').children('option:gt(0)').remove();
                $('#bankNo').attr({"data-rule":"大小额行号:required","data-tip":'请选择大小额行号'});
                $('#sBankNo').removeAttr('data-rule').removeAttr('data-tip').val('');

            } else {
                $('.bank-div').hide();
                $('.sBank-div').show();
                //$('#province').attr({"data-rule":"省份:required"});
                $('#bankNo').removeAttr('data-rule').removeAttr('data-tip').children('option:gt(0)').remove();
                $('#sBankNo').attr({"data-rule":"超级网银号:required","data-tip":'请选择超级网银号'});
            }
                
        })
    })
    function getCity() {
        if( $('#province').val() == '' ) {
            $('#city').children('option:gt(0)').remove();
            $('#district').children('option:gt(0)').remove();
            return;
        }
        //$('#city').attr({"data-rule":"城市:required"}).children('option:gt(0)').remove();
        $.ajax({
            type:'post',
            async:true,
            dataType:'json',
            url:'/portal/common/get-city',
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
        //$('#district').attr({"data-rule":"区(县):required"}).children('option:gt(0)').remove();
        $.ajax({
            type:'post',
            async:true,
            dataType:'json',
            url:'/portal/common/get-district',
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
            url:'/portal/common/get-bank',
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
            window.location = '/portal/account/bank-account';
            return;
        }
        setTimeout("timedCount()",1000)
    } 
</script>