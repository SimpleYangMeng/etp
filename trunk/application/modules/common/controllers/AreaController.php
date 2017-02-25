<?php
/* @desc；获取地址相关信息
 * @date:2016-10-27
 */
class Common_AreaController extends Ec_Controller_Action
{


    public function preDispatch()
    {

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
}