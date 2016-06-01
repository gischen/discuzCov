<?php

function &load_class($class)
{
	static $_classes = array();
	
	// Does the class exist?  If so, we're done...
	if (isset($_classes[$class]))
	{
		return $_classes[$class];
	}
	
	if (class_exists($class) === FALSE)
	{
		$file = ROOT_PATH . '/system/' . preg_replace('#_+#', '/', $class) . '.php';
		
		if (! file_exists($file))
		{
			die('Unable to locate the specified class: ' . $class . ' ' . preg_replace('#_+#', '/', $class) . '.php');
		}
		
		require_once $file;
	}
	
	$_classes[$class] = new $class();
	
	return $_classes[$class];
}

function calc_page_limit($page, $pre_page)
{
	if ($page < 1)
	{
		$page = 1;
	}
	
	return ((intval($page) - 1) * $pre_page) . ', ' . $pre_page;
}


function convert_encoding_array($string, $from_encoding = 'GBK', $target_encoding = 'UTF-8')
{
	if (is_array($string))
	{
		foreach ($string AS $key => $val)
		{
			$string[$key] = convert_encoding_array($val, $from_encoding, $target_encoding);
		}
	}
	else
	{
		return convert_encoding($string, $from_encoding, $target_encoding);
	}
	
	return $string;
}

function convert_encoding($string, $from_encoding = 'GBK', $target_encoding = 'UTF-8')
{	
	if (function_exists('mb_convert_encoding'))
	{
		return mb_convert_encoding($string, str_replace('//IGNORE', '', strtoupper($target_encoding)), $from_encoding);
	}
	else
	{
		if (strtoupper($target_encoding) == 'GB2312' OR strtoupper($target_encoding) == 'GBK')
		{
			$target_encoding .= '//IGNORE';
		}
		
		return iconv($from_encoding, $target_encoding, $string);
	}
}

function show_message($message)
{		
	TPL::assign('message', $message);

	TPL::output('show_message');
	die;
}

function strip_bbcode($str)
{
	return preg_replace('/\[[^\[\]]{1,}\]/', '', $str);
}

function make_dir($dir, $mode = 0777)
{
	$dir = rtrim($dir, '/') . '/';
	
	if (is_dir($dir))
	{
		return TRUE;
	}
	
	if (! make_dir(dirname($dir), $mode))
	{
		return FALSE;
	}
	
	return @mkdir($dir, $mode);
}