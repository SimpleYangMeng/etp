<?php
/**
 * 买家提现申请汇总表（每日汇总所有客户的提现）
 */
class DbTable_BuyerWithdrawSummary extends Ec_Model_DbTable_Common {
  protected $_name = 'buyer_withdraw_summary';
  protected $_primary = 'buyer_withdraw_summary_id';
}
