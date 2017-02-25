<?php
class Common_Fields
{
    /**
     * @param array $params
     * @param int $type
     * @return array
     */
    public static function getMatchFields($params = array(), $type = 0)
    {
        $row = self::getFields();
        $fieldsArr = array();
        foreach ($row as $key => $val) {
            if (isset($params[$key]) && $params[$key] != $val) {
                $fieldsArr[$val] = trim($params[$key]);
            } else {
                $fieldsArr[$val] = '';
                if ($type == '1') {
                    unset($fieldsArr[$val]);
                }
            }
        }
        return $fieldsArr;
    }

    /**
     * @param array $params
     * @param int $type
     * @return array
     */
    public static function getVirtualFields($params = array(), $type = 0)
    {
        $fieldsArr = self::getFields();
        $convertFieldsArr = array();
        foreach ($fieldsArr as $key => $val) {
            if (isset($params[$val])) {
                $convertFieldsArr[$key] = $params[$val];
            }
        }
        return $convertFieldsArr;
    }

    /**
     * @param array $params
     * @param int $type
     * @return array
     */
    public static function getFieldsAlias($params = array(), $type = 0)
    {
        $fieldsArr = self::getFields();
        //print_r($fieldsArr);
        $convertFieldsArr = $row = array();
        $params = array_combine($params, $params);
        foreach ($fieldsArr as $key => $val) {
            $convertFieldsArr[$val] = $key;
            if (isset($params[$val])) {
                $row[] = $val . ' as ' . $key;
            }
        }
        if ($type) {
            return $convertFieldsArr;
        }
        return $row;
    }

    public static function getYourFieldsAlias( $fields, $alias = 'C' ) {
        if( $alias === '' )
            $alias = 'C'
            ;
        $l = count( $fields );
        if( $l == 0 )
            return array();

        $tmp = array();
        for( $i = 0; $i < $l; ++$i ) {
            $tmp[ $alias.$i ] = $fields[ $i ];
        }
        return $tmp;
    }
}