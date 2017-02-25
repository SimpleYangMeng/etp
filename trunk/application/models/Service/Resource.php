<?php
/* @desc:资源处理逻辑
 *
 */
class Service_Resource {

    protected static $class = null;

    public static function getInstance() {
        if (!isset(self::$class)) {
            $c = __CLASS__;
            self::$class = new $c;
        }
        return self::$class;
    }
    /* @desc 获取图片上传后的临时保存路径
     *
     */
    public function getUploadImageSavePath() {
        $tmpPath = dirname( APPLICATION_PATH ) . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, array('data','images','temp') );
        return $tmpPath;
    }

}