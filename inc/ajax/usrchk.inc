<?php
$login = request::get_get('login');
$mail = request::get_get('mail');
$cap = request::get_get('cap');

if ($login && chud($login) ) {
	$sql_get="SELECT * FROM `users` WHERE name = '".mysql_escape_string($login)."'   ";
	$result=mysql_query($sql_get,$GLOBALS['sql']);
	$row = mysql_fetch_assoc($result);
	if (strlen($row['name'])!=strlen($login)) {
		echo '
		{
		"val" : "true"
		}
		';
	} else {
		echo '
		{
		"val" : "false"
		}
		';
	}
} elseif ($mail && chml($mail)) {
	$sql_get="SELECT * FROM `users` WHERE mail = '".mysql_escape_string($mail)."'   ";
	$result=mysql_query($sql_get,$GLOBALS['sql']);
	$row = mysql_fetch_assoc($result);
	if (strlen($row['mail'])!=strlen($mail) ) {
		echo '
		{
		"val" : "true"
		}
		';
	} else {
		echo '
		{
		"val" : "false"
		}
		';
	}
} elseif ($cap) {
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
		echo '
		{
		"val" : "true"
		}
		';
	} else {
		echo '
		{
		"val" : "false"
		}
		';
	}
}
?>