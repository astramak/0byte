<?php
$nick = request::get_post('nick',0);
if (!$nick) {
    echo render_template(TPL_FRAMES.'/restore.tpl.php', null);
} else {
$alien = new user();
if ($nick && $alien->looser(gtext($nick))) {
	$psw = nullbute_generate_pwd(8);
        if (db_result(db_query('SELECT COUNT(*) FROM `restore` WHERE `user` = %s',$nick))>=1) {
            db_query('DELTE FROM `restore` WHERE `user` = %s LIMIT 1',$nick);
        }
        $code=md5(time().$nick);
        db_query('INSERT INTO `restore` SET `user` = %s , `code` = %s , `pwd` = %s',$nick,$code,$psw);
	$to = $alien->mail;
	$subject = "Восстановление пароля";
	$message = render_mail('restore_pwd', array(
		'user' => $alien->login,
		'ld' => $code,
		'psw' => $psw,
	));
	$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
	nullbyte_mail($to, $subject, $message, true, $headers);

	echo "<h2>Проверьте свою электронную почту!</h2>";
}
}
?>