<?php
class GetNumber
{
    private static $radixString     = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    private static $applicationCode = "";
    private static $radix10Code     = array('warehouseCode');

    /**
     * [getCode description]
     * @return [type] [description]
     */
    public static function getCode($applicationCode, $length = 6, $prefix = '', $applicationName = '')
    {
        $applicationRows = Service_Application::getByCondition(array(
            'application_code' => $applicationCode,
            'customer_code'    => $prefix,
        ));
        // 操作代码
        self::$applicationCode = $applicationCode;

        $time = date('Y-m-d H:i:s');

        if (!isset($applicationRows[0]) && !isset($applicationRows[0]['current_number']) || intval($applicationRows[0]['current_number']) < 0) {
            $number = 1;
            $result = Service_Application::add(array(
                'current_number'   => $number,
                'app_add_time'     => $time,
                'customer_code'    => $prefix,
                'application_code' => $applicationCode,
                'application_name' => $applicationName,
            ));
        } else {
            $application = Service_Application::getByFieldLock($applicationRows[0]['application_id'], 'application_id');
            $oldNumber   = intval($application['current_number']);
            $number      = $oldNumber + 1;
            $result      = Service_Application::update(array(
                'application_code' => $applicationCode,
                'current_number'   => $number,
                'customer_code'    => $prefix,
                'app_update_time'  => $time,
            ), $application['application_id']);
        }

        return $prefix . self::getSequence($length, $number);
    }

    /**
     * 生成length的唯一码
     * @return [type] [description]
     */
    private static function getSequence($length, $number)
    {
        // if (!in_array(self::$applicationCode, self::$radix10Code)) {
        //     $number = self::radix36($number);
        // }
        return sprintf("%0{$length}s", self::getNumberForString($number));
    }

    /**
     * 唯一数
     * @return [type] [description]
     */
    private static function getNumberForString($number)
    {
        if (is_numeric($number)) {
            return number_format($number, 0, '', '');
        } else {
            return $number;
        }
    }

    /**
     * 10进制转36进制  有个问题是intval和float
     * @author  <luffyzhao@vip.126.com>
     * @param  integer $number [description]
     * @return [type]          [description]
     */
    private static function radix36($number = 0)
    {
        $radixString = self::$radixString;
        $radixLenght = floatval(strlen($radixString));
        $number      = floatval($number);
        $result      = '';
        while ($number >= $radixLenght) {
            // 这里求余不能用 % 不然会出现负数的形式
            $index  = (int) fmod($number, $radixLenght);
            $result = $radixString[$index] . $result;
            $number = floor($number / $radixLenght);
        }
        if ($number >= 0) {
            $index  = intval($number);
            $result = $radixString[$index] . $result;
        }

        return $result;
    }

}

class Common_GetNumbers
{
    public static function getCode($applicationCode, $length = 6, $prefix = '', $applicationName = '')
    {
        $string = GetNumber::getCode($applicationCode, $length, $prefix, $applicationName);
        return $string;
    }
}
