<?php
require 'classes/core.php';
$user_theme = users::get_user_theme();
$theme = $user_theme['directory'];
$site_name = $_SERVER["HTTP_HOST"];
$title = $site_name.' - Поиск';
$profile_name = $_SESSION['user_name'];
$profile_link = 'profile.php?user='.$_SESSION['user_name'];
$invitation = $_SESSION['user_id'] == 1 ? '<a href="register.php">Регистрация</a> <a href="login.php">Вход</a>' : '<a href="logout.php">Выход</а>';
require 'links.php';
require 'themes/'.$theme.'/templates/header.tpl.php';
if(!empty($_GET['q']))
{
	$search_user = $_GET['username'];
	$search_string = $_GET['q'];
	require 'themes/'.$theme.'/templates/search/form.tpl.php';
	$found_msg = core::search($_GET['q'], $_GET['require'], $_GET['date'], $_GET['section'], $_GET['username']);
	if(!empty($found_msg))
	{
		for($i=0; $i<count($found_msg); $i++)
		{
			$msg_id = $found_msg[$i]['id'];
			$param_arr = array($found_msg[$i]['tid']);
			$sel = base::query('SELECT id FROM comments WHERE tid = \'::0::\' ORDER BY id ASC','assoc_array', $param_arr);
			for($t=0;$t<count($sel);$t++)
			{
				if($sel[$t]['id']==$found_msg[$i]['id'])
					$message_number = $t;
			}
			$page = ceil($message_number/$uinfo['comments_on_page']);
			if($page == 0)
				$page = 1;
			$link = 'message.php?newsid='.$found_msg[$i]['tid'].'&page='.$page.'#'.$found_msg[$i]['id'];
			$subject = $found_msg[$i]['subject'];
			$comment = $found_msg[$i]['comment'];
			$usr = users::get_user_info($found_msg[$i]['uid']);
			$author = $usr['nick'];
			$author_profile = 'profile.php?id='.$usr['nick'];
			$timestamp = core::to_local_time_zone($found_msg[$i]['timest']);
			require 'themes/'.$theme.'/templates/search/msg.tpl.php';
		}
	}
}
else
{
	$search_user ='';
	$search_string = '';
	require 'themes/'.$theme.'/templates/search/form.tpl.php';
}

require 'themes/'.$theme.'/templates/footer.tpl.php';
?>