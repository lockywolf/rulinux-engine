<?
$message_id = (int)$_GET['id'];
include 'classes/core.php';
$user_theme = users::get_user_theme();
$theme = $user_theme['directory'];
$site_name = $_SERVER["HTTP_HOST"];
$title = 'Установить фильтр на сообщение';
include 'links.php';
include 'themes/'.$theme.'/templates/header.tpl.php';
echo '<br>';
$msg = messages::get_message($message_id);
$msg_resp = messages::get_message($msg['referer']);
$message_resp_title = $msg_resp['subject'];
$message_resp_timestamp = $msg_resp['timest'];
$msg_resp_autor = users::get_user_info($msg_resp['uid']);
$message_resp_user = $msg_resp_autor['nick'];
$message_resp_link = 'message.php?newsid='.$thread_id.'#'.$msg['referer'];
$message_subject = $msg['subject'];
$message_comment = $msg['comment'];
$msg_autor = users::get_user_info($msg['uid']);
$message_autor = $msg_autor['nick'];
$message_autor_profile_link = '/profile.php?user='.$message_autor;
if(in_array($msg['show_ua'], $false_arr))
	$message_useragent = '';
else
	$message_useragent = $msg['useragent'];
$message_timestamp = $msg['timest'];
$message_add_answer_link = 'comment.php?answerto='.$thread_id.'&cid='.$message_id;
$message_avatar = empty($msg_autor['photo'])? 'themes/'.$theme.'/empty.gif' : 'avatars/'.$msg_autor['photo'];
include 'themes/'.$theme.'/templates/message/message.tpl.php';
include 'themes/'.$theme.'/templates/footer.tpl.php';
?>