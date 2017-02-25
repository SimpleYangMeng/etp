<?php
class Service_User
{
    /**
     * @var null
     */
    public static $_modelClass = null;

    /**
     * @return Table_User|null
     */
    public static function getModelInstance()
    {
        if (is_null(self::$_modelClass)) {
            self::$_modelClass = new Table_User();
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
    public static function update($row, $value, $field = "user_id")
    {
        $model = self::getModelInstance();
        return $model->update($row, $value, $field);
    }

    /**
     * @param $value
     * @param string $field
     * @return mixed
     */
    public static function delete($value, $field = "user_id")
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
    public static function getByField($value, $field = 'user_id', $colums = "*")
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

        $validateArr[] = array("name" => EC::Lang('userCode'), "value" => $val["user_code"], "regex" => array("require",));
        $validateArr[] = array("name" => EC::Lang('userName'), "value" => $val["user_name"], "regex" => array("require",));
        $validateArr[] = array("name" => EC::Lang('userNameEn'), "value" => $val["user_name_en"], "regex" => array("require",));
        $validateArr[] = array("name" => EC::Lang('departmentName'), "value" => $val["ud_id"], "regex" => array("require",));
        $validateArr[] = array("name" => EC::Lang('positionName'), "value" => $val["up_id"], "regex" => array("require",));
        return Common_Validator::formValidator($validateArr);
    }


    /**
     * @param array $params
     * @return array
     */
    public function getFields()
    {
        $row = array(

            'E0' => 'user_id',
            'E1' => 'user_code',
            'E2' => 'user_password',
            'E3' => 'user_name',
            'E4' => 'user_name_en',
            'E5' => 'user_status',
            'E6' => 'user_email',
            'E7' => 'ud_id',
            'E8' => 'up_id',
            'E9' => 'user_password_update_time',
            'E10' => 'user_phone',
            'E11' => 'user_mobile_phone',
            'E12' => 'user_note',
            'E13' => 'user_supervisor_id',
            'E14' => 'user_add_time',
            'E15' => 'user_last_login',
            'E16' => 'user_update_time',
        );
        return $row;
    }

    /**
     * @后台登录
     * @param array $params
     * @return array
     */
    public static function login($params = array())
    {
        $result = array('state' => 0, 'message' => '');
        $userName = isset($params['userName']) ? $params['userName'] : '';
        $userPass = isset($params['userPass']) ? $params['userPass'] : '';
        $authCode = isset($params['authCode']) ? $params['authCode'] : '';
        $valid = isset($params['valid']) ? $params['valid'] : '0'; //是否需要要判断验证码
        if ($valid == '1') {
            $verifyCodeObj = new Common_Verifycode();
            $verifyCodeObj->set_sess_name('AdminVerifyCode'); //重置验证码
            if (empty($authCode) || !$verifyCodeObj->is_true($authCode)) {
                $result['message'] = Ec::Lang('verifyCodeMessage');
                return $result;
            }
        }

        if (empty($userName) || empty($userPass) || strlen($userName) > 64) {
            $result['message'] = Ec::Lang('loginMessage');
            return $result;
        }

        $model = self::getModelInstance();
        $userArr = $model->getByField($userName, 'user_code');
        if (empty($userArr)) {
            $result['message'] = Ec::Lang('loginMessage');
            return $result;
        }
        if (!Ec_Password::comparePassword($userPass, $userArr['user_password'])) {
            $result['message'] = Ec::Lang('loginMessage');
            return $result;
        }
        $session = new Zend_Session_Namespace('userAuthorization');
        $session->unsetAll();
        $date = date('Y-m-d');
        $userLastDate = $userArr['user_password_update_time'];
        $days = round((strtotime($date) - strtotime($userLastDate)) / 3600 / 24);

        if ($userArr['user_status'] != '1') {
            $result['message'] = Ec::Lang('userActivate');
            Service_UserLoginLog::add(array('user_id' => $userArr['user_id'], 'ull_status' => '0', 'ull_note' => 'Account is not activated'));
            return $result;
        } else {
            unset($userArr['user_password']);
            unset($userArr['user_note']);
            $session->userAuth = $userArr;
            $session->userId = $userArr['user_id'];
            $session->userCode = $userArr['user_code'];
            $session->isLogin = true;
            $session->message = '';
            $model->update(array('user_last_login' => date('Y-m-d H:i:s')), $userArr['user_id']);
            Service_UserLoginLog::add(array('user_id' => $userArr['user_id']));
            if (($days >= 60)) {
                $session->message = Ec::Lang('updateLastPass');
            }
            $result = array('state' => 1, 'message' => 'Success');
        }
        return $result;
    }

}