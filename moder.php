<?php
require 'classes/core.php';
$title = ' - Модераторская';
$rss_link='rss';
if($uinfo['gid']!=2 && $uinfo['gid']!=3)
{
	require 'header.php';
	$legend = 'У вас нет полномочий';
	$text = 'Вы не являетесь модератором или администратором на данном сайте';
	require 'themes/'.$theme.'/templates/fieldset.tpl.php';
	require 'footer.php';
	exit();
}
if($_GET['action']=='move_thread')
{
	$tid = (int)$_GET['tid'];
	$move_link = 'move_thread_'.$tid;
	if(!empty($_POST['nxt']))
	{
		require 'header.php';
		$referer = $_POST['referer'];
		$section = (int)$_POST['section'];
		$subsections = $sectionsC->get_subsections($section);
		require 'themes/'.$theme.'/templates/moder/move_thread/sbm/top.tpl.php';
		for($i=0; $i<count($subsections); $i++)
		{
			$subsection_id = $subsections[$i]['sort'];
			$subsection_name = $subsections[$i]['name'];
			require 'themes/'.$theme.'/templates/moder/move_thread/sbm/middle.tpl.php';
		}
		require 'themes/'.$theme.'/templates/moder/move_thread/sbm/bottom.tpl.php';
		require 'footer.php';
		exit();
	}
	else if(!empty($_POST['sbm']))
	{
		$referer = $_POST['referer'];
		$section = (int)$_POST['section'];
		if($section==3)
		{
			require 'header.php';
			$legend = 'Невозможно переместить тред в галлерею';
			$text = 'Вы не можете переместить тред в галлерею. Создайте новый тред в соответствующем разделе.';
			require 'themes/'.$theme.'/templates/fieldset.tpl.php';
			require 'footer.php';
			exit();
		}
		$subsection = (int)$_POST['subsection'];
		$ret = $threadsC->move_thread($tid, $section, $subsection);
		if(empty($ret))
			die('<meta http-equiv="Refresh" content="0; URL='.$referer.'">');
		else
		{
			require 'header.php';
			$legend = 'Ошибка при перемещении';
			$text = 'Произошла ошибка при перемещении треда в указанный раздел.';
			require 'themes/'.$theme.'/templates/fieldset.tpl.php';
			require 'footer.php';
			exit();
		}
	}
	else
	{
		require 'header.php';
		$referer = getenv("HTTP_REFERER");
		$sections = $sectionsC->get_section('all');
		require 'themes/'.$theme.'/templates/moder/move_thread/nxt/top.tpl.php';
		for($i=0; $i<count($sections); $i++)
		{
			$section_id = $sections[$i]['id'];
			$section_name = $sections[$i]['name'];
			if($section_id!=3)
				require 'themes/'.$theme.'/templates/moder/move_thread/nxt/middle.tpl.php';
		}
		require 'themes/'.$theme.'/templates/moder/move_thread/nxt/bottom.tpl.php';
		require 'footer.php';
		exit();
	}
}
else if($_GET['action']=='attach_thread')
{
	$threadsC->attach_thread($_GET['tid'], 'true');
	$referer = getenv("HTTP_REFERER");
	require 'header.php';
	$legend = 'Тред прикреплен';
	$text = 'Тред прикреплен. Если у вас отключена переадресация нажмите <a href="'.$referer.'">сюда</a>.';
	require 'themes/'.$theme.'/templates/fieldset.tpl.php';
	die('<meta http-equiv="Refresh" content="0; URL='.$referer.'">');
}
else if($_GET['action']=='detach_thread')
{
	$threadsC->attach_thread($_GET['tid'], 'false');
	$referer = getenv("HTTP_REFERER");
	require 'header.php';
	$legend = 'Тред откреплен';
	$text = 'Тред откреплен. Если у вас отключена переадресация нажмите <a href="'.$referer.'">сюда</a>.';
	require 'themes/'.$theme.'/templates/fieldset.tpl.php';
	die('<meta http-equiv="Refresh" content="0; URL='.$referer.'">');
}
else if($_GET['action']=='approve_thread')
{
	$threadsC->approve_thread($_GET['tid']);
	$referer = getenv("HTTP_REFERER");
	require 'header.php';
	$legend = 'Тред подтвержден';
	$text = 'Тред подтвержден. Если у вас отключена переадресация нажмите <a href="'.$referer.'">сюда</a>.';
	require 'themes/'.$theme.'/templates/fieldset.tpl.php';
	die('<meta http-equiv="Refresh" content="0; URL='.$referer.'">');
}
else
{
	require 'header.php';
	$legend = 'Неизвестное действие';
	$text = 'Неизвестное действие';
	require 'themes/'.$theme.'/templates/fieldset.tpl.php';
	require 'footer.php';
	exit();
}
?>