<?php
class core extends objectbase
{
	static $baseC = null;
	function __construct()
	{
		self::$baseC = new base;
	}
	function get_settings_by_name($name)
	{
		$where_arr = array(array("key"=>'name', "value"=>$name, "oper"=>'='));
		$sel = self::$baseC->select('settings', '', 'value', $where_arr, 'AND');
		return $sel[0]['value'];
	}
	function get_readers_count($tid, $anon=0)
	{
		if($anon==1)
		{
			$param_arr = array($tid);
			$sel = self::$baseC->query('SELECT count(session_id) AS cnt FROM sessions WHERE tid = \'::0::\' AND uid = 1', 'assoc_array', $param_arr);
		}
		elseif($anon==2)
		{
			$param_arr = array($tid);
			$sel = self::$baseC->query('SELECT count(session_id) AS cnt FROM sessions WHERE tid = \'::0::\' AND uid != 1', 'assoc_array', $param_arr);
		}
		else
		{
			$param_arr = array($tid);
			$sel = self::$baseC->query('SELECT count(session_id) AS cnt FROM sessions WHERE tid = \'::0::\'', 'assoc_array', $param_arr);
		}
		return $sel[0]['cnt'];
	}
	function get_readers($tid)
	{
		$where_arr = array(array("key"=>'tid', "value"=>$tid, "oper"=>'='), array("key"=>'uid', "value"=>'1', "oper"=>'>'));
		$usrs = self::$baseC->select('sessions', '', 'uid', $where_arr, 'AND');
		if(!empty($usrs))
		{
			for($i=0; $i<count($usrs); $i++)
			{
				$where_arr = array(array("key"=>'id', "value"=>$usrs[$i]['uid'], "oper"=>'='));
				$sel = self::$baseC->select('users', '', 'nick,gid', $where_arr, 'AND');
				$ret[$i] = $sel[0];
			}
			return $ret;
		}
		else
			return -1;
	}
	function update_sessions_table($session_id, $uid, $tid)
	{
		$timestamp =  gmdate("Y-m-d H:i:s", strtotime("-5 min", time()));
		$where_arr = array(array("key"=>'timest', "value"=>$timestamp, "oper"=>'<'));
		$subsect = self::$baseC->select('sessions', '', '*', $where_arr, 'AND');
		if(!empty($subsect))
		{
			for($i=0; $i<count($subsect); $i++)
				self::$baseC->delete('sessions', 'id', $subsect[$i]['id']);
		}
		if($uid != 1)
		{
			self::$baseC->delete('sessions', 'uid', $uid);
		}
		self::$baseC->delete('sessions', 'session_id', $session_id);
		$timest = gmdate("Y-m-d H:i:s");
		$msg_arr = array(array('session_id', $session_id), array('uid', $uid), array('tid', $tid), array('timest', $timest));
		$ret = self::$baseC->insert('sessions', $msg_arr);
	}
	function get_themes_count()
	{
		$sel = self::$baseC->query('SELECT count(*) AS cnt FROM themes ORDER BY id ASC','assoc_array');
		if(!empty($sel))
			return $sel[0]['cnt'];
		else
			return -1;
	}
	function get_themes()
	{
		$sel = self::$baseC->query('SELECT * FROM themes ORDER BY id ASC','assoc_array');
		if(!empty($sel))
			return $sel;
		else
			return -1;
	}
	function get_captcha_levels()
	{
		/*заглушка созданная для того, чтобы впоследствии можно было добавлять новые уровни каптчи*/
		$ret = array(array("name"=>'Нет', "value"=>-1), array("name"=>'Все', "value"=>0), array("name"=>'1', "value"=>1), array("name"=>'2', "value"=>2), array("name"=>'3', "value"=>3), array("name"=>'4', "value"=>4));
		return $ret;
	}
	function block_exists($name, $blocks)
	{
		foreach($blocks as $blck)
		{
			if($blck['name']==$name)
				return 1;
		}
		return 0;
	}
	function get_block($name='all')
	{
		if($name == 'all')
			$sel = self::$baseC->query('SELECT * FROM blocks ORDER BY id ASC','assoc_array');
		else
		{
			$param_arr = array($name);
			$sel = self::$baseC->query('SELECT * FROM blocks WHERE name=\'::0::\' ORDER BY id ASC','assoc_array', $param_arr);
		}
		if(!empty($sel))
			return $sel;
		else
			return -1;
	}
	function sort_block($name, $blocks)
	{
		foreach($blocks as $blck)
		{
			if($blck['name']==$name)
				return $blck;
		}
		return -1;
	}
	function get_blocks_count()
	{
		$sel = self::$baseC->query('SELECT count(*) AS cnt FROM blocks ORDER BY id ASC','assoc_array');
		if(!empty($sel))
			return $sel[0]['cnt'];
		else
			return -1;
	}
	function get_links()
	{
		$sel = self::$baseC->query('SELECT * FROM links ORDER BY id ASC','assoc_array', array());
		if(!empty($sel))
			return $sel;
		else
			return -1;
	}
	function include_theme_file($theme, $filepath)
	{
		$path = 'themes/'.$theme.'/'.$filepath;
		if(file_exists($path))
		{
			include $path;
		}
		else
		{
			include 'themes/default/'.$filepath;
		}


	}
	function remove_spam()//функция не применяется
	{
		$yesterday = gmdate('Y-m-d', strtotime('-1 day')).' '.gmdate("H:i:s");
		$param_arr = array($yesterday);
		$sel = self::$baseC->query('SELECT * FROM comments WHERE filters LIKE \'%4:1%\' AND timest < \'::0::\'','assoc_array', $param_arr);
		if(!empty($sel))
		{
			$error = 0;
			for($i=0; $i<count($sel); $i++)
			{
				$ret = self::$baseC->delete('comments', 'id', $sel[$i]['id']);
				if($ret<0)
					$error = 1;
			}
			if($error)
				return -1;
			else
				return 1;
		}
		else
			return -1;
	}
	function is_installed()
	{
		$file = 'config/install.ini';
		if(!is_file($file))
			return 0;
		$ini = parse_ini_file($file, 1);
		$installed = $ini['global']['installed'];
		if($installed == 1)
			return 1;
		else
			return 0;

	}
}
?>
