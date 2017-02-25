<?php
class Table_Warehouse
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Warehouse();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Warehouse();
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
    public function update($row, $value, $field = "warehouse_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "warehouse_id")
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
    public function getByField($value, $field = 'warehouse_id', $colums = "*")
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
        
        if(isset($condition["warehouse_code"]) && $condition["warehouse_code"] != ""){
            $select->where("warehouse_code = ?",$condition["warehouse_code"]);
        }
        if(isset($condition["warehouse_status"]) && $condition["warehouse_status"] != ""){
            $select->where("warehouse_status = ?",$condition["warehouse_status"]);
        }
        if(isset($condition["warehouse_scope"]) && $condition["warehouse_scope"] != ""){
        	$select->where("warehouse_scope = ?",$condition["warehouse_scope"]);
        }
        if(isset($condition["country_id"]) && $condition["country_id"] != ""){
            $select->where("country_id = ?",$condition["country_id"]);
        }
        if(isset($condition["state"]) && $condition["state"] != ""){
            $select->where("state = ?",$condition["state"]);
        }
        if(isset($condition["city"]) && $condition["city"] != ""){
            $select->where("city = ?",$condition["city"]);
        }
        if(isset($condition["contacter"]) && $condition["contacter"] != ""){
            $select->where("contacter = ?",$condition["contacter"]);
        }
        if(isset($condition["phone_no"]) && $condition["phone_no"] != ""){
            $select->where("phone_no = ?",$condition["phone_no"]);
        }
        if(isset($condition["street_address1"]) && $condition["street_address1"] != ""){
            $select->where("street_address1 = ?",$condition["street_address1"]);
        }
        if(isset($condition["street_address2"]) && $condition["street_address2"] != ""){
            $select->where("street_address2 = ?",$condition["street_address2"]);
        }
        if(isset($condition["warehouse_desc"]) && $condition["warehouse_desc"] != ""){
            $select->where("warehouse_desc = ?",$condition["warehouse_desc"]);
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