<tr>
<?if($uinfo['gid']==2 || $uinfo['gid']==3){?>
<td align = center>
<a href="<?=$thread_move_link?>"><img border="0" src="themes/<?=$theme?>/move.png" alt="[Переместить]"></a>
<a href="<?=$thread_attach_link?>"><img border="0" src="themes/<?=$theme?>/attach.png" alt="[Прикрепить]"></a>
</td>
<?}?>
<td><?=$attached?><a href="<?=$thr_link?>"<?php if ($is_filtered):?> title="Причины фильтрации: <?=$active_filters;?>"<?php endif;?>><?=$thread_subject?></a> (<?=$thread_author?>)</td>
<td align=center><b><?=$comments_in_thread_all?></b>/<b><?=$comments_in_thread_day?></b>/<b><?=$comments_in_thread_hour?></b></td>
</tr>
