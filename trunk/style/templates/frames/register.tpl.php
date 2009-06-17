<div id="golog">
	<h3>Регистрация</h3>
    <?php
    if ($error>0) {
     ?>
     <span class='err'>
     <?php
	if ($error==1) {
		?> Пользователь с таки именем уже существует!<?php
	} elseif ($error==3) {
		?>Капча введена не правильно, вы бот?<?php
	} elseif ($error==2) {
		?>Не все поля заполнены, либо вы используюте спец. символы!<?php
	}
    ?>
    </span>
    <?php
    }
	?>
<p>Поля, помеченные <span class="required">*</span> обязательны для заполнения!</p>
	<form method="post" action="register.php?reg" id="reg">
		<table border="0">
			<tr>
				<td>Логин <div class="required" id='clogin'>*</div></td>
				<td><input type="text" name="login" onkeyup="chka(this,'login')" value='<?php echo request::get_post('login') ?>' /></td>
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
    <br />
    После регистрации на вашу электронную почту придёт письмо для подтверждения регистрации.
    <?php } ?>
</div>