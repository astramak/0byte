<div id="golog">
	<h3>Регистрация</h3>
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
	<p>Поля, помеченные <span class="required">*</span> обязательны для заполнения!</p>
	<form method="post" action="register.php?reg" id="reg">
		<table border="0">
			<tr>
				<td>Логин <div class="required" id='clogin'>*</div></td>
				<td><input type="text" name="login" onkeyup="chka(this,'login')" value='<?php echo $reg_login ?>' /></td>
			</tr>
			<tr>
				<td>Пароль <div class="required" id='pwd'>*</div></td>
				<td><input type="password" name="pwd" onkeyup="chkpwd(this.form)"  /></td>
			</tr>
			<tr>
				<td>Повтор <div class="required" id='pwd2'>*</div></td>
				<td><input type="password" name="pwd2" onkeyup="chkpwd(this.form)" /></td>
			</tr>
			<tr>
				<td>E-mail <div class="required" id='cmail'>*</div></td>
				<td><input type="text" name="mail" onkeyup="chka(this,'mail')" value='<?php echo $reg_mail; ?>' /></td>
			</tr>
			<tr>
				<td>ICQ</td>
				<td><input type="text" name="icq" value='<?php echo $reg_icq; ?>' /></td>
			</tr>
			<tr>
				<td>Jabber</td>
				<td><input type="text" name="jabber" value='<?php echo $reg_jabber; ?>' /></td>
			</tr>
			<tr>
				<td>Сайт</td>
				<td><input type="text" name="site" value='<?php echo $reg_site; ?>' /></td>
			</tr>
			<tr>
				<td>О себе</td>
				<td><textarea name="about" rows="5" cols="30"><?php echo $reg_about; ?></textarea></td>
			</tr>
			<tr>
				<td>
					<img src="cap/kap.php?rand=<?php echo rand(); ?>" alt="капча" onclick="this.src='cap/kap.php?rand='+Math.random()" />
					<div class="required" id='ccap'>*</div>
				</td>
				<td><input type="text" name="kap" onkeyup="chka(this,'cap')" /></td>
			</tr>
			<tr>
				<td>&nbsp;</td>
				<td><input type="submit" value="Регистрироваться!" /></td>
			</tr>
		</table>
	</form>
	<?php if ($email_register) { ?>
    <p>После регистрации на вашу электронную почту придёт письмо для подтверждения регистрации.</p>
	<?php } ?>
</div>