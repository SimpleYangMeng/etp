<?php
class Ec_Lang
{

    private $_myTranslate;
    private $_customTranslate;
    public $_defaultLang = 'zh_CN';
    private static $_class = null;
    private $_curLang = null;
    public $_languages = array(
        'zh_CN' => 'zh_CN',
        'en_US' => 'en_US',
    );

    private function __construct()
    {
        $this->getCurrentLanguage();
        $this->loadLanguage();
    }

    public static function getInstance()
    {
        if (!isset(self::$_class)) {
            $c = __CLASS__;
            self::$_class = new $c;
        }
        return self::$_class;

    }

    public function getAllLanguages() {
        return array_values( $this->_languages );
    }

    public function getTranslate($str, $lang = null)
    {
        $translation = $str;
        if ($str != "" && null != $lang && $lang != $this->_curLang && isset($this->_languages[$lang])) {
            if ($this->_customTranslate != null) {
                $translation = $this->_customTranslate->translate($str);
            } else {
                try {
                    $this->_customTranslate = new Zend_Translate('array', APPLICATION_PATH . "/languages/" . $lang . '.php');
                    $translation = $this->_customTranslate->translate($str);
                } catch (Exception $e) {
                }
            }
        } elseif ($str != "") {
            if ($this->_myTranslate != null) {
                $translation = $this->_myTranslate->translate($str);
            }
        }

        return $translation;
    }

    public function translate($str, $lang = null)
    {
        return $this->getTranslate($str, $lang);
    }

    private function loadLanguage()
    {
        $noAppMoFile = false;
        try {
            if (Zend_Registry::isRegistered('Zend_Translate')) {
                $this->_myTranslate = Zend_Registry::get('Zend_Translate');
            } else {
                $this->_myTranslate = new Zend_Translate('array', APPLICATION_PATH . "/languages/" . $this->_curLang . '.php');
                Zend_Registry::set('Zend_Translate', $this->_myTranslate);
            }
        } catch (Exception $e) {
            $noAppMoFile = $e;
        }
        return $noAppMoFile;
    }


    public function getCurrentLanguage()
    {
        /*$user = new Zend_Session_Namespace('userAuthorization');
        if ($this->_curLang != null && $this->_curLang == $user->lang)
            return $this->_curLang;

        $currentLanguage = "";

        if (isset($user->lang)) {
            $currentLanguage = $user->lang;
        } else if (isset($_COOKIE['LANGUAGE'])) {
            $currentLanguage = $_COOKIE['LANGUAGE'];
        }

        if (!isset($this->_languages[$currentLanguage])) {
            $currentLanguage = $this->_defaultLang;
        }
        $this->_curLang = $currentLanguage;
        return $currentLanguage;*/

        $sessionLang = new Zend_Session_Namespace('language');
        if ($this->_curLang != null && $this->_curLang == $sessionLang->language )
            return $this->_curLang;

        $currentLanguage = "";

        if ( isset( $sessionLang->language ) ) {
            $currentLanguage = $sessionLang->language;
        } else if (isset($_COOKIE['language'])) {
            $currentLanguage = $_COOKIE['language'];
        } else {
            $this->setLanguage( $this->_defaultLang );
        }

        if ( !isset( $this->_languages[ $currentLanguage ] ) ) {
            $currentLanguage = $this->_defaultLang;
        }

        $this->_curLang = $currentLanguage;
        return $currentLanguage;
    }

    public function getAnotherLanguage() {
        $language = $this->getCurrentLanguage();
        if( $language == 'zh_CN')
            return 'en_US';
        else
            return 'zh_CN';
    }

    /* @desc：设置会话语言
     *
     */
    public function setLanguage( $language = 'zh_CN') {
        if( !in_array( $language, $this->_languages ) )
            $language = 'zh_CN';

        $sessionLang = new Zend_Session_Namespace('language');
        $sessionLang->language = $language;
        $_COOKIE['language'] = $language;

        $this->loadLanguage();
    }

    public function hasSetLanguage() {
        $sessionLang = new Zend_Session_Namespace('language');
        return isset( $sessionLang->language ) && $sessionLang->language != '' ? true : false;
    }

}