<?php
$filename = 'blocks/'.$directory.'/templates/top.tpl.php';
$file = fopen($filename, "r") or die("Can't open file!");
$boxlet_content = fread($file, filesize($filename));
fclose($file); 
$msg = messages::get_messages_for_tracker(1, True);;
if (!empty($msg))
{
	$user_filter = $usersC->get_filter($_SESSION['user_id']);
	$user_filter_arr = $filtersC->parse_filter_string($user_filter);
	for($z=0; $z<count($msg); $z++)
	{
		$filename = 'blocks/'.$directory.'/templates/message.tpl.php';
		$file = fopen($filename, "r") or die("Can't open file!");
		$boxlet_content = $boxlet_content.fread($file, filesize($filename));
		fclose($file); 
		$subj = substr($msg[$z]['subject'], 0, 128);
		if ($messagesC->is_filtered($user_filter_arr, $msg[$z]['filters']))
		{
			$subj = 'Сообщение отфильтровано';
			$comment = 'Сообщение отфильтровано в соответствии с вашими настройками фильтрации. <br>Чтобы прочесть это сообщение отключите фильтр в профиле или нажмите <a href="message_'.$msg[$z]['id'].'">сюда</a><br>';
		}
		else
		{
			$comment = $coreC->truncate($msg[$z]['comment'], 255);
			$re = '/<img src="((?!").*?)" (width="[0-9]+ ")?((?!>).*?)>/suim';
			$comment = preg_replace($re, "<img src=\"big2small.php?size=200&pixmap=\$1\" width=\"200\" \$3>", $comment);
			$subj = substr($msg[$z]['subject'], 0, 128);
		}

		$boxlet_content = str_replace('[subject]', $subj, $boxlet_content);
		$boxlet_content = str_replace('[comment]', $comment, $boxlet_content);
		$boxlet_content = str_replace('[author]', $msg[$z]['nick'], $boxlet_content);
		$message_number = threads::get_msg_number_by_tid($msg[$z]['tid'], $msg[$z]['id']);
		$page = ceil($message_number/$uinfo['comments_on_page']);
		if($page == 0)
			$page = 1;
		$link = 'thread_'.$msg[$z]['tid'].'_comment_'.$msg[$z]['id'].'#msg'.$msg[$z]['id'];
		$boxlet_content = str_replace('[link]', $link, $boxlet_content);
	}
}
$boxlet_content = str_replace('[title]', $name, $boxlet_content);
?>