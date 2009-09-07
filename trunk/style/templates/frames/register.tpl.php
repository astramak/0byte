<div id="golog">
	<br/><br/><span class='title'>Регистрация</span><br>
	Заполняя эти поля, вы подтверждаете, что прочитали <a href="http://welinux.ru/all/ar">наши правила</a><br/><br/>
	<?php if ($error) { ?>
	<span class='err'>
			<?php
			switch ($error) {
				case 1: echo 'Пользователь с таки именем уже существует!'; break;
				case 2: echo 'Не все поля заполнены, либо вы используюте спец. символы'; break;
				case 3: echo 'Капча введена не правильно. Вы бот?'; break;
			}
			?>
    </span>
	<?php } ?>
	<form method="post" action="register.php" id="reg">
		<table border="0">
			<tr>
				<td>Логин</td>
				<td><input type="text" name="login" onkeyup="chka(this,'login')" value='<?php echo $reg_login ?>' /></td>
			</tr>
			<tr>
				<td>Пароль</td>
				<td><input type="password" name="pwd" onkeyup="chkpwd(this.form)"  /></td>
			</tr>
			<tr>
				<td>Ещё раз</td>
				<td><input type="password" name="pwd2" onkeyup="chkpwd(this.form)" /></td>
			</tr>
			<tr>
				<td>E-mail</td>
				<td><input type="text" name="mail" onkeyup="chka(this,'mail')" value='<?php echo $reg_mail; ?>' /></td>
			</tr>

			<tr>
				<td>
					<img src="cap/kap.php?rand=<?php echo rand(); ?>" alt="капча" onclick="this.src='cap/kap.php?rand='+Math.random()" />
				</td>
				<td><input type="text" name="kap" onkeyup="chka(this,'cap')" /></td>
			</tr>
			<tr>
                        <input type="hidden" name="reg" value="1" />
				<td>&nbsp;</td>
				<td><input type="submit" value="Зарегистрироваться!" /></td>
			</tr>
		</table>
	</form>
	<?php if ($email_register) { ?>
    <p>После регистрации на вашу электронную почту придёт письмо для подтверждения регистрации.</p>
<br><br>
<a href="login.php">Я передумал, мне на самом деле войти надо</a>
	<?php } ?>
</div>