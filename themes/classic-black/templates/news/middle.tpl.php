<h2><a href="message.php?newsid=<?=$thread_id?>&page=1" id="newsheader" style="text-decoration:none"><?=$subject?></a></h2>
<div>
<a href="admin.php?mod=news&action=edit&eid=31925" target="_blank" id="otherlinks">Редактировать</a> | 
<a href="moder.php?action=attach_thread&tid=<?=$thread_id?>">Прикрепить</a>
</div>
<table cellspadding="0" cellspacing="0" border="0"><tr><td style="vertical-align:top">
<table>
<tr>
<td style="vertical-align:top"><img src="<?=$subsection_image?>"></td>
<td style="vertical-align:top"><p><p><?=$comment?></p></p>
</td>
<tr>
</table>
<p style="font-style:italic"><?=$author?> (<a href="<?=$author_profile?>">*</a>) (<?=$timestamp?>)</p>[<a href="message.php?newsid=<?=$thread_id?>&page=1" id="more-1"><?=$comments_count?></a>]&nbsp;[<a href="comment.php?answerto=<?=$thread_id?>&cid=<?=$comment_id?>" id="more-1">Добавить комментарий</a>]
<br>
<br>
</td>
</tr>
</table>
<hr>