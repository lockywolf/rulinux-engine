<?php
final class sections extends object
{
	static $baseC = null;
	function __construct()
	{
		self::$baseC = new base;
	}
	function get_subsection_thr_count($section_id, $subsection_id)
	{
		$timest_day = gmdate('Y-m-d H:i:s',strtotime('-1 day'));
		$timest_hour = gmdate('Y-m-d H:i:s',strtotime('-1 hour'));
		$where_arr = array(array("key"=>'section', "value"=>$section_id, "oper"=>'='), array("key"=>'subsection', "value"=>$subsection_id, "oper"=>'='));
		$thr_in_subsect_all = self::$baseC->select('threads', '', 'count(id) AS cnt', $where_arr, 'AND', '', '', 0, 'NULL', 'subsection');
		if(empty($thr_in_subsect_all[0]['cnt']))
			$thr_in_subsect_all[0]['cnt'] = '-';
		$param_arr = array($section_id, $subsection_id, $timest_day);
		$thr_in_subsect_day = self::$baseC->query('SELECT count(*) AS cnt FROM threads WHERE section = \'::0::\' AND subsection = \'::1::\' AND id IN (SELECT DISTINCT tid FROM comments WHERE timest>\'::2::\')', 'assoc_array', $param_arr);
		if(empty($thr_in_subsect_day[0]['cnt']))
			$thr_in_subsect_day[0]['cnt'] = '-';
		$param_arr = array($section_id, $subsection_id, $timest_hour);
		$thr_in_subsect_hour = self::$baseC->query('SELECT count(*) AS cnt FROM threads WHERE section = \'::0::\' AND subsection = \'::1::\' AND id IN (SELECT DISTINCT tid FROM comments WHERE timest>\'::2::\')', 'assoc_array', $param_arr);
		if(empty($thr_in_subsect_hour[0]['cnt']))
			$thr_in_subsect_hour[0]['cnt'] = '-';
		$ret = array("subsection_thr_count"=>$thr_in_subsect_all[0]['cnt'], "subsection_thr_day"=>$thr_in_subsect_day[0]['cnt'], "subsection_thr_hour"=>$thr_in_subsect_hour[0]['cnt']);
		return $ret;
	}
	function get_section_by_tid($tid)
	{
		$where_arr = array(array("key"=>'id', "value"=>$tid, "oper"=>'='));
		$sel = self::$baseC->select('threads', '', 'section,subsection', $where_arr);
		$where_arr = array(array("key"=>'id', "value"=>$sel[0]['section'], "oper"=>'='));
		$name_sel = self::$baseC->select('sections', '', 'name, rewrite', $where_arr);
		$where_arr = array(array("key"=>'section', "value"=>$sel[0]['section'], "oper"=>'='), array("key"=>'sort', "value"=>$sel[0]['subsection'], "oper"=>'='));
		$subsect = self::$baseC->select('subsections', '', 'id,name,sort', $where_arr, 'AND');
		if(!empty($subsect))
			$subsection = $subsect[0]['name'];
		return array("id"=>$sel[0]['section'], "name"=>$name_sel[0]['name'], "subsection_id"=>$sel[0]['subsection'] , "subsection_name"=>$subsection, "rewrite"=>$name_sel[0]['rewrite']);
	}
	function get_subsections($section_id)
	{
		$where_arr = array(array("key"=>'section', "value"=>$section_id, "oper"=>'='));
		$sel = self::$baseC->select('subsections', '', '*', $where_arr, 'AND', 'sort', 'ASC');
		return $sel;
	}
	function get_subsection($section_id, $subsection_id)
	{
		$where_arr = array(array("key"=>'section', "value"=>$section_id, "oper"=>'='), array("key"=>'sort', "value"=>$subsection_id, "oper"=>'='));
		$sel = self::$baseC->select('subsections', '', '*', $where_arr, 'AND');
		return $sel[0];
	}
	function get_section($section_id)
	{
		if($section_id == 'all')
		{
			$sel = self::$baseC->select('sections', '', '*');
			return $sel;
		}
		else
		{
			$section_id = (int)$section_id;
			$where_arr = array(array("key"=>'id', "value"=>$section_id, "oper"=>'='));
			$sel = self::$baseC->select('sections', '', '*', $where_arr, 'AND');
			return $sel[0];
		}
	}
	function get_subsection_icon($subsection_id)
	{
		$where_arr = array(array("key"=>'sort', "value"=>$subsection_id, "oper"=>'='), array("key"=>'section', "value"=>'1', "oper"=>'='));
		$sel = self::$baseC->select('subsections', '', 'icon', $where_arr, 'AND');
		return $sel[0]['icon'];
	}
}
?>