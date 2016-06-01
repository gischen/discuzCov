<?php

class Core_Autoload
{
	public function __construct()
	{
		set_include_path(ROOT_PATH . '/system/');
		
		spl_autoload_register(array($this, 'loader'));
	}
    
    private static function loader($class_name)
	{
		$require_file = ROOT_PATH . '/system/' . preg_replace('#_+#', '/', $class_name) . '.php';
		
		if (file_exists($require_file))
		{
			return require_once $require_file;
		}

		die('Class ' . $class_name . ' (' . $require_file . ') Not found.');
		
		return true;
	}
}