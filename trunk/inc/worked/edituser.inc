<h3>Редактирование профиля <?php echo $usr->login; ?></h3>
<form name="aa" method="post" action="twork.php?wt=edituser">
<table border="0">
<?php
$usr->find($usr->login);
?>
	<tr>
		<td>E-mail</td>
		<td><input type="text" name="mail"
			value="<?php echo trim($usr->mail); ?>" /><br />
		<label><input name="hml" type="checkbox"
		<?php if ($usr->hml==1) {echo "checked ";} ?> />Скрыть</label></td>
	</tr>
	<tr>
		<td>icq</td>
		<td><input type="text" name="icq"
			value="<?php echo trim($usr->icq); ?>" /></td>
	</tr>
	<tr>
		<td>jabber</td>
		<td><input type="text" name="jabber"
			value="<?php echo utext(trim($usr->jabber)); ?>" /></td>
	</tr>
	<tr>
		<td>Город</td>
		<td><input type="text" name="city"
			value="<?php echo utext(trim($usr->city)); ?>" /></td>
	</tr>
	<tr>
		<td>Сайт</td>
		<td><input type="text" name="site"
			value="<?php echo utext(trim($usr->site)); ?>" /></td>
	</tr>
	<tr>
		<td>О себе</td>
		<td><textarea rows="5" cols="30" name="about"><?php echo utext(trim($usr->about)); ?></textarea></td>
	</tr>
	<tr>
		<td>Оповещение:</td>
		<td><label><input name="pr" type="checkbox"
		<?php if ($usr->pr==1) {echo "checked ";} ?> />Об ответах на посты</label>
		<label><input name="cr" type="checkbox"
		<?php if ($usr->cr==1) {echo "checked ";} ?> />Об ответах на
		комментарии</label> <label><input name="pmr" type="checkbox"
		<?php if ($usr->pmr==1) {echo "checked ";} ?> />О личных сообщения</label>
		</td>
	</tr>
	<tr>
		<td>Статус</td>
		<td><select name='juse'>
			<option value="0">Нет</option>
			<option <?php if ($usr->g_j()==1) {echo "selected";} ?> value="1">Juick</option>
			<option <?php if ($usr->juse==2) {echo "selected";} ?> value="2">Twitter</option>
		</select> <label><input type='text' name='jname'
			value="<?php if ($usr->juse!=0) {echo $usr->jname;} else { echo "Ник в микроблоге";} ?>" /></label>

</table>
<input type="submit" value="Править!" /></form>
Аватар:
<form method="post" enctype="multipart/form-data"
	action="twork.php?wt=img"><input type="file" name="img" /> <input
	type="submit" value="Загрузить" /></form>
<?php
if ($_GET['err']==1) {
	echo "<i>Неправильные данные!</i>";
}
?>