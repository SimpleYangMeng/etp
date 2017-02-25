<?php
/* @desc；资源控制器(提现之类的)
 * @date:2016-10-27
 */
class Portal_ResourceController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        //$this->tplDirectory = "portal/views/transaction/";
    }

    /* @desc：从正式文件夹里获取图片
     *
     */
    public function getImageAction() {
        $attachId = trim( $this->_request->getParam( 'aid', '' ) );
        if( $attachId ) {
            if( $attachId == 'no-image' ) {
                $filePath = dirname( APPLICATION_PATH ) . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, array('public','images','noimg.jpg'));
                header('Content-Type: image/jpg');
                echo file_get_contents( $filePath );
                exit;
            }
            $condition = array(
                'customer_attach_id'        => $attachId,
                'customer_id'                => $this->_customerAuth['account_id'],
                'type'                        => $this->_customerAuth['account_type'],
            );
            $image = Service_CustomerAttach::getByCondition( $condition );
            if( $image ) {
                $filePath = dirname( APPLICATION_PATH ). DIRECTORY_SEPARATOR . $image[0]['attach_path'];
                if ( file_exists( $filePath ) ) {
                    header('Content-Type: image/*');
                    echo file_get_contents( $filePath );
                    exit;
                }
            }
        }
        header("HTTP/1.1 404 Not Found");
        exit;
    }

    /* @desc:从临时文件夹里获取图片
     *
     */
    public function getUploadImageAction() {
        $fileName = trim( $this->_request->getParam( 'fileName', '' ) );
        if( $fileName === '' ) {
            header("HTTP/1.1 404 Not Found");
            exit;
        }
        $accountCode = strtoupper( $this->_customerAuth['account_code'] );
        //解释文件名，看看是否属于当前登录的用户，防止他访问到别人的上传的证件
        $fileInfo = explode( '_', $fileName );
        if( $fileInfo[0] !== $accountCode ) {
            header("HTTP/1.1 404 Not Found");
            exit;
        }
        $tmpPath = dirname( APPLICATION_PATH ) . DIRECTORY_SEPARATOR . implode( DIRECTORY_SEPARATOR, array('data','images','temp') );
        $targetFile = $tmpPath . DIRECTORY_SEPARATOR . $fileName;
        if ( file_exists( $targetFile ) ) {
            header('Content-Type: image/*');
            echo file_get_contents( $targetFile );
            exit;
        }
        header("HTTP/1.1 404 Not Found");
        exit;
    }

    /* @desc：上传文件
     *
     */
    public function uploadImageAction() {
        $return = array(
            "state" => 0,
            "message" => Ec_Lang::getInstance()->getTranslate('uploadFailed')
        );
        $accountCode = strtoupper( $this->_customerAuth['account_code'] );
        $tmpPath = Service_Resource::getInstance()->getUploadImageSavePath();

        if (!empty($_FILES) ) {

            $fileInfo           = pathinfo($_FILES['file']['name']);

            $defaultExtension = array( 'jpg', 'jpeg', 'gif', 'png', 'bmp');
            if( !isset( $fileInfo['extension'] ) || !in_array( strtolower( $fileInfo['extension'] ), $defaultExtension ) ) {
                $return['message']    = Ec_Lang::getInstance()->getTranslate('licenseFormatWrong');
                die( Zend_Json::encode( $return ) );
            }

            $tempFile           = $_FILES['file']['tmp_name'];

            $tempFileName       = $accountCode . '_' . time() . '_' . uniqid() . "." . $fileInfo['extension'];

            if( !file_exists( $tmpPath ) ) {
                mkdir( $tmpPath, 0766, true);
            }
            $targetFile = $tmpPath . DIRECTORY_SEPARATOR . $tempFileName;
            if( move_uploaded_file( $tempFile, $targetFile ) ){
                $return['state']      = 1;
                $return['message']    = Ec_Lang::getInstance()->getTranslate('uploadSuccess');
                $return['fileName']   = $tempFileName;
            }
        }
        die( Zend_Json::encode( $return ) );
    }
    /* PurchaserController.php 买家相关控制器
     * SupplierController.php 卖家相关控制器
     * RecordController.php    订单，提现记录，订单明细，充值记录等相关列表
     * ResourceController.php   资源控制器，比如访问图片，下载文件
     * CommonController.php     一些通用的东西  比如获取城市
     * AccountController.php    账号的相关处理器，银行账号 用户账号  用户资料相关操作等等
     * TransactionController.php  交易相关的操作 充值 提现 等事务操作
     *
     *   上面都有说明 请尽量按说明放，把action 放到对应的控制器，别分的这一块那一块。
     */
}