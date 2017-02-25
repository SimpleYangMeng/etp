<?php
@header('Content-Type:text/html;charset=utf-8');
//error_reporting(E_ERROR | E_WARNING | E_PARSE);
error_reporting(E_ALL);//开启错误报告
//error_reporting(0);//开启错误报告
$display_error = 1;	//1:显示错误  2:记录到Log文件
function microtime_float()
{
    list($usec, $sec) = explode(" ", microtime());
    return $usec + $sec;
}

$start_t = microtime_float();

// error_reporting(0);//开启错误报告
date_default_timezone_set('Asia/Shanghai');//配置地区
// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
define('WEB_URL','http://'.$_SERVER['HTTP_HOST']);
// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../libs'),
	realpath(APPLICATION_PATH . '/models'),
	realpath(APPLICATION_PATH . '/modules'),
	APPLICATION_PATH,
    get_include_path(),
)));
//define('WEB_URL','http://'.$_SERVER['HTTP_HOST']);
/** Zend_Application */
require_once 'Zend/Application.php';

try{
	// Create application, bootstrap, and run
	$application = new Zend_Application(
	    APPLICATION_ENV,
	    APPLICATION_PATH . '/configs/server.ini'
	);
	
	$application->bootstrap();
	//$application->getBootstrap()->getResource("frontController")->setParam('useDefaultControllerAlways', true);
	
	$application->run();
} catch(Exception $e) {
	$error = $e->getMessage().$e->getTraceAsString();
	if($display_error === 1) echo $error;
	else if($display_error === 2) Zend_Registry::get('log')->err($error);
}