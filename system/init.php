<?php

/** 设定时间  **/
date_default_timezone_set('Etc/GMT-8');

/** 错误级别 **/
error_reporting(E_ALL ^ E_NOTICE);

/** 核心框架路径 **/
if (! defined('ROOT_PATH'))
{
	define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
}

if (function_exists('get_magic_quotes_gpc'))
{
	/** 变量处理 */
	if (get_magic_quotes_gpc()) // GPC 进行反向处理
	{
		if (! function_exists('stripslashes_gpc'))
		{

			function stripslashes_gpc(&$value)
			{
				$value = stripslashes($value);
			}
		}
		
		array_walk_recursive($_GET, 'stripslashes_gpc');
		array_walk_recursive($_POST, 'stripslashes_gpc');
		array_walk_recursive($_COOKIE, 'stripslashes_gpc');
		array_walk_recursive($_REQUEST, 'stripslashes_gpc');
	}
}

if (@ini_get('register_globals'))
{
	if ($_REQUEST)
	{
		foreach ($_REQUEST AS $name => $value)
		{
			unset($$name);
		}
	}
}

require_once(ROOT_PATH . '/system/functions.php');
require_once(ROOT_PATH . '/system/app.php');
require_once(ROOT_PATH . '/system/tpl.php');

load_class('Core_Autoload');

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: no-cache, must-revalidate'); // HTTP/1.1
header('Pragma: no-cache');
header('Content-Type: text/html; charset=utf-8');