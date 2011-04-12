<?php
require 'classes/core.php';
$title = '';
if(isset($_GET['logout']))
{
	$_SESSION['user_id']='';
	$_SESSION['user_admin']='';
	$_SESSION['user_moder']='';
	$_SESSION['user_name']='';
	setcookie('login', '', time()-3600);
	setcookie('password', '', time()-3600);
	session_destroy();
	die('<meta http-equiv="Refresh" content="0; URL=http://'.$_SERVER['HTTP_HOST'].'">');
}
else
{
	if($_SESSION['user_id']!= 1)
	{
		require 'header.php';
		$legend = 'Вы уже авторизованны на сайте';
		$text = 'Вы уже авторизованны на сайте. Если вы хотите войти под другим ником, То вам необходимо <a href="login.php?logout">разлогиниться</a>';
		require 'themes/'.$theme.'/templates/fieldset.tpl.php';
		require 'footer.php';
		exit();
	}
	if(!empty($_POST['login']))
	{
		if(isset($_POST['user']) && isset($_POST['password']))
		{
			$_POST['user'] = preg_replace('/[\'\/\*\s]/', '', $_POST['user']);
			auth_user($_POST['user'], $_POST['password'], false);
		}
		die('<meta http-equiv="Refresh" content="0; URL=http://'.$_SERVER['HTTP_HOST'].'">');  
	}
	else
	{
		require 'header.php';
		include 'themes/'.$theme.'/templates/login/form.tpl.php';
		require 'footer.php';
	}
}
?>