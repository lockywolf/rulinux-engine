<?php
require 'classes/core.php';
$rss_link='rss';
$title = ' - Ссылки на дружественные ресурсы и на ресурсы по смежной теме'.$mark_name;
require 'header.php';
$links = $coreC->get_links();
require 'themes/'.$theme.'/templates/links/top.tpl.php';
for($s=0; $s<count($links); $s++)
{
	$link_name = $links[$s]['name'];
	$link = $links[$s]['link'];
	require 'themes/'.$theme.'/templates/links/middle.tpl.php';
	
}
require 'themes/'.$theme.'/templates/links/bottom.tpl.php';
require 'footer.php';
?>