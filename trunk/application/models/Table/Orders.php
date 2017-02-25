<?php
class Table_Orders
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Orders();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_ByerLog();
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
    public function update($row, $value, $field = "order_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "order_id")
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
    public function getByField($value, $field = 'order_id', $colums = "*")
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
        if(isset($condition["order_status"]) && $condition["order_status"] != ""){
            $select->where("order_status = ?",$condition["order_status"]);
        }
        if(isset($condition["pay_status"]) && $condition["pay_status"] != ""){
            $select->where("pay_status = ?",$condition["pay_status"]);
        }
        if(isset($condition["buyer_id"]) && $condition["buyer_id"] != ""){
            $select->where("buyer_id = ?",$condition["buyer_id"]);
        }
        if(isset($condition["buyer_code"]) && $condition["buyer_code"] != ""){
            $select->where("buyer_code = ?",$condition["buyer_code"]);
        }
        if(isset($condition["order_code"]) && $condition["order_code"] != ""){
            $select->where("order_code = ?",$condition["order_code"]);
        }
        if(isset($condition["plate_code"]) && $condition["plate_code"] != ""){
            $select->where("plate_code = ?",$condition["plate_code"]);
        }
        if(isset($condition["seller_code"]) && $condition["seller_code"] != ""){
            $select->where("seller_code = ?",$condition["seller_code"]);
        }
        if(isset($condition["seller_id"]) && $condition["seller_id"] != ""){
            $select->where("seller_id = ?",$condition["seller_id"]);
        }
        if(isset($condition["reference_no"]) && $condition["reference_no"] != ""){
            $select->where("reference_no = ?",$condition["reference_no"]);
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
            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $orderBy
     * @return array|string
     */
    public function joinOrderPay($condition = array(), $type = '*',$columns = '*',  $pageSize = 0, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->join( 'order_pay', $table.'.order_id = order_pay.order_id', $columns );
        $select->where("1 =?", 1);

        /*CONDITION_START*/
        if(isset($condition["buyer_id"]) && $condition["buyer_id"] != ""){
            $select->where( $table.".buyer_id = ?",$condition["buyer_id"]);
        }
        if(isset($condition["buyer_code"]) && $condition["buyer_code"] != ""){
            $select->where( $table.".buyer_code = ?",$condition["buyer_code"]);
        }
        if(isset($condition["seller_id"]) && $condition["seller_id"] != ""){
            $select->where( $table.".seller_id = ?",$condition["seller_id"]);
        }
        if(isset($condition["seller_code"]) && $condition["seller_code"] != ""){
            $select->where( $table.".seller_code = ?",$condition["seller_code"]);
        }
        if(isset($condition["order_status"]) && $condition["order_status"] !== ""){
            $select->where( $table.".order_status = ?",$condition["order_status"]);
        }
        if(isset($condition["order_status_array"]) && !empty( $condition["order_status_array"] ) ){
            $select->where( $table.".order_status in (?)",$condition["order_status_array"]);
        }
        if(isset($condition["pay_time_start"]) && $condition["pay_time_start"] != ""){
            $select->where("order_pay.pay_time >= ?",$condition["pay_time_start"]);
        }
        if(isset($condition["pay_time_end"]) && $condition["pay_time_end"] != ""){
            $select->where("order_pay.pay_time <= ?",$condition["pay_time_end"]);
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
            return $this->_table->getAdapter()->fetchAll($sql);
        }
    }
}