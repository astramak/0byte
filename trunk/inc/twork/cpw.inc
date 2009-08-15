<?php
$old = request::get_post('old');
$new = request::get_post('new');
if ($old && strlen($new) > 4) {
	if ($usr->pwd == md5($db_salt.$old)) {
		db_query('UPDATE users SET pwd = %s WHERE name = %s', md5($db_salt.$new), $usr->login);
		$lst = "login.php?cur=users.php&un=1";
	} else {
		$lst = "users.php?cpw=1";
	}
} else {
	$lst = "users.php?cpw=2";
}
redirect($lst);
?>