<?php
session_start();
function timeMeasure()
{
    list($msec, $sec) = explode(chr(32), microtime());
    return ($sec+$msec);
}
define('TIMESTART', timeMeasure());
if (get_magic_quotes_gpc()) 
{
	function stripslashes_deep($value)
	{
		$value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
		return $value;
	}
	$_POST = array_map('stripslashes_deep', $_POST);
	$_GET = array_map('stripslashes_deep', $_GET);
	$_COOKIE = array_map('stripslashes_deep', $_COOKIE);
}
/* Constants */
define('NEWS_SECTION_ID', 1);
define('ARTICLES_SECTION_ID', 2);
define('GALLERY_SECTION_ID', 3);
define('FORUM_SECTION_ID', 4);
define('FILTERED_HEADING', 'Сообщение отфильтровано в соответствии с вашими настройками фильтрации');
define('FILTERED_TEXT', 'Это сообщение отфильтровано в соответствии с вашими настройками фильтрации. <br />Для того чтобы прочесть это сообщение отключите фильтр в профиле или нажмите');

require_once 'librarys/geshi/geshi.php';
require_once 'librarys/phpmathpublisher/mathpublisher.php';
require_once 'librarys/simpleopenid/class.openid.php';
require_once 'classes/base/base_interface.php';
require_once "classes/config.class.php";
config::include_database();
require_once "classes/object.class.php";
require_once "classes/core.class.php";
$coreC = new core;
$installed = $coreC->is_installed();
if(!$installed)
{
	echo '<html lang="ru"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>Проведите <a href="install/install.php">первичную инициализацию</a>. <br><b>ВНИМАНИЕ:</b> при проведении первичной нинциализации все данные из базы будут удалены<br>Если вы уже проводили первичную инициализацию, но по-прежнему видите это сообщение, то выствите в файле config/install.ini значение 1 параметру installed.</html>';
	exit;
}
require_once "classes/templates.class.php";
// $templatesC = new templates;
require_once "classes/search.class.php";
$searchC = new search;
require_once "classes/users.class.php";
$usersC = new users;
require_once "classes/auth.class.php";
$authC = new auth;
$uinfo = $usersC->get_user_info($_SESSION['user_id']);
require_once "classes/latex.class.php";
require_once "classes/mark.class.php";
$markC = new mark;
$mark_file = $markC->get_mark_file($uinfo['mark']);
require_once 'mark/'.$mark_file;
require_once "classes/filters.class.php";
$filtersC = new filters;
require_once "classes/sections.class.php";
$sectionsC = new sections;
require_once "classes/threads.class.php";
$threadsC = new threads;
require_once "classes/messages.class.php";
$messagesC = new messages;
require_once "classes/faq.class.php";
$faqC = new faq;
require_once "classes/security.class.php";
$security = new Security($_SERVER['DOCUMENT_ROOT'].'/config/security.ini');
require 'classes/rss.class.php';
$rssC = new rss;
require 'ucaptcha/ucaptcha.php';
$captchaC = new ucaptcha;
?>