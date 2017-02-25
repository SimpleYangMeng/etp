<?php
/* @desc；交易控制器(提现之类的)
 * @date:2016-10-27
 */
class Portal_CommonController extends Ec_Controller_Action
{


    public function preDispatch()
    {
        $this->tplDirectory = "portal/views/transaction/";
    }
    /* @todo:获取城市
     *
     */
    public function getCityAction() {
        $province = trim( $this->_request->getParam( 'province', '' ) );
        $city = array();
        if( $province !== '' ) {
            $cityRow = Service_PaJzbCity::getByCondition( array( 'city_nodecode' => $province, 'city_areatype'=>2 ) );
            foreach( $cityRow as $value) {
                $city[] = array( 'code'=> $value['city_areacode'], 'name' => $value['city_areaname'] );
            }
        }
        die( json_encode( $city ) );
    }
    /* @todo:获取区县
     *
     */
    public function getDistrictAction() {
        $city = trim( $this->_request->getParam( 'city', '' ) );
        $district = array();
        if( $city !== '' ) {
            $cityRow = Service_PaJzbCity::getByCondition( array( 'city_topareacode2' => $city, 'city_areatype'=>3 ) );
            foreach( $cityRow as $value) {
                $district[] = array( 'code'=> $value['city_areacode'], 'name' => $value['city_areaname'] );
            }
        }
        die( json_encode( $district ) );
    }
    /* @todo:同时获取城市和区县
     *
     */
    public function getAreaAction() {
        $province = trim( $this->_request->getParam('province', '' ) );
        $city = trim( $this->_request->getParam('province', '' ) );
        $return = array( 'city'=>array(),'district'=>array());
        if( $province === '' )
            die( json_encode( $return ));
        //如果省和城市同时传过来
        if( $city === '' ){
            $return ['city'] = Service_PaJzbCity::getByCondition(
                array( 'city_nodecode' => $province,'city_areatype'=> 2 ),
                array('city_areacode'=>'code','city_areaname'=>'anme')
            );
            if( !empty( $return ['city'] ) ) {
                $city = $return ['city'][0]['code'];
            }
        }
        if( $city === '') {
            die(json_encode( $return ) );
        }
        $return ['district'] = Service_PaJzbCity::getByCondition(
            array( 'city_nodecode' => $province,'city_areatype'=> 3 ),
            array('city_areacode'=>'code','city_areaname'=>'anme')
        );
        die(json_encode( $return ) );
    }

    public function getBankAction() {
        $province       = trim( $this->_request->getParam( 'province', '' ) );
        $city           = trim( $this->_request->getParam( 'city', '' ) );
        $district       = trim( $this->_request->getParam( 'district', '' ) );
        $keyword           = trim( $this->_request->getParam( 'keyword', '' ) );
        $condition = array();
        if( $city ) {
            $condition['citycode'] = $city;
        } else if( $province ) {
            //将省份转成城市
           $cityRows =  Service_PaJzbCity::getByCondition( array( 'city_nodecode'=>$province, 'city_areatype'=>2 ), 'city_areacode' );
            $condition['citycode'] = array();
           foreach( $cityRows as $value ) {
                $condition['citycode'][] = $value['city_areacode'];
           }
        }
        if( $district !== '' )
            $condition['bankname_like_1'] = $district;

        if( $keyword !== '' )
            $condition['bankname_like_2'] = $keyword;

        $bank = Service_PaJzbBankInfo::getByCondition( $condition, array( 'No'=>'bankno', 'Name'=>'bankname' ) );
        die( json_encode( $bank ) );
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