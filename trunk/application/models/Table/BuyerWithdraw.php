<?php
class Table_BuyerWithdraw
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_BuyerWithdraw();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_BuyerWithdraw();
    }

    /**
     * @param $row
     * @return mixed
     */
    public function add($row)
    {
        return $this->_table->insert($row);
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function update($row, $value, $field = "buyer_withdraw_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "buyer_withdraw_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->delete($where);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public function getByField($value, $field = 'buyer_withdraw_id', $colums = "*")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $colums);
        $select->where("{$field} = ?", $value);
        return $this->_table->getAdapter()->fetchRow($select);
    }

    public function getAll()
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, "*");
        return $this->_table->getAdapter()->fetchAll($select);
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $orderBy
     * @return array|string
     */
    public function getByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->where("1 =?", 1);
        /*CONDITION_START*/
        if(isset($condition["buyer_id"]) && $condition["buyer_id"] != ""){
            $select->where("buyer_id = ?",$condition["buyer_id"]);
        }
        if(isset($condition["withdraw_code"]) && $condition["withdraw_code"] != ""){
            $select->where("withdraw_code = ?",$condition["withdraw_code"]);
        }
        if(isset($condition["bank_card"]) && $condition["bank_card"] != ""){
            $select->where("bank_card = ?",$condition["bank_card"]);
        }
        if(isset($condition["withdraw_type"]) && $condition["withdraw_type"] != ""){
            $select->where("withdraw_type = ?",$condition["withdraw_type"]);
        }
        if(isset($condition["bank_buyer_name"]) && $condition["bank_buyer_name"] != ""){
            $select->where("bank_buyer_name = ?",$condition["bank_buyer_name"]);
        }
        if(isset($condition["status"]) && !empty($condition["status"])){
            $select->where("status IN (?)", $condition["status"]);
        }
        if(isset($condition["add_time_start"]) && $condition["add_time_start"] != ""){
            $select->where("add_time >= ?",$condition["add_time_start"]);
        }
        if(isset($condition["add_time_end"]) && $condition["add_time_end"] != ""){
            $select->where("add_time <= ?",$condition["add_time_end"]);
        }
        /*CONDITION_END*/
        if ('count(*)' == $type) {
            return $this->_table->getAdapter()->fetchOne($select);
        } else {
            if (!empty($orderBy)) {
                $select->order($orderBy);
            }
            if ($pageSize > 0 and $page > 0) {
                $start = ($page - 1) * $pageSize;
                $select->limit($pageSize, $start);
            }
            $sql = $select->__toString();
            //echo $sql;
            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }
}