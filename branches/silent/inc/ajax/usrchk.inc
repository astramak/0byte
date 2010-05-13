<?php
header("Content-Type: text/html; charset=utf-8");
$login = request::get_get('login');
$mail = request::get_get('mail');
$cap = request::get_get('cap');

if ($login && chud($login) ) {
	$exists = db_result(db_query('SELECT id FROM users WHERE name = %s', $login));
	if (!$exists) {
		echo '{"val" : "true"}';
	} else {
		echo '{"val" : "false"}';
	}
} elseif ($mail && chml($mail)) {
	$exists = db_result(db_query('SELECT id FROM users WHERE mail = %s', $mail));
	if (!$exists) {
		echo '{"val" : "true"}';
	} else {
		echo '{"val" : "false"}';
	}
} elseif ($cap) {
// TODO: move to function that returns bool
	session_start();
	$a=md5(session_id());
	$a1=ord($a[2]);
	$a2=ord($a[4]);
	$zn=ord($a[6]);

	while ($a1>15) {$a1=$a1-10; }
	while ($a2>15) {$a2=$a2-10; }

	if ($zn%2==0) { $res=$a1+$a2;}
	elseif ($zn%3==0) { $res=$a1*$a2; }
	else { $res=$a1-$a2; }

	if ($cap == $res) {
		echo '{"val" : "true"}';
	} else {
		echo '{"val" : "false"}';
	}
}
?>