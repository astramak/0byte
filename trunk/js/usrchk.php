<?php
include("../cfg.php");
if (isset($_GET['login']) && chud($_GET['login']) ) {
	$sql_get="SELECT * FROM `users` WHERE name = '".mysql_escape_string($_GET['login'])."'   ";
	$result=mysql_query($sql_get,$GLOBALS['sql']);
	$row = mysql_fetch_assoc($result);
	if (strlen($row['name'])!=strlen($_GET['login'])) {
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
} else if(isset($_GET['mail']) && chml($_GET['mail']) && ( strrpos($_GET['mail'],"@") !=0) && ( strrpos($_GET['mail'],".") !=0)) {
	$sql_get="SELECT * FROM `users` WHERE mail = '".mysql_escape_string($_GET['mail'])."'   ";
	$result=mysql_query($sql_get,$GLOBALS['sql']);
	$row = mysql_fetch_assoc($result);
	if (strlen($row['mail'])!=strlen($_GET['mail']) ) {
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
} else if (isset($_GET['cap'])) {
	session_start();
	$a=md5(session_id());
	$a1=ord($a[2]);
	$a2=ord($a[4]);
	$zn=ord($a[6]);
	while ($a1>15) {$a1=$a1-10; }
	while ($a2>15) {$a2=$a2-10; }
	if ($zn%2==0) { $res=$a1+$a2;} else 	if ($zn%3==0) { $res=$a1*$a2; }
	else { $res=$a1-$a2; }

	if ($_GET['cap']==$res) {
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