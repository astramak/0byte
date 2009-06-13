<?php
$nick = request::get_get('nick');

$alien = new user();
if ($nick && $alien->looser(gtext($nick))) {
	$psw = nullbute_generate_pwd(8);

	$to = $alien->mail;
	$subject = "Восстановление пароля";
	$message = render_mail('restore_pwd', array(
		'user' => $alien->login,
		'pwd' => $alien->pwd,
		'ld' => md5($psw),
		'psw' => $psw,
	));
	$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
	nullbyte_mail($to, $subject, $message, true, $headers);

	echo "<h2>Проверьте свою электронную почту!</h2>";
}
?>