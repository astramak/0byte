<?php
if (isset($_GET['nick'])) {
	$alien = new user();
	$psw = nullbute_generate_pwd(8);
	if ($alien->looser(gtext($_GET['nick']))) {
		$to = $alien->mail;
		$subject = "Восстановление пароля";
		$message = "Для продолжения восстановления пароля перейдите <a href='" . $site . "all.php?wt=chpwd&user=".$alien->login."&id=".$alien->pwd
			."&ld=".md5($psw)."'>по этой ссылку</a>\n Ваш новый пароль:\n".$psw;
		$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
		nullbyte_mail($to, $subject, $message, true, $headers);

		echo "<h2>Проверьте свою электронную почту!</h2>";
	}
}
?>