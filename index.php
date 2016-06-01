<?php

include_once('system/init.php');

if ($_POST['db_config_serialize'])
{
	App::run(unserialize(base64_decode($_POST['db_config_serialize'])));
}
else if ($_POST['db_config'])
{
	App::run($_POST['db_config']);
}

switch ($_POST['act'])
{
	default:
		$page_title = '基本配置';
		$template_file = 'index';
	break;
	
	case 'init':
		$page_title = '准备就绪';
		$template_file = 'init';
	break;
	
	case 'clean_up':
		Core_Convert::clean_up();
		
		$_POST['act'] = 'import_users';
			
		show_message('数据库清理完成, 接下来转换用户');
	break;
	
	case 'import_users':
		// 用户转换
		if (!Core_Convert::import_users($_POST['page'], $_POST['pre_page']))
		{
			$_POST['act'] = 'import_admin';
			$_POST['page'] = 1;
			
			show_message('用户导入完成, 开始导入管理员');
		}
		else
		{
			$_POST['page']++;
			
			show_message('正在导入用户, 当前第 ' . ($_POST['page'] - 1) . ' 批, 每批处理 ' . $_POST['pre_page'] . ' 条');
		}
	break;
		
	case 'import_admin':
		// 导入管理员
		Core_Convert::import_admin();
		
		$_POST['act'] = 'import_forum';
			
		show_message('管理员导入完成, 接下来转换论坛版面');
	break;

	case 'import_forum':
		// 转换论坛
		Core_Convert::import_forum();
		
		$_POST['act'] = 'import_thread';
			
		show_message('论坛版面导入完成, 接下来转换论坛帖子');
	break;
	
	case 'import_thread':
		// 转换帖子
		if (!Core_Convert::import_thread($_POST['page'], $_POST['pre_page']))
		{
			$_POST['act'] = 'import_tag_item';
			$_POST['page'] = 1;
			
			show_message('帖子导入完成, 开始导入标签关系');
		}
		else
		{
			$_POST['page']++;
			
			show_message('正在导入帖子, 当前第 ' . ($_POST['page'] - 1) . ' 批, 每批处理 ' . $_POST['pre_page'] . ' 条');
		}
	break;

	case 'import_tag_item':
		if (!Core_Convert::import_tag_item($_POST['page'], $_POST['pre_page']))
		{
			$_POST['act'] = 'import_attach';
			$_POST['page'] = 1;
			
			show_message('标签关系导入完成, 开始导入附件数据');
		}
		else
		{
			$_POST['page']++;
			
			show_message('正在导入标签关系, 当前第 ' . ($_POST['page'] - 1) . ' 批, 每批处理 ' . $_POST['pre_page'] . ' 条');
		}
	break;
	
	case 'import_attach':
		if (!$_POST['convert_attach'])
		{
			$_POST['act'] = 'import_tag';
			$_POST['page'] = 1;
			
			show_message('已忽略附件数据, 开始导入标签数据');
		}
		
		$pre_page = $_POST['pre_page'] / 10;
		
		if (!Core_Convert::import_attach($_POST['page'], intval($pre_page)))
		{
			$_POST['act'] = 'import_tag';
			$_POST['page'] = 1;
			
			show_message('附件数据导入完成, 开始导入标签数据');
		}
		else
		{
			$_POST['page']++;
			
			show_message('正在导入附件数据, 当前第 ' . ($_POST['page'] - 1) . ' 批, 每批处理 ' . $_POST['pre_page'] . ' 条');
		}
	break;

	case 'import_tag':
		if (!Core_Convert::import_tag($_POST['page'], $_POST['pre_page']))
		{
			unset($_POST);
			
			show_message('转换完成, 现在您可以进入后台转换 BBCode, 重建搜索索引, 重建首页动态');
		}
		else
		{
			$_POST['page']++;
			
			show_message('正在导入标签数据, 当前第 ' . ($_POST['page'] - 1) . ' 批, 每批处理 ' . $_POST['pre_page'] . ' 条');
		}
	break;
}

Tpl::assign('page_title', $page_title . ' - Answsion Discuz Converter');
Tpl::output($template_file);