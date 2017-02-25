<?php
class Table_ApiMessage
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_ApiMessage();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_ApiMessage();
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
    public function update($row, $value, $field = "am_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "am_id")
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
    public function getByField($value, $field = 'am_id', $colums = "*")
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
        
        if(isset($condition["api_type"]) && $condition["api_type"] != ""){
            $select->where("api_type = ?",$condition["api_type"]);
        }
        if(isset($condition["api_name"]) && $condition["api_name"] != ""){
            $select->where("api_name = ?",$condition["api_name"]);
        }
        if(isset($condition["api_url"]) && $condition["api_url"] != ""){
            $select->where("api_url = ?",$condition["api_url"]);
        }
        if(isset($condition["refer_code"]) && $condition["refer_code"] != ""){
        	$select->where("refer_code = ?",$condition["refer_code"]);
        }
        if(isset($condition["module"]) && $condition["module"] != ""){
        	$select->where("module = ?",$condition["module"]);
        }
        if(isset($condition["sub_module"]) && $condition["sub_module"] != ""){
        	$select->where("sub_module = ?",$condition["sub_module"]);
        }
        if(isset($condition["add_date_start"]) && $condition["add_date_start"] != ""){
            $select->where("add_date >= ?",$condition["add_date"]);
        }
        if(isset($condition["add_date_end"]) && $condition["add_date_end"] != ""){
            $select->where("add_date <= ?",$condition["add_date_end"]);
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