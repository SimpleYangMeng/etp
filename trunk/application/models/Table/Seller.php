<?php
class Table_Seller
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Seller();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Buyer();
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
    public function update($row, $value, $field = "seller_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "seller_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->delete($where);
    }
    
    public function getLockInShareMode($seller_id) {
      $sql = 'SELECT * FROM customer WHERE seller_id='.$seller_id.' LOCK IN SHARE MODE;';
      return $this->_table->getAdapter()->fetchRow($sql);
    }

    public function getCustomerByShortCode($customer_short){
        $sql = "SELECT * FROM customer WHERE customer_short='".$customer_short."' order by seller_id asc LOCK IN SHARE MODE;";
        return $this->_table->getAdapter()->fetchRow($sql);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public function getByField($value, $field = 'seller_id', $colums = "*")
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
     * 构造自定义SQL语句查询
     *
     * @access  public
     * @param   string  ($field   待返回的字段，默认为所有)
     * @param   string  ($condition 查询条件)
     * @param mixed ($value   待转换查询字段值)
     * @return  mixed
     */
    public function getCustomQuery($field = '*', $condition = '', $value = '')
    {
      $table  = $this->_table->info('name');
      $sql  = "SELECT $field FROM $table $condition";
      $sql  = $this->_table->getAdapter()->quoteInto($sql, $value);
      return $this->_table->getAdapter()->fetchAll($sql);
    }
    
    /**
     * [getByWhere 多条件获取]
     * @param  [type] $where  [description]
     * @param  string $colums [description]
     * @return [type]         [description]
     */
    public function getByWhere($where, $colums = '*') {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $colums);
        foreach($where as $field=>$value) {
            $select->where("{$field} = ?", $value);
        }
        return $this->_table->getAdapter()->fetchRow($select);
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
        
        if(isset($condition["seller_code"]) && $condition["seller_code"] != ""){
            $select->where("seller_code = ?",$condition["seller_code"]);
        }
        if(isset($condition["seller_name"]) && $condition["seller_name"] != ""){
            $select->where("seller_name = ?",$condition["seller_name"]);
        }
        if(isset($condition["password"]) && $condition["password"] != ""){
            $select->where("password = ?",$condition["password"]);
        }
        if(isset($condition["email"]) && $condition["email"] != ""){
            $select->where("email = ?",$condition["email"]);
        }
        if(isset($condition["status"]) && $condition["status"] != ""){
            $select->where("status = ?",$condition["status"]);
        }
        if(isset($condition["activate_code"]) && $condition["activate_code"] != ""){
            $select->where("activate_code = ?",$condition["activate_code"]);
        }
        if(isset($condition["currency"]) && $condition["currency"] != ""){
            $select->where("currency = ?",$condition["currency"]);
        }
        if(isset($condition["verify_code"]) && $condition["verify_code"] != ""){
            $select->where("verify_code = ?",$condition["verify_code"]);
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