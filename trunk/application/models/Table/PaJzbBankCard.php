<?php
class Table_PaJzbBankCard
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_PaJzbBankCard();
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
    public function update($row, $value, $field = "bank_card_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "bank_card_id")
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
    public function getByField($value, $field = 'bank_card_id', $colums = "*")
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
        if(isset($condition["bank_card_id"]) && $condition["bank_card_id"] != ""){
            $select->where("bank_card_id = ?",$condition["bank_card_id"]);
        }
        if(isset($condition["md5_id"]) && $condition["md5_id"] != ""){
            $select->where("MD5(bank_card_id) = ?",$condition["md5_id"]);
        }
        if(isset($condition["account_no"]) && $condition["account_no"] != ""){
            $select->where("account_no = ?",$condition["account_no"]);
        }
        if(isset($condition["bank_card_user_name"]) && $condition["bank_card_user_name"] != ""){
            $select->where("bank_card_user_name = ?",$condition["bank_card_user_name"]);
        }
        if(isset($condition["id_card_type"]) && $condition["id_card_type"] != ""){
            $select->where("id_card_type = ?",$condition["id_card_type"]);
        }
        if(isset($condition["id_card_No"]) && $condition["id_card_No"] != ""){
            $select->where("id_card_No = ?",$condition["id_card_No"]);
        }
        if(isset($condition["bank_card_no"]) && $condition["bank_card_no"] != ""){
            $select->where("bank_card_no = ?",$condition["bank_card_no"]);
        }
        if(isset($condition["bank_type"]) && $condition["bank_type"] != ""){
            $select->where("bank_type = ?",$condition["bank_type"]);
        }
        if(isset($condition["bank_name"]) && $condition["bank_name"] != ""){
            $select->where("bank_name = ?",$condition["bank_name"]);
        }
        if(isset($condition["bank_code"]) && $condition["bank_code"] != ""){
            $select->where("bank_code = ?",$condition["bank_code"]);
        }
        if(isset($condition["super_bank_code"]) && $condition["super_bank_code"] != ""){
            $select->where("super_bank_code = ?",$condition["super_bank_code"]);
        }
        if(isset($condition["phone_no"]) && $condition["phone_no"] != ""){
            $select->where("phone_no = ?",$condition["phone_no"]);
        }
        if(isset($condition["status"]) && $condition["status"] != ""){
            $select->where("status = ?",$condition["status"]);
        }
        if(isset($condition["ccy_code"]) && $condition["ccy_code"] != ""){
            $select->where("ccy_code = ?",$condition["ccy_code"]);
        }
        /*CONDITION_END*/
        //$sql = $select->__toString();
        //echo $sql;exit;
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