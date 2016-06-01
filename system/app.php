<?php

class App {
	static $database;
	static $table_prefix;
	static $db_config;
	
	static public function run($db_config)
	{
		@set_time_limit(0);
		
		self::$db_config = $db_config;
		
		if (!self::$db_config['anwsion']['dbname'])
		{
			self::$db_config['anwsion']['dbname'] = '__DB__';
		}
		
		if (!self::$db_config['discuz']['dbname'])
		{
			self::$db_config['discuz']['dbname'] = '__DB__';
		}
		
		if (!self::$db_config['ucenter']['dbname'])
		{
			self::$db_config['ucenter']['dbname'] = '__DB__';
		}
		
		try {
			self::$database['anwsion'] = Zend_Db::factory('MySQLi', self::$db_config['anwsion']);
			self::$database['anwsion']->query("SET sql_mode = ''");
		}
		catch (Exception $e)
		{
			unset($_POST);
			
			show_message('Anwsion 数据无法连接: ' . $e->getMessage());
		}
			
		try {
			self::$database['discuz'] = Zend_Db::factory('MySQLi', self::$db_config['discuz']);
			self::$database['discuz']->query("SET sql_mode = ''");
		}
		catch (Exception $e)
		{
			unset($_POST);
			
			show_message('Discuz 数据无法连接: ' . $e->getMessage());
		}
		
		try {
			self::$database['ucenter'] = Zend_Db::factory('MySQLi', self::$db_config['ucenter']);
			self::$database['ucenter']->query("SET sql_mode = ''");
		}
		catch (Exception $e)
		{
			unset($_POST);
			
			show_message('UCenter 数据无法连接: ' . $e->getMessage());
		}
		
		self::$table_prefix['anwsion'] = $db_config['anwsion']['table_prefix'];
		self::$table_prefix['discuz'] = $db_config['discuz']['table_prefix'];
		self::$table_prefix['ucenter'] = $db_config['ucenter']['table_prefix'];
	}
	
	static public function database($db_name)
	{
		return self::$database[$db_name];
	}
	
	static public function table_prefix($db_name)
	{
		return self::$table_prefix[$db_name];
	}
}