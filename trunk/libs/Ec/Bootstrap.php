<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

    /**
     * @var Zend_Log
     */
    protected $_logger;

    /**
     * @var Zend_Application_Module_Autoloader
     */
    protected $_resourceLoader;

    /**
     * @var Zend_Controller_Front
     */
    public $frontController;

    /**
     * ini config
     */
    protected function _initConfig()
    {
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/config.ini', $this->getEnvironment());

        Zend_Registry::set('config', $config);
    }

    protected function _initLogging()
    {
        $logger = new Zend_Log();

        $writer = new Zend_Log_Writer_Stream(APPLICATION_PATH . "/../data/log/Ec_Error.log");
        $logger->addWriter($writer);

        if ('production' == $this->getEnvironment()) {
            $filter = new Zend_Log_Filter_Priority(Zend_Log::DEBUG);
            $logger->addFilter($filter);
        }

        $this->_logger = $logger;
        Zend_Registry::set('log', $logger);
    }

    protected function _initDefaultController()
    {
        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $frontController->setParam('noViewRenderer', true);
    }

    /**
     * ini layout
     */
    public function _initLayout()
    {
        $layout = new Zend_Layout();
        $layout->setLayoutPath(APPLICATION_PATH . '/layouts');
        Zend_Registry::set('layout', $layout);
    }

    public function _initSmartyViews()
    {
        $config = Zend_Registry::get('config');
        $view = new Ec_View_Smarty($config->smartyConfig->template_dir, $config->smartyConfig->config);
        Zend_Registry::set('EcView', $view);
    }

    protected function _initAutoModules()
    {
        $modules = new Ec_Loader_AutoModules();
    }

    public function _initDb()
    {
        $ops = $this->getOptions();
        $request = new Zend_Controller_Request_Http();
        $host = $request->getHttpHost();
        $maindomain = $ops['maindomian']; // 自定义主域名
        Zend_Registry::set("maindomian", $maindomain);
        $resource = $this->getPluginResource('multidb');
        $resource->init();
        if (preg_match('/^www/', $host) || $host == $maindomain) {
            $db = $resource->getDb('common'); /* 主数据库 */
        } else {
            $db = $resource->getDb('sandbox'); /* 沙箱数据库 */
        }
        Zend_Registry::set("dbprefix", $ops['server']['dbprefix']);
        Zend_Db_Table_Abstract::setDefaultAdapter($db);
        Zend_Registry::set("db", $db);
        Zend_Registry::set('debug', $db->getProfiler()->getEnabled());

        Zend_Registry::set('sql_query', '');
        Zend_Registry::set('sql_select', '');
        Zend_Registry::set('selectCount', 0);
    }

}

/**
 * Ec Class static functions
 */
class Ec
{

    /**
     * getConfig
     */
    public static function getConfig($key)
    {
        return Zend_Registry::get('config')->get($key);
    }

    /**
     * rend smarty tpl
     * @param array $layoutIncludeTpl layout里引入TPL
     */
    public static function renderTpl($tpl, $layoutTemplate = null, $title = null, $scripts = null, $meta = null,$layoutIncludeTpl = array() )
    {
        $layout = Zend_Registry::get('layout');
        $module = Zend_Controller_Front::getInstance()->getRequest()->getModuleName();
        if (null != $layoutTemplate && '' != $layoutTemplate) {
            $layoutTemplate = $module . '/' . $layoutTemplate;
            $layout->setLayout($layoutTemplate);
        }

        $layout->setLayout($layoutTemplate);

        if (is_array($scripts)) {
            foreach ($scripts as $script) {
                $layout->getView()
                    ->headScript()
                    ->appendFile(self::getConfig('baseUrl') . $script);
            }
        }

        $title = null == $title ? self::getConfig('webTitle') : $title;
        $layout->getView()->headTitle($title);

        if ($meta) {
            if (isset($meta['keyword'])) {
                $layout->getView()
                    ->headMeta()
                    ->appendName('keywords', trim($meta['keyword']));
            }
            if (isset($meta['description'])) {
                $layout->getView()
                    ->headMeta()
                    ->appendName('description', trim($meta['description']));
            }
        }
        //设置页面可选的语言
        Zend_Registry::get('EcView')->languageList = Ec_Lang::getInstance()->getAnotherLanguage();
        Zend_Registry::get('EcView')->language = Ec_Lang::getInstance()->getCurrentLanguage();
        $layout->language = Ec_Lang::getInstance()->getCurrentLanguage();
        $layout->content = Zend_Registry::get('EcView')->render($tpl);
        //引入layout要用的tpl
        foreach( $layoutIncludeTpl as $key => $value ) {
            if( $value ) {
                $layout->$key = Zend_Registry::get('EcView')->render( $value );;
            }
        }

        return $layout->render();
    }

    public static function setupMail()
    {
        try {
            $mail = Zend_Registry::get('mail');
            if ($mail instanceof Zend_Mail)
                return $mail;
        } catch (Exception $e) {

            $config = Zend_Registry::get('config');
            $mailConfig = array(
                'auth' => $config->mails->config->auth,
                'username' => $config->mails->config->username,
                'password' => $config->mails->config->password,
                'port' => $config->mails->config->port,
            	'send'=>$config->mails->config->send,
// 			  'ssl' => $config->mails->config->ssl,
            );
            $transport = new Zend_Mail_Transport_Smtp($config->mails->server, $mailConfig);
            Zend_Mail::setDefaultTransport($transport);
            $mail = new Zend_Mail('utf-8');
            $mail->setFrom($config->mails->from, $config->mails->config->name);
            Zend_Registry::set('mail', $mail);
            return $mail;
        }
    }

    //输出所有sql查询
    public static function debug()
    {
        $isDebug = Zend_Registry::get('debug');
        if (!$isDebug) {
            return;
        }

        $dblog = "";
        $db = Zend_Registry::get('db');
        $profiler = $db->getProfiler();

        $totalTime = $profiler->getTotalElapsedSecs();
        $queryCount = $profiler->getTotalNumQueries();
        $longestTime = 0;
        $longestQuery = null;
        $allSelect = '';
        $selectCount = 0;
        if (false === $profiler->getQueryProfiles()) {
            return;
        }

        foreach ($profiler->getQueryProfiles() as $query) {

            $elapsed = $query->getElapsedSecs();

            $sql = strtr($query->getQuery(),
                array(
                    "\r\n" => ' ',
                    "\r" => ' ',
                    "\n" => ' ',
                    "\t" => ''
                ));
            $sql = trim($sql);
            $sql = $sql . ";";
            if (preg_match('/^SELECT/i', $sql)) {
                $allSelect .= "  " . $sql . "\n";
                $selectCount++;
            }

            if ($elapsed > $longestTime) {
                $longestTime = $elapsed;
                $longestQuery = $sql;
            }
            $dblog .= "$elapsed millisecond: -> \t " . $sql . "  \n";
        }

        $dblog .= 'Executed ' . $queryCount . ' queries in ' . $totalTime . ' seconds' . "\n";
        $dblog .= 'Average query length: ' . $totalTime / $queryCount . ' seconds' . "\n";
        $dblog .= 'Longest query length: ' . $longestTime . " seconds\n";
        $dblog .= "Longest query: " . $longestQuery . " \n";
        $dblog .= 'Queries per second: ' . $queryCount / $totalTime . "\n";
        $dblog .= "All Select:\n" . $allSelect . "";

        Zend_Registry::set('sql_query', $dblog);
        Zend_Registry::set('sql_select', $allSelect);
        Zend_Registry::set('selectCount', $selectCount);

        self::logError($dblog);
    }

    private static function logError($log)
    {
        $logger = new Zend_Log();
        $uploadDir = APPLICATION_PATH . "/../data/log/";
        $writer = new Zend_Log_Writer_Stream($uploadDir . 'Ec_query.log');
        $logger->addWriter($writer);
        $logger->info("\n" . date('Y-m-d H:i:s') . ":\n" . trim($log));
    }

    public static function cache($subDir = '', $directoryLevel = 0)
    {
        $config = Zend_Registry::get('config');
        $backend = $config->cacheBackend;

        if (empty($backend)) {
            $backend = 'File';
        }
        $frontendOptions = array(
            'caching' => $config->caching,
            'lifeTime' => $config->cacheLifeTime, // 设置缓存时间,如果不设置就永久缓存
            'automatic_serialization' => true
        );

        if ($backend == 'Memcached') {
            $backendOptions = array(
                'servers' => array(
                    array(
                        'host' => $config->memcache->host,
                        'port' => $config->memcache->port,
                        'persistent' => true
                    )
                ),
                'compression' => true,
            );
            // 取得一个Zend_Cache_Core 对象
            return Zend_Cache::factory('Core', 'Memcached', $frontendOptions, $backendOptions);
        } elseif ($backend == 'Sqlite') {
            $backendOptions = array(
                'cache_db_complete_path' => $config->sqliteFile,
                'automatic_vacuum_factor' => 10,
            );
            // 取得一个Zend_Cache_Core 对象
            return Zend_Cache::factory('Core', 'Sqlite', $frontendOptions, $backendOptions);
        } else {
            $uploadDir = $config->cacheDir;
            $uploadDir = !empty($uploadDir) ? $uploadDir : APPLICATION_PATH . "/../data/cache/";
            if (!empty($subDir)) {
                $uploadDir = preg_match('/\/$/', $uploadDir) ? $uploadDir . $subDir . "/" : $uploadDir . "/" . $subDir . "/";
            }

            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777);
            }
            $backendOptions = array(
                'file_name_prefix' => 'Ec',
                'cache_dir' => $uploadDir,
                'hashed_directory_level' => $directoryLevel,
            );
            // 取得一个Zend_Cache_Core 对象
            return Zend_Cache::factory('Core', 'File', $frontendOptions, $backendOptions);
        }
    }
    /**
     * 语言翻译
     */
    public static function Lang($str, $lang = null)
    {
        return Ec_Lang::getInstance()->translate($str, $lang);
    }
    /*
     **  $page:当前页 $rec_num:记录总数  $page_size:单页的最大记录数  $url:连接
     **
     **
     */
    public static function multiPage($page,$rec_num,$page_size=30,$url="",$page_size_max="1000"){
    	$url = ($url=="")?$_SERVER['REQUEST_URI']:$url;
    	$url = str_replace('/?','/',$url);
    	$url = str_replace('?','/',$url);
    	$url = str_replace('&','/',$url);
    	$url = str_replace('=','/',$url);
    	$end = strpos($url,'/page');
    	$url = ($end>0)?substr($url, 0, $end):$url;
    	$html = ""; // html代码
    	$pages = ceil($rec_num/$page_size);
    	$pages_per_pnl = 4; //面板页面容量
    	$page = ($page<1 || $page>$pages)?1:$page; //处理非法页面号
    	$pre_offset = 2; //前偏移量
    	//处理下限,当前页不可小于等于前偏移量,或者总页数小于等于面板容量
    	$l_limit = (($page<=$pre_offset)||($pages<=$pages_per_pnl))?1:($page-$pre_offset);
    	//不足一页且总页数大于等于面板容量，则调整上限
    	if((($pages - $page)<$pages_per_pnl)&&($pages>=$pages_per_pnl)){
    		$l_limit = (($pages - $pages_per_pnl)==0)?1:($pages - $pages_per_pnl);
    	}
    	//处理上限
    	$u_limit = (($l_limit+$pages_per_pnl)>$pages)?$pages:($l_limit+$pages_per_pnl);
    
    	$html .= '<div class="pages_btns size12px">'."\n";
    	$html .= '<div class="pages">'."\n";
    	$html .= '<em>&nbsp;'.$rec_num.'&nbsp;</em>'."\n";
    	//如果下限不是首页，则添加首页连接
    	if($l_limit > 1){
    		$html .= "<a href='$url/page/1'>1...</a>\n";
    	}
    	//前一页，只要当前页不是首页就显示
    	if($page != 1){
    		$pagePrev = ($page<=1)?1:$page-1;
    		$html .= "<a href='$url/page/$pagePrev' ><<</a>\n";
    	}
    	for($i=$l_limit; $i<=$u_limit; ++$i){
    		if(isset($page)&&($i==$page)){
    			$html .= "<strong>$i</strong>\n";
    		}else{
    			$html .= "<a href='$url/page/$i'>$i</a>\n";
    		}
    	}
    	//下一页.只要当前页不是最后一页就显示
    	if($page != $pages && $rec_num!=0){
    		$pageNext = ($page>=$pages)?$pages:($page+1);
    		$html .= "<a href='$url/page/$pageNext'>>></a>\n";
    	}
    	//如果上限不是末页，则添加末页连接
    	if($u_limit < $pages){
    		$html .= "<a href='$url/page/$pages'>...$pages</a>\n";
    	}
    	$html .= "</div>";
    	$html .= "<span style='margin-left:5px'>每页：<input class='inputText pageSize' type='text' maxlength='3' style='width:30px;' value='$page_size' onkeydown='if(event.keyCode==13){\$(\".pageSubmit\").click();return false;}' /> <input  type='button' class='pageSubmit' value='确认' onclick='if($(\".pageSize\").val() < $page_size_max){setCookie(\"pageSize\",$(\".pageSize\").val());window.location.reload();}'/></span>";
    	$html .= "</div>\n";
    	return $html;
    }
}