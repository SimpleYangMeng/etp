<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE); 
define('APPLICATION_PATH',dirname(dirname(__FILE__)) . '/application');
set_include_path(
        implode(PATH_SEPARATOR, 
                array(
                        realpath(APPLICATION_PATH . '/../libs'),
                        realpath(APPLICATION_PATH . '/models'),
                        realpath(APPLICATION_PATH . '/modules'),
                        APPLICATION_PATH,
                        get_include_path()
                )));
require_once('Zend/Loader/Autoloader.php');
$autoloader = Zend_Loader_Autoloader::getInstance();
$autoloader->setFallbackAutoloader(true);
Zend_Session::start();
$config = new Zend_Config_Ini(dirname(dirname(__FILE__)) . '/application/configs/config.ini', 'production');
$server = new Zend_Config_Ini(dirname(dirname(__FILE__)) . '/application/configs/db.ini', 'production');
Zend_Registry::set('config', $config);
$dir =  APPLICATION_PATH."/modules";    
$Ld = dir($dir);
$arr = array();
while (false !== ($entry = $Ld->read())) {
	$checkdir = $dir . "/" . $entry;
	if (is_dir($checkdir) && ! preg_match("[^\.]", $entry)) {
		$resourceLoader = new Zend_Application_Module_Autoloader(array(
				'namespace' => ucfirst($entry) . "",
				'basePath' => $checkdir
		));
		$arr[ucfirst($entry)] = $checkdir;
	}
}
$content = serialize($arr);
//file_put_contents($catchFile,$content);
$Ld->close();

$resourceLoader->getResourceTypes();
$params = array ('host' => $server->resources->multidb->common->host,
				 'username' => $server->resources->multidb->common->username, 
				 'password' => $server->resources->multidb->common->password, 
				 'dbname' => $server->resources->multidb->common->dbname);

// print_r($params);exit;
$db = Zend_Db::factory('PDO_MYSQL', $params);
Zend_Db_Table_Abstract::setDefaultAdapter($db);
$db->query('set names utf8');
Zend_Registry::set('db', $db);
Zend_Registry::set('dbprefix', $server->dbprefix);
?>