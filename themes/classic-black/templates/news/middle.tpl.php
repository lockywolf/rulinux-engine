<h2><a href="<?=$thr_link?>" style="text-decoration:none"><?=$subject?></a></h2>
<?if($uinfo['gid']==2 || $uinfo['gid']==3){?>
<div>
<a href="<?=$edit_link?>">Редактировать</a> | 
<a href="<?=$attach_link?>"><?=$attach_text?></a>
</div>
<?}?>
<table cellspacing="0" border="0"><tr><td style="vertical-align:top">
<table>
<tr>
<td style="vertical-align:top"><img src="<?=$subsection_image?>" alt="subsection"></td>
<td style="vertical-align:top">
<?=$comment?>
<?php if ($is_filtered):?><p><strong>Причины фильтрации: <?=$active_filters;?></strong></p><?php endif;?>
</td>
</tr>
</table>
<?=$prooflink?>
<p style="font-style:italic"><?=$author?> (<a href="<?=$author_profile?>">*</a>) (<?=$timestamp?>)</p>[<a href="<?=$thr_link?>"><?=$comments_count?></a>]&nbsp;[<a href="<?=$cmnt_link?>">Добавить комментарий</a>]
<br>
<br>
</td>
</tr>
</table>
<hr>