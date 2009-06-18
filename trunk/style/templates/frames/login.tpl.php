<div id="login">
	<div id="lgn">
		<form name="ta" method="post"
			  action="login.php?cur=<?php echo $current; ?>">
			<table border="0">
				<tr>
					<td>Логин:</td>
					<td><input type="text" name="login" /></td>
				</tr>
				<tr>
					<td>Пароль:</td>
					<td><input type="password" name="pwd" /></td>
				</tr>
				<tr>
					<td>Запомнить:</td>
					<td><input type="checkbox" name="zap" value="1" /></td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Войти" /> <?php
						if ($js) {
							?><input type='button' onblur='onBlur(this)' onfocus='onFocus(this)' onclick='unlogin()' value='Вернуться' />
					<?php }	?></td>
				</tr>
			</table>
		</form>
		<?php if ($new) { ?>
		<b>Перед входом активируйте свою учётную запись, для этого проверьте свою электронную почту и пройдите по полученной ссылке!</b>
		<?php } else { ?>
		<a href='register'>Зарегистрироваться</a>
		<?php }
		if (!$js) {
			?>
		<br />
	</div>
</div>
<?php } ?>
