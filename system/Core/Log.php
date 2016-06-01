<?php

class Core_Log
{
	/** 
	 * 添加问题
	 */
	const ADD_QUESTION = 101;
	/** 
	 * 修改问题标题
	 */
	const MOD_QUESTON_TITLE = 102;
	/** 
	 * 修改问题描述 
	 */
	const MOD_QUESTION_DESCRI = 103;
	/**
	 * 添加问题关注
	 */
	const ADD_REQUESTION_FOCUS = 105;
	/**
	 * 删除问题关注
	 */
	const DELETE_REQUESTION_FOCUS = 106;
	/**
	 * 问题重定向
	 */
	const REDIRECT_QUESTION = 107;
	/**
	 * 修改问题分类
	 */
	const MOD_QUESTION_CATEGORY = 108;
	/**
	 * 修改问题附件
	 */
	const MOD_QUESTION_ATTACH = 109;
	/**
	 * 删除问题重定向
	 */
	const DEL_REDIRECT_QUESTION = 110;
	/**
	 * 修改问题
	 */
	const MOD_QUESTION = 111;
	/** 
	 * 回复问题
	 */
	const ANSWER_QUESTION = 201;
	/** 
	 * 修改回复
	 */
	const MOD_ANSWER = 202;
	/**
	 * 删除回复 
	 */
	const DELETE_ANSWER = 203;
	/**
	 * 增加赞同
	 */
	const ADD_AGREE = 204;
	/**
	 * 增加反对投票
	 */
	const ADD_AGANIST = 205;
	/**
	 * 增加感谢作者
	 */
	const ADD_USEFUL = 206;
	/**
	 * 问题没有帮助
	 */
	const ADD_UNUSEFUL = 207;
	/**
	 * 取消赞成
	 */
	const DEL_AGREE = 208;
	/**
	 * 取消反对投票
	 */
	const DEL_AGANIST = 209;
	/** 
	 * 增加评论
	 */
	const ADD_COMMENT = 301;
	/**
	 * 删除评论
	 */
	const DELETE_COMMENT = 302;
	/** 
	 * 创建话题
	 */
	const ADD_TOPIC = 401;
	/** 
	 * 修改话题
	 */
	const MOD_TOPIC = 402;
	/** 
	 * 修改话题描述
	 */
	const MOD_TOPIC_DESCRI = 403;
	/**
	 * 修改话题缩图
	 */
	const MOD_TOPIC_PIC = 404;
	/**
	 * 删除话题
	 */
	const DELETE_TOPIC = 405;
	/**
	 * 添加话题关注
	 */
	const ADD_TOPIC_FOCUS = 406;
	/**
	 * 删除话题关注
	 */
	const DELETE_TOPIC_FOCUS = 407;
	/**
	 * 增加话题分类
	 */
	const ADD_TOPIC_PARENT = 408;
	/**
	 * 删除话题分类
	 */
	const DELETE_TOPIC_PARENT = 409;
	/**
	 * 添加相关话题
	 */
	const ADD_RELATED_TOPIC = 410;
	/**
	 * 删除相关话题
	 */
	const DELETE_RELATED_TOPIC = 411;
	/**
	 * 问题
	 */
	const CATEGORY_QUESTION = 1;
	/**
	 * 回复
	 */
	const CATEGORY_ANSWER = 2;
	/**
	 * 评论
	 */
	const CATEGORY_COMMENT = 3;
	/**
	 * 话题 
	 */
	const CATEGORY_TOPIC = 4;
	

	/**
	 * 
	 * 增加用户动作跟踪
	 * @param int    $uid
	 * @param int    $associate_id   关联ID
	 * @param int    $action_type    动作大类型
	 * @param int    $action_id      动作详细类型
	 * @param string $action_content 动作内容
	 * @param string $action_attch   动作附加内容
	 * @param int    $add_time       动作发送时间
	 * 
	 * @return boolean true|false
	 */
	public static function save_action($uid, $associate_id, $action_type, $action_id, $action_content = '', $action_attch = '', $add_time = 0, $anonymous = 0)
	{
		if (intval($uid) == 0 || intval($associate_id) == 0)
		{
			return false;
		}
		
		if (is_numeric($action_attch))
		{
			$action_attch_insert = $action_attch;
		}
		else
		{
			$action_attch_insert = '-1';
			$action_attch_update = $action_attch;
		}
		
		App::database('anwsion')->insert(App::table_prefix('anwsion') . 'user_action_history', array(
			'uid' => intval($uid), 
			'associate_type' => $action_type, 
			'associate_action' => $action_id, 
			'associate_id' => $associate_id, 
			'associate_attached' => $action_attch_insert,
			'add_time' => ($add_time == 0) ? time() : $add_time,
			//'anonymous' => $anonymous,
		));
		
		$history_id = App::database('anwsion')->lastInsertId();
		
		App::database('anwsion')->insert(App::table_prefix('anwsion') . 'user_action_history_data', array(
			'history_id' => $history_id, 
			'associate_content' => htmlspecialchars($action_content), 
			'associate_attached' => htmlspecialchars($action_attch_update)
		));
		
		return $history_id;
	}
}