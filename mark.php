<?php
require 'classes/core.php';
if(!empty($_GET['id']))
	$mark_id = (int)$_GET['id'];
else
	$mark_id = $uinfo['mark'];
$mark_info = mark::get_mark_info($mark_id);
$mark_name = $mark_info['name'];
$title = ' - Разметка '.$mark_name;
$rss_link='view-rss.php';
require 'header.php';
echo '<h2>Разметка '.$mark_name.'</h2>';
echo $mark_info['description'];
echo '<br /><br />';
$langs = $coreC->get_settings_by_name('langs');
echo $langs;
echo '<br />';
require 'footer.php';
?>