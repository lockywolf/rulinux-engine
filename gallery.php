<?php
$subsection_id = (int)$_GET['id'];
$_GET['page'] > 1 ? $page = (int)$_GET['page'] : $page=1;
require 'classes/core.php';
$subsect_arr = $sectionsC->get_subsection(3, $subsection_id);
$sect_arr = $sectionsC->get_section(3);
$recomendations = $subsect_arr['shortfaq'];
$section_name = $sect_arr['name'];
$section_id = 3;
$subsection_name = $subsect_arr['name'];
$subsection_description = $subsect_arr['description'];
$title = ' - '.$section_name.' - '.$subsection_name;
$rss_link='rss_from_sect_'.$section_id.'_subsect_'.$subsection_id;
require 'header.php';
$section_link = 'gallery';
$add_link = 'new_thread_in_sect_'.$section_id.'_subsect_'.$subsection_id;
$form_link_begin = 'gallery_';
$form_link_end = '_page_1';
require 'themes/'.$theme.'/templates/gallery/nav_top.tpl.php';
$subsct = $sectionsC->get_subsections(3);
for($i=0; $i<count($subsct);$i++)
{
	$subsection_nav_name = $subsct[$i]['name'];
	$subsection_nav_id = $subsct[$i]['sort'];
	if($subsection_id==$subsection_nav_id)
		$selected_nav = 'selected';
	else
		$selected_nav = '';
	require 'themes/'.$theme.'/templates/gallery/nav_middle.tpl.php';
}
require 'themes/'.$theme.'/templates/gallery/nav_bottom.tpl.php';

require 'themes/'.$theme.'/templates/gallery/top.tpl.php';
$threads_count = $threadsC->get_threads_count($section_id, $subsection_id);
$threads_on_page = $uinfo['threads_on_page'];
$pages_count = ceil(($threads_count)/$threads_on_page);
$pages_count>1 ? $begin=$threads_on_page*($page-1) : $begin = 0;
if($pages_count > 1)
{
    $pages = '';
	if($page>1)
	{
		$pg = $page-1;
		$pages = $pages.'<a href="gallery_'.$subsection_id.'_page_1" title="В начало">←</a>&nbsp;';
		$pages = $pages.'<a href="gallery_'.$subsection_id.'_page_'.$pg.'" title="Назад">≪</a>&nbsp;';
	}
	if($pages_count>10)
	{
		if($page<5)
			$start_page = 1;
		else
			$start_page = $page-4;
			
		if($page>$pages_count-4)
			$end_page = $pages_count;
		else
			$end_page = $page+4;
		for($p=$start_page; $p<=$end_page; $p++)
		{
			if ($p == $page)
				$pages = $pages.'<b>'.($p).'</b>&nbsp;';
			else
				$pages = $pages.'<a href="gallery_'.$subsection_id.'_page_'.$p.'" title="Страница №'.$p.'">'.($p).'</a>&nbsp;';
		}
	}
	else
	{
		for($p=1; $p<=$pages_count; $p++)
		{
			if ($p == $page)
				$pages = $pages.'<b>'.($p).'</b>&nbsp;';
			else
				$pages = $pages.'<a href="gallery_'.$subsection_id.'_page_'.$p.'" title="Страница №'.$p.'">'.($p).'</a>&nbsp;';
		}
	}
	if($page<$pages_count)
	{
		$pg = $page+1;
		$pages = $pages.'<a href="gallery_'.$subsection_id.'_page_'.$pg.'" title="Вперед">≫</a>&nbsp;';
		$pages = $pages.'<a href="gallery_'.$subsection_id.'_page_'.$pages_count.'" title="В конец">→</a>&nbsp;';
	}
}
$user_filter = $usersC->get_filter($_SESSION['user_id']);
$user_filter_arr = $filtersC->parse_filter_string($user_filter);
$user_filter_list = $filtersC->get_filter_list($user_filter);
$gal = $threadsC->get_gallery($subsection_id, $begin, $threads_on_page);
for($i=0; $i<count($gal); $i++)
{
	$comment_id = $gal[$i]['cid'];
	$filter_list = $filtersC->get_filter_list($gal[$i]['filters']);
	$active_filters = $filtersC->get_active_filters($filter_list, $user_filter_list);
	$is_filtered = $messagesC->is_filtered($user_filter_arr, $gal[$i]['filters']);
	$subject = $gal[$i]['subject'];
	$comment = $gal[$i]['comment'];
	$size = $gal[$i]['image_size'].', '.$gal[$i]['file_size'];
        $img_link = 'images/gallery/'.$gal[$i]['file'].'.'.$gal[$i]['extension'];
        $img_thumb_link = 'images/gallery/thumbs/'.$gal[$i]['file'].'_small.png';
	$usr = $usersC->get_user_info($gal[$i]['uid']);
	$coreC->validate_boolean($usr['banned']) ? $author = '<s>'.$usr['nick'].'</s>' : $author = $usr['nick'];
	$author_profile = 'user_'.$usr['nick'];
	$timestamp = $coreC->to_local_time_zone($gal[$i]['timest']);
	$thread_id = $gal[$i]['id'];
	$count = $threadsC->get_comments_count($thread_id);
	$comments_count = $coreC->declOfNum($count, array('сообщение', 'сообщения', 'сообщений'));
	$edit_link = 'message_'.$comment_id.':edit';
	if($coreC->validate_boolean($gal[$i]['attached']))
	{
		$attach_link = 'detach_thread_'.$thread_id;
		$attach_text = 'Открепить';
	}
	else
	{
		$attach_link = 'attach_thread_'.$thread_id;
		$attach_text = 'Прикрепить';
	}
	$thr_link = 'thread_'.$thread_id.'_page_1';
	$cmnt_link = 'comment_into_'.$thread_id.'_on_'.$comment_id;
	require 'themes/'.$theme.'/templates/gallery/middle.tpl.php';
}
require 'themes/'.$theme.'/templates/gallery/bottom.tpl.php';
require 'footer.php';
?>