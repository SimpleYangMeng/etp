<div class="top clearfix">
    <p class="dt"><{t}>purchaserDetail<{/t}></p>
    <div class="t_w2 border_b_line"></div>
</div>
<div class="bottom">
    <div class="detail_wrap">
        <div class="detail_table">
            <table class="table-list">
                <tbody>
                    <tr>
                        <th><{t}>accountCode<{/t}></th>
                        <td>
                            <span><{$buerRow.buyer_code}></span>
                            <span class="text-muted">|</span>
                            <span class="text-muted"><{t}>Certified<{/t}></span>
                        </td>
                        <td class="last"></td>
                    </tr>
                    <tr>
                        <th><{t}>Email<{/t}></th>
                        <td><span><{$buerRow.email}></span></td>
                        <td class="last"></td>
                    </tr>
                    <tr>
                        <th><{t}>activeStatus<{/t}></th>
                        <td><span><{$buerRow.is_active_text}></span></td>
                        <td class="last"><!--<span><a href="javascript:;" class="blue-link" seed="last-blueLink" smartracker="on"><{t}>modify<{/t}></a></span>-->
                        </td>
                    </tr>
                    <tr>
                        <th><{t}>companyName<{/t}></th>
                        <td><span><{$buerRow.company_name}></span></td>
                        <td class="last"></td>
                    </tr>
                    <tr>
                        <th><{t}>address<{/t}></th>
                        <td><span><{$buerRow.register_address}></span></td>
                        <td class="last"></td>
                    </tr>
                    <tr>
                        <th><{t}>contactName<{/t}></th>
                        <td><span><{$buerRow.contact_name}></span></td>
                        <td class="last"></td>
                    </tr>
                    <tr>
                        <th><{t}>contactPhone<{/t}></th>
                        <td><span><{$buerRow.contact_telphone}></span></td>
                        <td class="last"></td>
                    </tr>
                    <tr>
                        <th><{t}>currency<{/t}></th>
                        <td><span><{$buerRow.currency}></span></td>
                        <td class="last"></td>
                    </tr>
                    <tr>
                        <th><{t}>regTime<{/t}></th>
                        <td><span><{$buerRow.add_time}></span></td>
                        <td class="last"></td>
                    </tr>
                    <tr>
                        <th>
                            <span class="cl">
                                <span class="icon_text f_left"><{t}>login<{/t}><{t}>password<{/t}></span>
                                <i class="xianrou-iconfont icon-lock f_left"></i>
                            </span>
                        </th>
                        <td><span class="text-muted"><{t}>loginPwdDetailNotice<{/t}></span></td>
                        <td class="last"><span><a href="/buyer/account/modify-login-pwd" class="blue-link" seed="last-blueLink" smartracker="on"><{t}>modify<{/t}></a></span></td>
                    </tr>
                    <tr>
                        <th>
                            <span class="cl">
                                <span class="icon_text f_left"><{t}>payPwd<{/t}></span>
                                <i class="xianrou-iconfont icon-lock f_left"></i>
                            </span>
                        </th>
                        <td><span class="text-muted"><{t}>payPwdNotice<{/t}></span></td>
                        <td class="last"><span><a href="/buyer/account/payment-password" class="blue-link" seed="last-blueLink" smartracker="on"><{t}>modify<{/t}></a></span></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="detail_tab">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><{t}>otherInfo<{/t}></h3>
                </div>
                <div class="panel-body">
                    <ul id="myTab" class="nav nav-tabs">
                        <li class="active"><a href="#accountLog" data-toggle="tab"><{t}>accountLog<{/t}></a></li>
                        <!--<li><a href="#loginLog" data-toggle="tab"><{t}>loginLog<{/t}></a></li>-->
                        <li><a href="#zdAccount" data-toggle="tab"><{t}>zdAccount<{/t}></a></li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade in active" id="accountLog">
                            <div class="table">
                                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                                    <thead>
                                        <tr>
                                            <th width="60"><{t}>operater<{/t}></th>
                                            <th width="100"><{t}>operateTime<{/t}></th>
                                            <th width="100"><{t}>remark<{/t}></th>
                                        </tr>
                                    </thead>
                                    <tbody id="grid_body"></tbody>
                                </table>
                                <!-- 新增分页-->
                                <div class="pageInfo">
                                    <ul class="pagination" id="pagination"></ul>
                                </div>
                            </div>
                        </div>
                        <!--
                        <div class="tab-pane fade" id="loginLog">
                            <div class="table">
                                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                                    <thead>
                                        <tr>
                                            <th width="60"><{t}>loginIp<{/t}></th>
                                            <th width="100"><{t}>remark<{/t}></th>
                                            <th width="100"><{t}>operateTime<{/t}></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <{if !empty($loginLog)}>
                                            <{foreach from=$loginLog item=loginRow name=loginRow}>
                                                <tr>
                                                    <td><{$loginRow.login_ip}></td>
                                                    <td><{$loginRow.bl_note}></td>
                                                    <td><{$loginRow.add_time}></td>
                                                </tr>
                                            <{/foreach}>
                                        <{else}>
                                            <tr><td colspan="2" style="text-align: center;">no data</td></tr>
                                        <{/if}>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        -->
                        <div class="tab-pane fade" id="zdAccount">
                            <div class="table">
                                <table class="table table-striped table-hover table-responsive" cellpadding="0" cellspacing="0" border="0">
                                    <thead>
                                        <tr>
                                            <th><{t}>bankCardNum<{/t}></th>
                                            <th><{t}>changeTime<{/t}></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <{if !empty($zdAccounts)}>
                                            <{foreach from=$zdAccounts item=zdAccount name=zdAccount}>
                                                <tr>
                                                    <td><{$zdAccount.bank_card}></td>
                                                    <td><{$zdAccount.add_time}></td>
                                                </tr>
                                            <{/foreach}>
                                        <{else}>
                                            <tr><td colspan="2" style="text-align: center;">no data</td></tr>
                                        <{/if}>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    ETP.indexAction = 'get-log';
    ETP.url = '/buyer/portal/';
    ETP.getListData = function (json) {
        var html = '';
        $.each(json.data, function (key, val) {
            html += "<tr>";
            html += "<td>" + val.operate_code + "</td>";
            html += "<td>" + val.add_time + "</td>";
            html += "<td>" + val.bl_note + "</td>";
            html += "</tr>";
        });
        return html;
    }
    $(function (){
    });
</script>