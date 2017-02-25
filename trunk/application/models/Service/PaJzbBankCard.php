<?php
class Service_PaJzbBankCard extends Common_Service
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_PaJzbBankCard|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_PaJzbBankCard();
        }
        return self::$_modelClass;
    }

    /**
     * @param $row
     * @return mixed
     */
    public static function add($row)
    {
        $model = self::getModelInstance();
        return $model->add($row);
    }


    /**
     * @param $row
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function update($row, $value, $field = "bank_card_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "bank_card_id")
    {
        $model = self::getModelInstance();
        return $model->delete($value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @param string $colums
     * @return mixed
     */
    public static function getByField($value, $field = 'bank_card_id', $colums = "*")
    {
        $model = self::getModelInstance();
        return $model->getByField($value, $field, $colums);
    }

    /**
     * @return mixed
     */
    public static function getAll()
    {
        $model = self::getModelInstance();
        return $model->getAll();
    }

    /**
     * @param array $condition
     * @param string $type
     * @param int $pageSize
     * @param int $page
     * @param string $order
     * @return mixed
     */
    public static function getByCondition($condition = array(), $type = '*', $pageSize = 0, $page = 1, $order = "")
    {
        $model = self::getModelInstance();
        return $model->getByCondition($condition, $type, $pageSize, $page, $order);
    }

    /**
     * @param $val
     * @return array
     */
    public static function validator($val)
    {
        $validateArr = $error = array();
        if( isset( $val["bank_card_user_name"] ) ) {
            $validateArr[] = array("name" =>EC::Lang('bank_card_user_name'), "value" =>$val["bank_card_user_name"], "regex" => array("require",));
        }
        if( isset( $val["id_card_type"] ) ) {
            $validateArr[] = array("name" =>EC::Lang('id_card_type'), "value" =>$val["id_card_type"], "regex" => array("require",'isValidIdType'));
        }
        if( isset( $val["id_card_No"] ) ) {
            $validateArr[] = array("name" =>EC::Lang('id_card_No'), "value" =>$val["id_card_No"], "regex" => array("require",));
        }
        if( isset( $val["bank_card_no"] ) ) {
            $validateArr[] = array("name" =>EC::Lang('bank_card_no'), "value" =>$val["bank_card_no"], "regex" => array("require",));
        }
        if( isset( $val['bank_type'] ) && $val['bank_type'] == 2 ) {
            if( isset( $val['bank_attr'] ) &&  $val['bank_attr'] == 1) {
                $validateArr[] = array("name" =>EC::Lang('bank_code'), "value" =>$val["bank_code"], "regex" => array("require",));
            } else if( isset( $val['bank_attr'] ) &&  $val['bank_attr'] == 2 ) {
                $validateArr[] = array("name" =>EC::Lang('super_bank_code'), "value" =>$val["super_bank_code"], "regex" => array("require",));
            }
        }
        if( isset( $val["phone_no"] ) ) {
            $validateArr[] = array("name" =>EC::Lang('phone_no'), "value" =>$val["phone_no"], "regex" => array("require","cnMobilePhone"));
        }

        return  Common_Validator::formValidator($validateArr);
    }


    /**
     * @param array $params
     * @return array
     */
    public  function getFields()
    {
        $row = array(
            'E0' => 'bank_card_id',
            'E1' => 'account_no',
            'E2' => 'bank_card_user_name',
            'E3' => 'id_card_type',
            'E4' => 'id_card_No',
            'E5' => 'bank_card_no',
            'E6' => 'bank_type',
            'E7' => 'bank_name',
            'E8' => 'bank_code',
            'E9' => 'super_bank_code',
            'E10' => 'phone_no',
            'E11' => 'note',
            'E12' => 'status',
            'E13' => 'ccy_code',
            'E14' => 'seq_no',
            'E15' => 'add_time',
            'E16' => 'update_time',
        );
        return $row;
    }

}