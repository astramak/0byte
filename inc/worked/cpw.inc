<?php 
//<h3>Смена пароля <?php echo $usr->login; ?\></h3>
//<form name="aa" method="post" action="twork.php?wt=cpw">
//<table border='0'>
//	<tr>
//		<td>Старый пароль</td>
//		<td><input type="password" name='old' /></td>
//	</tr>
//	<tr>
//		<td>Новый пароль</td>
//		<td><input type="password" name='new' /></td>
//	</tr>
//</table>
//<input type="submit" value="Сменить" /></form>
echo render_change_password($usr->login);
?>