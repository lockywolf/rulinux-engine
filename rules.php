<?php
require 'classes/core.php';
$title = ' - Правила сайта';
$rss_link='rss';
require 'header.php';
$rules = $coreC->get_settings_by_name(rules);
require 'themes/'.$theme.'/templates/rules/main.tpl.php';
require 'footer.php';
?>