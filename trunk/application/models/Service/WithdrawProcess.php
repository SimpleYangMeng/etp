<?php
/* @desc:提现处理
 * @date:2016-10-29
 *
 */
class Service_WithdrawProcess {

    protected $_date;//日期
    protected $_error = array();

    public function __construct() {
        $this->_date = date('Y-m-d H:i:s');
    }

    /* @desc:设置错误
     * @date:2016-10-29
     * @param mixed $error 错误
     * @return none
     */
    public function setError( $error ) {
        if( is_array( $error ) ) {
            $this->_error[] = array_merge( $this->_error, $error );
        } else if( is_scalar( $error ) ) {
            $this->_error[] = $error;
        }
    }

    /* @desc:获取错误
     * @date:2016-10-29
     * @return array
     */
    public function getError() {
        return $this->_error;
    }

    /* @desc:处理提现申请
     * @date:2016-10-29
     * @param array $param 提现参数
     * @return array
     */
    public function dealWithdraw( $param ) {

    }

    /* @desc:检查提现参数
     * @date:2016-10-29
     * @param array $param 提现参数
     * @return array
     */
    protected function checkWithdrawParam( $param ) {

        if( isset( $param['bankName'] ) || $param['bankName'] === '' ) {

        }
        if( isset( $param['bankAccountName'] ) || $param['bankAccountName'] === '' ) {

        }
        if( isset( $param['bankAccount'] ) || $param['bankAccount'] === '' ) {

        }
        if( isset( $param['amount'] ) || $param['amount'] === '' ) {

        }
    }
}