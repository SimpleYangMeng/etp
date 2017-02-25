<?php
/**
 * Created by PhpStorm.
 * User: william
 * Date: 2016-11-01
 * Time: 15:57
 */
class Common_EtpCommon {
    static $defaultErrorCode = '60006';//etp调用之前的验证暂时都固定为60006
    /**
     * @author william-fan
     * @todo 用于将bussiness_status转成普通的键值对形式
     */
    public static function customerStatus($business,$lang = 'zh_CN')
    {
        if ($lang == 'auto') {
            $lang = Ec::getLang();
        }
        $cn = $en =array();
        foreach($business as $k=>$v){
            $cn[$k] = $v['bussiness_value_name'];
            $en[$k] = $v['bussiness_value_en'];
        }
        $tmp = array(
            'zh_CN' => $cn,
            'en_US' => $en
        );
        return isset($tmp[$lang]) ? $tmp[$lang] : $tmp;
    }
    /**
     * @author william-fan
     * @todo 用于将etp的php验证转成和etp后台一致
     */
    public static function transErrors($errors){
        if(!empty($errors)){
            $transErrors = array();
            foreach($errors as $k=>$v){
                $error = array(
                    'errorCode'=>self::$defaultErrorCode,
                    'errorMsg'=>$v
                );
                $transErrors[] = $error;
            }
            return $transErrors;
        }
        return $errors;
    }
}