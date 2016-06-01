<?php

class Core_Convert
{
	static public function clean_up()
	{
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'question', 'question_id > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'answer', 'answer_id > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'users', 'uid > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'users_attrib', 'uid > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'integral_log', 'uid > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'category', 'id > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'user_action_history', 'history_id > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'user_action_history_data', 'history_id > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'topic', 'topic_id > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'topic_relation', 'topic_id > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'user_follow', 'fans_uid > 0');
		App::database('anwsion')->delete(App::table_prefix('anwsion') . 'attach', 'id > 0');
		//App::database('anwsion')->delete(App::table_prefix('anwsion') . 'cache', "`key` != ''");
		
	}
	
	static public function import_users($page, $pre_page)
	{
		if ($members = App::database('ucenter')->fetchAll("SELECT `uid`, `username`, `email`, `password`, `salt`, `regdate`, `lastlogintime` FROM " . App::table_prefix('ucenter') . "members ORDER BY `uid` ASC LIMIT " . calc_page_limit($page, $pre_page)))
		{
			if ($_POST['focus_uids'])
			{
				if (rtrim($_POST['focus_uids'], ','))
				{
					$focus_uids = explode(',', $_POST['focus_uids']);
				}
			}
			
			foreach ($members AS $key => $val)
			{
				if (strtolower(App::$db_config['ucenter']['charset']) == 'gbk')
				{
					$val = convert_encoding_array($val);
				}
				
				if (App::database('anwsion')->fetchRow("SELECT uid FROM " . App::table_prefix('anwsion') . "users WHERE uid = " . $val['uid']))
				{
					continue;
				}
				
				App::database('anwsion')->insert(App::table_prefix('anwsion') . 'users', array(
					'uid' => $val['uid'],
					'user_name' => $val['username'],
					'email' => $val['email'],
					'password' => $val['password'],
					'salt' => $val['salt'],
					'reg_time' => $val['regdate'],
					'last_login' => $val['lastlogintime'],
					'last_active' => $val['lastlogintime'],
					'reputation_group' => 5,
					'integral' => 2000,
					'valid_email' => 1,
					'is_first_login' => 1,
					'invitation_available' => 10,
					'group_id' => 4,
					'friend_count' => sizeof($focus_uids)
				));
				
				App::database('anwsion')->insert(App::table_prefix('anwsion') . 'users_attrib', array(
					'uid' => $val['uid']
				));
				
				App::database('anwsion')->insert(App::table_prefix('anwsion') . 'integral_log', array(
					'uid' => $val['uid'],
					'action' => 'REGISTER',
					'note' => '初始资本',
					'integral' => 2000,
					'balance' => 2000,
					'time' => time()
				));
					
				if (is_array($focus_uids))
				{
					foreach ($focus_uids AS $focus_uid)
					{
						App::database('anwsion')->insert(App::table_prefix('anwsion') . 'user_follow', array(
							'fans_uid' => $val['uid'],
							'friend_uid' => intval($focus_uid),
							'add_time' => time()
						));
					}
				}
			}
		
			return true;
		}
	
		return false;
	}

	static public function import_forum()
	{
		if ($forums = App::database('discuz')->fetchAll("SELECT * FROM " . App::table_prefix('discuz') . "forum_forum WHERE `type` IN ('group', 'forum') AND `status` = 1 ORDER BY fid ASC"))
		{
			foreach ($forums AS $key => $val)
			{
				if (strtolower(App::$db_config['discuz']['charset']) == 'gbk')
				{
					$val = convert_encoding_array($val);
				}
			
				App::database('anwsion')->insert(App::table_prefix('anwsion') . 'category', array(
					'id' => $val['fid'],
					'title' => $val['name'],
					'type' => 'question',
					'parent_id' => $val['fup']
				));
			}
		}
		
		if (!App::database('anwsion')->fetchRow("SELECT * FROM " . App::table_prefix('anwsion') . 'category WHERE id = 1'))
		{
			App::database('anwsion')->insert(App::table_prefix('anwsion') . 'category', array(
				'id' => 1,
				'title' => '默认分类',
				'type' => 'question',
				'parent_id' => 0
			));
		}
		
		return false;
	}

	static public function import_thread($page, $pre_page)
	{		
		if ($threads = App::database('discuz')->fetchAll("SELECT * FROM " . App::table_prefix('discuz') . "forum_thread ORDER BY tid ASC LIMIT " . calc_page_limit($page, $pre_page)))
		{
			foreach ($threads AS $key => $val)
			{
				if (strtolower(App::$db_config['discuz']['charset']) == 'gbk')
				{
					$val = convert_encoding_array($val);
				}
				
				if (App::database('anwsion')->fetchRow("SELECT question_id FROM " . App::table_prefix('anwsion') . "question WHERE question_id = " . $val['tid']))
				{
					continue;
				}
				
				App::database('anwsion')->insert(App::table_prefix('anwsion') . 'question', array(
					'question_id' => $val['tid'],
					'question_content' => '', 
					'question_detail' => '', 
					'add_time' => 0, 
					'update_time' => $val['lastpost'], 
					'published_uid' => $val['authorid'], 
					'anonymous' => 0,
					'ip' => '',
					'category_id' => $val['fid'],
					'view_count' => $val['views'],
					'answer_count' => $val['replies']
				));
				
				App::database('anwsion')->insert(App::table_prefix('anwsion') . 'question_focus', array(
					'question_id' => $val['tid'], 
					'uid' => $val['authorid'], 
					'add_time' => time()
				));
			
				$posts = App::database('discuz')->fetchAll("SELECT * FROM " . App::table_prefix('discuz') . "forum_post WHERE tid = " . $val['tid'] . " ORDER BY pid ASC");
				
				if (strtolower(App::$db_config['discuz']['charset']) == 'gbk')
				{
					$posts = convert_encoding_array($posts);
				}
				
				if ($_POST['strip_bbcode'])
				{
					$post['message'] = strip_bbcode($post['message']);
				}
				
				foreach ($posts AS $p_key => $post)
				{
					if ($p_key == 0)
					{
						App::database('anwsion')->update(App::table_prefix('anwsion') . 'question', array(
							'question_content' => $post['subject'], 
							'question_detail' => $post['message'], 
							'add_time' => $post['dateline'], 
							'ip' => ip2long($post['useip'])
						), 'question_id = ' . $val['tid']);
					
						Core_Log::save_action($val['authorid'], $val['tid'], Core_Log::CATEGORY_QUESTION, Core_Log::ADD_QUESTION, htmlspecialchars($post['subject']), htmlspecialchars($post['message']), 0, 0);
						
						App::database('anwsion')->query("UPDATE " . App::table_prefix('anwsion') . "users SET question_count = question_count + 1 WHERE uid = " . $post['authorid']);
					}
					else
					{
						App::database('anwsion')->insert(App::table_prefix('anwsion') . 'answer', array(
							'answer_id' => $post['pid'],
							'question_id' => $val['tid'], 
							'answer_content' => $post['message'], 
							'add_time' => $post['dateline'], 
							'ip' => ip2long($post['useip']),
							'uid' => $post['authorid']
						));
						
						if (!App::database('anwsion')->fetchRow('SELECT question_id FROM ' . App::table_prefix('anwsion') . 'question_focus WHERE uid = ' . $post['authorid'] . ' AND question_id = ' . $val['tid']))
						{
							App::database('anwsion')->insert(App::table_prefix('anwsion') . 'question_focus', array(
								'question_id' => $val['tid'], 
								'uid' => $post['authorid'], 
								'add_time' => time()
							));
						}
						
						Core_Log::save_action($post['authorid'], $post['pid'], Core_Log::CATEGORY_ANSWER, Core_Log::ANSWER_QUESTION, htmlspecialchars($post['message']), $val['tid']);
			
						Core_Log::save_action($post['authorid'], $val['tid'], Core_Log::CATEGORY_QUESTION, Core_Log::ANSWER_QUESTION, htmlspecialchars($post['message']), $post['pid'], 0, 0);
						
						App::database('anwsion')->query("UPDATE " . App::table_prefix('anwsion') . "users SET answer_count = answer_count + 1 WHERE uid = " . $post['authorid']);
						App::database('anwsion')->update(App::table_prefix('anwsion') . 'question', array(
							'last_answer' => $post['pid']
						), 'question_id = ' . $val['tid']);
						
					}
				
					if ($post_comment = App::database('discuz')->fetchAll("SELECT * FROM " . App::table_prefix('discuz') . "forum_postcomment WHERE pid = " . $post['pid'] . " ORDER BY id ASC"))
					{
						if (strtolower(App::$db_config['discuz']['charset']) == 'gbk')
						{
							$post_comment = convert_encoding_array($post_comment);
						}
						
						foreach ($post_comment AS $comm_key => $comment)
						{
							if ($post['position'] == 1)
							{
								App::database('anwsion')->insert(App::table_prefix('anwsion') . 'question_comments', array(
									'question_id' => $val['tid'],
									'uid' => $comment['authorid'], 
									'message' => $comment['comment'], 
									'time' => $comment['dateline'], 
								));
							}
							else
							{
								App::database('anwsion')->insert(App::table_prefix('anwsion') . 'answer_comments', array(
									'answer_id' => $post['pid'],
									'uid' => $comment['authorid'], 
									'message' => $comment['comment'], 
									'time' => $comment['dateline'], 
								));
							}
						}
					}
				}
			}
	
			return true;
		}
	
		return false;
	}
	
	static public function import_attach()
	{
		require_once(rtrim($_POST['anwsion_dir'], '/') . '/system/config/image.php');
		
		$discuz_attach_dir = rtrim($_POST['discuz_attach_dir'], '/') . '/';
		
		$upload_dir_setting = App::database('anwsion')->fetchRow("SELECT * FROM " . App::table_prefix('anwsion') . "system_setting WHERE varname = 'upload_dir'");
		
		$anwsion_upload_dir = unserialize($upload_dir_setting['value']);
		
		for ($i = 0; $i < 10; $i++)
		{
			if ($attachs = App::database('discuz')->fetchAll("SELECT * FROM " . App::table_prefix('discuz') . "forum_attachment_" . $i . " WHERE remote = 0"))
			{
				foreach ($attachs AS $key => $val)
				{
					if (!file_exists($discuz_attach_dir . $val['attachment']))
					{
						continue;
					}
					
					if (strtolower(App::$db_config['discuz']['charset']) == 'gbk')
					{
						$val = convert_encoding_array($val);
					}
					
					if (App::database('anwsion')->fetchRow("SELECT * FROM " . App::table_prefix('anwsion') . "answer WHERE answer_id = " . $val['pid']))
					{
						$item_type = 'answer';
						$item_id = $val['pid'];
						$dir_name = 'answer';
					}
					else
					{
						$item_type = 'question';
						$item_id = $val['tid'];
						$dir_name = 'questions';
					}
					
					App::database('anwsion')->update(App::table_prefix('anwsion') . $item_type, array(
						'has_attach' => 1
					), $item_type . '_id = ' . $item_id);
					
					$attach_dir = $anwsion_upload_dir . '/' . $dir_name . '/' . date('Ymd', $val['dateline']) . '/';
					
					make_dir($attach_dir);
					
					$attach_file = $attach_dir . basename($val['attachment']);
					
					if (copy($discuz_attach_dir . $val['attachment'], $attach_file))	
					{
						App::database('anwsion')->insert(App::table_prefix('anwsion') . 'attach', array(
							'access_key' => md5(rand(1, 999999)),
							'file_name' => $val['filename'],
							'is_image' => -$val['isimage'],
							'file_location' => basename($val['attachment']),
							'add_time' => $val['dateline'],
							'item_type' => $item_type,
							'item_id' => $item_id
						));
					}
					
					if ($val['isimage'] == -1)
					{						
						foreach ($config['attachment_thumbnail'] AS $key => $val)
						{
							$thumb_file[$key] = $attach_dir . $val['w'] . 'x' . $val['h'] . '_' . basename($attach_file);
							if (!is_object($core_image))
							{
								$core_image = new Core_Image();
							}
							
							$core_image->initialize(array(
								'quality' => 90,
								'source_image' => $attach_file,
								'new_image' => $thumb_file[$key],
								'width' => $val['w'],
								'height' => $val['h']
							))->resize();	
						}
					}
				}
			}
		}
		
		return false;
	}

	static public function import_admin()
	{
		if ($admins = App::database('ucenter')->fetchAll("SELECT uid FROM " . App::table_prefix('ucenter') . "admins"))
		{
			foreach ($admins AS $key => $val)
			{				
				App::database('anwsion')->update(App::table_prefix('anwsion') . 'users', array(
					'group_id' => 1
				), 'uid = ' . $val['uid']);
			}
		}
		
		return false;
	}
	
	static public function import_tag($page, $pre_page)
	{
		if ($tags = App::database('discuz')->fetchAll("SELECT * FROM " . App::table_prefix('discuz') . "common_tag ORDER BY tagid ASC LIMIT " . calc_page_limit($page, $pre_page)))
		{
			foreach ($tags AS $key => $val)
			{
				if (strtolower(App::$db_config['discuz']['charset']) == 'gbk')
				{
					$val = convert_encoding_array($val);
				}
				
				if (App::database('anwsion')->fetchRow("SELECT topic_id FROM " . App::table_prefix('anwsion') . "topic WHERE topic_id = " . $val['tagid']))
				{
					continue;
				}
				
				$questions = App::database('anwsion')->fetchRow('SELECT COUNT(*) AS `count` FROM ' . App::table_prefix('anwsion') . 'topic_relation WHERE topic_id = ' . $val['tagid']);	
					
				App::database('anwsion')->insert(App::table_prefix('anwsion') . 'topic', array(
					'topic_id' => $val['tagid'],
					'topic_title' => $val['tagname'], 
					'add_time' => time(),
					'discuss_count' => $questions['count']
				));
			}
			
			return true;
		}
		
		return false;
	}
	
	static public function import_tag_item($page, $pre_page)
	{
		if ($tags = App::database('discuz')->fetchAll("SELECT * FROM " . App::table_prefix('discuz') . "common_tagitem WHERE `idtype` = 'tid' ORDER BY tagid ASC LIMIT " . calc_page_limit($page, $pre_page)))
		{			
			foreach ($tags AS $key => $val)
			{
				if (App::database('anwsion')->fetchRow("SELECT add_time FROM " . App::table_prefix('anwsion') . "topic_relation WHERE item_id = " . $val['itemid'] . " AND `type` = 'question' AND topic_id = " . $val['tagid']))
				{
					continue;
				}
				
				App::database('anwsion')->insert(App::table_prefix('anwsion') . 'topic_relation', array(
					'item_id' => $val['itemid'],
					'type' => 'question',
					'topic_id' => $val['tagid'],
					'add_time' => time()
				));
			}
			
			return true;
		}
		
		return false;
	}
}