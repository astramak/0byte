<div id="login">
	<div id="lgn">
		<form name="ta" method="post"
			  action="login.php?cur=<?php echo $current; ?>">
	<table>
	<tr>
	<td>
	<span class="grey">логин</span><br>
	<input type="text" name="login" tabindex="1"/><br>
	<a href='register'>регистрация</a><br>
    </td>
    <td>
	<span class="grey">пароль</span><br>
	<input type="password" name="pwd" tabindex="2"/><br>
    <a href="looz/">восстановление</a>

	</td></tr></table>
	<br><input type="checkbox" name="zap" value="1" /><span class="grey">помнить меня</span><br><br>
			
	<input type="submit" value="Войти" class="tag_w7" tabindex="3" /> <?php
						if ($js) {
							?><input type='button' onblur='onBlur(this)' onfocus='onFocus(this)' onclick='unlogin()' value='&larr; Вернуться' class="tag_w4"/>
					<?php }	?>

		</form>
		<br/>
		<?php if ($new) { ?>
		<b>Перед входом активируйте свою учётную запись, для этого проверьте свою электронную почту и пройдите по полученной ссылке!</b>
		<?php } else { ?>
		<?php }
		if (!$js) {
			?>
		<br />
	</div>
</div>
<?php } ?>
