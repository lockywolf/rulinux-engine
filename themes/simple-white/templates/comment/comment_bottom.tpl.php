</td>
</tr>
<tr>
<td></td>
<td>
<?=$captcha?>
<p class="error"><?=$errors['captcha'];?></p>
</td>
</tr>
<tr>
<td></td>
<td>
<input type="submit" value="Поместить" name="sbm">
<input type="submit" value="Предпросмотр" name="sbm">
</td>
</tr>
<tr>
<td></td>
<td>
<div style="display:none">Пользователям браузеров без CSS: Поле для проверки, заполнять НЕ НАДО: </div>
<input type="text" name="user_field" style="display:none" value="<?=$user_field?>"><br>
<p class="error"><?=$errors['user_field'];?></p>
</td>
</tr>
</table>
</form>

