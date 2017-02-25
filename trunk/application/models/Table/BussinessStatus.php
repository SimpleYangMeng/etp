<?php
class Table_BussinessStatus
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_BussinessStatus();
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
    public function update($row, $value, $field = "bussiness_status_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "bussiness_status_id")
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
    public function getByField($value, $field = 'bussiness_status_id', $colums = "*")
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
        if(isset($condition["bussiness_table"]) && $condition["bussiness_table"] != ""){
            $select->where("bussiness_table = ?",$condition["bussiness_table"]);
        }
        if(isset($condition["bussiness_column"]) && $condition["bussiness_column"] != ""){
            $select->where("bussiness_column = ?",$condition["bussiness_column"]);
        }
        if(isset($condition["bussiness_value"]) && $condition["bussiness_value"] != ""){
            $select->where("bussiness_value = ?",$condition["bussiness_value"]);
        }
        if(isset($condition["bussiness_value_name"]) && $condition["bussiness_value_name"] != ""){
            $select->where("bussiness_value_name = ?",$condition["bussiness_value_name"]);
        }
        if(isset($condition["bussiness_value_en"]) && $condition["bussiness_value_en"] != ""){
            $select->where("bussiness_value_en = ?",$condition["bussiness_value_en"]);
        }
        if(isset($condition["bussiness_is_display"]) && $condition["bussiness_is_display"] !== ""){
            $select->where("bussiness_is_display in (?)",$condition["bussiness_is_display"]);
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