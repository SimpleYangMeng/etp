<?php
class Table_Customer
{
    protected $_table = null;

    public function __construct()
    {
        $this->_table = new DbTable_Customer();
    }

    public function getAdapter()
    {
        return $this->_table->getAdapter();
    }

    public static function getInstance()
    {
        return new Table_Customer();
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
    public function update($row, $value, $field = "customer_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->update($row, $where);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public function delete($value, $field = "customer_id")
    {
        $where = $this->_table->getAdapter()->quoteInto("{$field}= ?", $value);
        return $this->_table->delete($where);
    }


    public function getLockInShareMode($customer_id) {
        $sql = 'SELECT * FROM customer WHERE customer_id='.$customer_id.' LOCK IN SHARE MODE;';
        return $this->_table->getAdapter()->fetchRow($sql);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public function getByField($value, $field = 'customer_id', $colums = "*")
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
        
        if(isset($condition["customer_code"]) && $condition["customer_code"] != ""){
            $select->where("customer_code = ?",$condition["customer_code"]);
        }
        if(isset($condition["customer_password"]) && $condition["customer_password"] != ""){
            $select->where("customer_password = ?",$condition["customer_password"]);
        }
        if(isset($condition["customer_firstname"]) && $condition["customer_firstname"] != ""){
            $select->where("customer_firstname = ?",$condition["customer_firstname"]);
        }
        if(isset($condition["customer_lastname"]) && $condition["customer_lastname"] != ""){
            $select->where("customer_lastname = ?",$condition["customer_lastname"]);
        }
        if(isset($condition["customer_email"]) && $condition["customer_email"] != ""){
            $select->where("customer_email = ?",$condition["customer_email"]);
        }
        if(isset($condition["customer_currency"]) && $condition["customer_currency"] != ""){
            $select->where("customer_currency = ?",$condition["customer_currency"]);
        }
        if(isset($condition["customer_telephone"]) && $condition["customer_telephone"] != ""){
            $select->where("customer_telephone = ?",$condition["customer_telephone"]);
        }
        if(isset($condition["customer_status"]) && $condition["customer_status"] != ""){
            $select->where("customer_status = ?",$condition["customer_status"]);
        }
        if(isset($condition["customer_saler_user_id"]) && $condition["customer_saler_user_id"] != ""){
            $select->where("customer_saler_user_id = ?",$condition["customer_saler_user_id"]);
        }
        if(isset($condition["customer_cser_user_id"]) && $condition["customer_cser_user_id"] != ""){
            $select->where("customer_cser_user_id = ?",$condition["customer_cser_user_id"]);
        }
        if(isset($condition["customer_verify_code"]) && $condition["customer_verify_code"] != ""){
            $select->where("customer_verify_code = ?",$condition["customer_verify_code"]);
        }
        if(isset($condition["customer_signature"]) && $condition["customer_signature"] != ""){
            $select->where("customer_signature = ?",$condition["customer_signature"]);
        }
        if(isset($condition["reg_step"]) && $condition["reg_step"] != ""){
            $select->where("reg_step = ?",$condition["reg_step"]);
        }
        if(isset($condition["password_update_time"]) && $condition["password_update_time"] != ""){
            $select->where("password_update_time = ?",$condition["password_update_time"]);
        }
        if(isset($condition["trade_co"]) && $condition["trade_co"] != ""){
        	$select->where("trade_co = ?",$condition["trade_co"]);
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


    public function getLeftJoinByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $orderBy = "")
    {
        $select = $this->_table->getAdapter()->select();
        $table = $this->_table->info('name');
        $select->from($table, $type);
        $select->joinLeft('user as user', 'user.user_id='.$table.'.customer_saler_user_id',array('user.user_name as saleName'));
        $select->joinLeft('user as u', 'u.user_id='.$table.'.customer_cser_user_id',array('u.user_name as serviceName'));
        $select->where("1 =?", 1);
        /*CONDITION_START*/

        if(isset($condition["customer_code"]) && $condition["customer_code"] != ""){
            $select->where("customer_code = ?",$condition["customer_code"]);
        }
        if(isset($condition["customer_firstname"]) && $condition["customer_firstname"] != ""){
            $select->where("customer_firstname = ?",$condition["customer_firstname"]);
        }
        if(isset($condition["customer_lastname"]) && $condition["customer_lastname"] != ""){
            $select->where("customer_lastname = ?",$condition["customer_lastname"]);
        }
        if(isset($condition["customer_email"]) && $condition["customer_email"] != ""){
            $select->where("customer_email like ?",'%'.$condition["customer_email"].'%');
        }
        if(isset($condition["customer_currency"]) && $condition["customer_currency"] != ""){
            $select->where("customer_currency = ?",$condition["customer_currency"]);
        }

        if(isset($condition["customer_telephone"]) && $condition["customer_telephone"] != ""){
            $select->where("customer_telephone = ?",$condition["customer_telephone"]);
        }

        if(isset($condition["customer_status"]) && $condition["customer_status"] != ""){
            $select->where("customer_status = ?",$condition["customer_status"]);
        }
        if(isset($condition["customer_company_name"]) && $condition["customer_company_name"] != ""){
            $select->where("customer_company_name = ?",$condition["customer_company_name"]);
        }
          if(isset($condition["company"]) && $condition["company"] != ""){
            $select->where("customer_company_name like ?",'%'.$condition["company"].'%');
        }
        if(isset($condition["customer_saler_user_id"]) && $condition["customer_saler_user_id"] != ""){
            $select->where("customer_saler_user_id = ?",$condition["customer_saler_user_id"]);
        }
        if(isset($condition["customer_cser_user_id"]) && $condition["customer_cser_user_id"] != ""){
            $select->where("customer_cser_user_id = ?",$condition["customer_cser_user_id"]);
        }
        if(isset($condition["customer_verify_code"]) && $condition["customer_verify_code"] != ""){
            $select->where("customer_verify_code = ?",$condition["customer_verify_code"]);
        }
        if(isset($condition["reg_step"]) && $condition["reg_step"] != ""){
            $select->where("reg_step = ?",$condition["reg_step"]);
        }
        if(isset($condition["dateFor"]) && $condition["dateFor"] != ""){
            $select->where("customer_reg_time >= ?",$condition["dateFor"]);
        }
        if(isset($condition["cash_type"]) && $condition["cash_type"] != ""){
            $select->where("cash_type = ?",$condition["cash_type"]);
        }
        if(isset($condition["dateTo"]) && $condition["dateTo"] != ""){
            $select->where("customer_reg_time <= ?",$condition["dateTo"]);
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