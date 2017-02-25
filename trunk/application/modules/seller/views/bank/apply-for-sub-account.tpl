<div id="app-data">
    <div class="top clearfix">
        <p class="dt">
            <{t}>applySubAccount<{/t}>
        </p>
        <div class="t_w2 border_b_line">
        </div>
    </div>
    <form id="applyForm">
        <div class="bottom">
            <div class="form_group clearfix">
                <div class="form_item margin_top45 clearfix">
                    <span class="<{if $language=='zh_CN'}>width110<{else}>width120<{/if}> f_left">
                        <{t}>mobilePhone<{/t}><{t}>colon<{/t}>
                        <em class="blue_00a0e9">
                            *
                        </em>
                    </span>
                    <div class="dl f_left clearfix">
                        <input type="text" class="input" id="mPhone" name="mobile" placeholder="<{t}>mPhoneRequired<{/t}>"/>
                    </div>
                    <p class="tip350 f_left error">
                        <{t}>subAccountPhoneTip<{/t}>
                    </p>
                </div>
                <!-- -->
                <div class="form_item  clearfix" style="margin-top: 50px">
                    <span class="<{if $language=='zh_CN'}>width110<{else}>width120<{/if}> f_left">
                        &nbsp;
                    </span>
                    <p class="f_left">
                        <a href="javascript:" class="f_left blue_btn f16 blue_btn_h_32 subApp margin_left10">
                            <{t}>submitApplication<{/t}>
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>
<div id="success-div" style="display:none;margin-top:15%;text-align:center;font-size:15px">
    <i class="sucIcon"></i> <{t}>appSubAccountTip<{/t}><a href="/seller/bank/card" style="color:blue;">【<{t}>wAccountMan<{/t}>】</a>
</div>
<div id="error-div" style="display:none;margin-top:5px;" class="form_item margin_top25 clearfix" >
    <p class="tit width120 f_left">
        &nbsp;
    </p>
    <div class="dl2">
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('.subApp').click(function() {
            $(this).showLoading({addClass:'loading-indicator-circle-1'});
            var mp = $.trim( $('#mPhone').val() );
            var regex = /^1[34578]\d{9}$/;
            if( mp == '' ){
                $('#mPhone').parent().next('.error').html('<{t}>pleaseInputPhoneNum<{/t}>');
            }else if( false == regex.test( mp ) ) {
                $('#mPhone').parent().next('.error').html('<{t}>wrongPhoneNum<{/t}>');
            } else {
                $.ajax({
                    type:'post',
                    dataType:'json',
                    async:false,
                    url:'/seller/bank/apply-sub-account',
                    data:{mPhone:$('#mPhone').val()},
                    success:function(json) {
                        if( json.state == 1) {
                            $('#app-data').hide();
                            applyForm.reset();
                            $('#success-div').show();
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
                })
            }
            $(this).hideLoading();
        })
    })
</script>