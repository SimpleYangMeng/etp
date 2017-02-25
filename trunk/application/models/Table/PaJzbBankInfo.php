<?php
class Table_PaJzbBankInfo
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_PaJzbBankInfo();
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
    public function update($row, $value, $field = "bank_info_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "bank_info_id")
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
    public function getByField($value, $field = 'bank_info_id', $colums = "*")
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
        if(isset($condition["bank_info_id"]) && $condition["bank_info_id"] !== ""){
            $select->where("bank_info_id = ?",$condition["bank_info_id"]);
        }
        if(isset($condition["bankno"]) && $condition["bankno"] !== ""){
            $select->where("bankno = ?",$condition["bankno"]);
        }
        if(isset($condition["status"]) && $condition["status"] !== ""){
            $select->where("status = ?",$condition["status"]);
        }
        if(isset($condition["bankclscode"]) && $condition["bankclscode"] !== ""){
            $select->where("bankclscode = ?",$condition["bankclscode"]);
        }
        if(isset($condition["citycode"]) && $condition["citycode"] !== ""){
            $select->where("citycode = ?",$condition["citycode"]);
        }
        if(isset($condition["bankname"]) && $condition["bankname"] !== ""){
            $select->where("bankname = ?",$condition["bankname"]);
        }
        if(isset($condition["bankname_like_1"]) && !empty( $condition["bankname_like_1"] ) ){
            $select->where('bankname like ? ', '%' . $condition["bankname_like_1"] . '%');
        }
        if(isset($condition["bankname_like_2"]) && !empty( $condition["bankname_like_2"] ) ){
            $select->where('bankname like ? ', '%' . $condition["bankname_like_2"] . '%');
        }
        //$sql = $select->__toString();
        //echo $sql;exit;
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