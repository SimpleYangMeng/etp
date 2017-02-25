<form id="confirm-card">
    <div id="confirm-data">
        <div class="tips_notice">
            <div class="form_group margin_top25">
                <div class="form_item clearfix">
                    <p class="tit" style="width: 150px">收到的转账金额 <span class="blue_00a0e9">:</span></p>
                    <div class="dl">
                        <input type="text" class="input" id="amount" name="amount" placeholder="请输入您收到的转账金额"/>
                    </div>
                    <p class="tip error" style="width: 300px"></p>
                </div>
            </div>
            <p class="margin_top45"><a href="javascript:" class="blue_btn blue_btn_h_32 margin_left190 submitBtn">确认提交</a></p>
        </div>
    </div>
    <input type="hidden" name="aNo" id="aNo" value="<{$aNo}>">
    <input type="hidden" name="bNo" id="bNo" value="<{$bNo}>">
    <div id='success-div' class="tips_notice" style="display:none;">
        <div class="bot">
            <p class="margin_top20"><a href="/portal/account/bank-account" class="blue_link f14 margin_left150 jUrl" id="jUrl">激活成功，系统将在 <span id="to">5</span>s 后自动跳转至提现账户管理 </a></p>
        </div>
    </div>
    <div id="error-div" style="display:none;margin-top:5px;" class="form_item margin_top25 clearfix" >
        <p class="tit" style="width: 150px;padding-left: 230px;">
            &nbsp;
        </p>
        <div class="dl2">
        </div>
    </div>
</form>
<script type="text/javascript">
    $('.submitBtn').click(function(){
        $(this).showLoading({addClass:'loading-indicator-circle-1'});
            $.ajax({
                type: "POST",
                async: false,
                dataType: "json",
                data: {aNo:$('#aNo').val(),bNo:$('#bNo').val(),amount:$('#amount').val()},
                url: '/portal/bank/do-confirm-card',
                success: function(json) {
                    if( json.state == 1) {
                        $('#confirm-data').hide();
                        document.getElementById('confirm-card').reset();
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
        $(this).hideLoading();
    });

    function timedCount() {
        var c=parseInt($('#to').html())-1;
        $('#to').html(c);
        if(c == 0) {
            window.location = $('#jUrl').attr('href');
            return;
        }
        setTimeout("timedCount()",1000)
    } 
</script>