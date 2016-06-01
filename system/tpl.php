<?php

class Tpl
{
	public static $template_ext = '.tpl';
	public static $view;
	
	public static $template_path;
	
	static function init()
	{
		if (!is_object(self::$view))
		{			
			self::$template_path = realpath(ROOT_PATH . '/views/');
			
			self::$view = new Savant3(
				array(
					'template_path' => array(self::$template_path),
					//'filters' => array('Savant3_Filter_trimwhitespace', 'filter')
				)
			);
		}
		
		return self::$view;
	}
	
	static function output($template_filename, $display = true)
	{
		self::init();
		
		if (!strstr($template_filename, self::$template_ext))
		{
			$template_filename .= self::$template_ext;
		}
		
		$output = self::$view->getOutput($template_filename);
		
		if ($display)
		{
			echo $output;
		}
		else
		{
			return $output;	
		}
	}
	
	static function assign($name, $value)
	{
		self::init();
		
		self::$view->$name = $value;
	}
	
	static function val($name)
	{
		self::init();
		
		return self::$view->$name;
	}
}
