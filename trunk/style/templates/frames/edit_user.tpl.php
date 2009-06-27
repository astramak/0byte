<h3>Редактирование профиля <?php echo $login; ?></h3>
<form name="aa" method="post" action="twork.php?wt=edituser">
<table border="0">
<tr>
		<td>E-mail</td>
		<td><input type="text" name="mail"
			value="<?php echo $mail; ?>" /><br />
		<label><input name="hml" type="checkbox"
		<?php echo $show_mail; ?> />Скрыть</label></td>
	</tr>
	<tr>
		<td>icq</td>
		<td><input type="text" name="icq"
			value="<?php echo $icq; ?>" /></td>
	</tr>
	<tr>
		<td>jabber</td>
		<td><input type="text" name="jabber"
			value="<?php echo $jabber; ?>" /></td>
	</tr>
	<tr>
		<td>Город</td>
		<td><input type="text" name="city"
			value="<?php echo $city; ?>" /></td>
	</tr>
	<tr>
		<td>Сайт</td>
		<td><input type="text" name="site"
			value="<?php echo $site; ?>" /></td>
	</tr>
	<tr>
		<td>О себе</td>
		<td><textarea rows="5" cols="30" name="about"><?php echo $about; ?></textarea></td>
	</tr>
	<tr>
		<td>Оповещение:</td>
		<td><label><input name="pr" type="checkbox"
		<?php echo $post_reply ?> />Об ответах на посты</label>
		<label><input name="cr" type="checkbox"
		<?php echo $comment_reply; ?> />Об ответах на
		комментарии</label> <label><input name="pmr" type="checkbox"
		<?php echo $pm_reply; ?> />О личных сообщения</label>
		</td>
	</tr>
	<tr>
		<td>Статус</td>
		<td><select name='juse'>
			<option value="0">Нет</option>
			<option <?php echo $juick; ?> value="1">Juick</option>
			<option <?php echo $twitter; ?>value="2">Twitter</option>
		</select> <label><input type='text' name='jname'
			value="<?php echo $micro_name; ?>" /></label>

</table>
<input type="submit" value="Править!" /></form>
Аватар:
<form method="post" enctype="multipart/form-data"
	action="twork.php?wt=img"><input type="file" name="img" /> <input
	type="submit" value="Загрузить" /></form>
    <?php
    if ($error) {
    ?>
    <i>Неправильные данные!</i>
    <?php } ?>