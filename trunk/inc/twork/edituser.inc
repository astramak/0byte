<?php
if ($_POST['hml']=="on") { $hml=1; } else {$hml=0;}
if ($_POST['pr']=="on") { $pr=1; } else {$pr=0;}
if ($_POST['cr']=="on") { $cr=1; } else {$cr=0;}
if ($_POST['pmr']=="on") { $pmr=1; } else {$pmr=0;}
$sql_get="UPDATE `users` SET `icq` = '".mysql_escape_string(gtext($_POST['icq']))."' ,
	`hml` = '$hml ' ,
	`mail` = '".mysql_escape_string(gtext($_POST['mail']))."' ,
	`jabber` = '".mysql_escape_string(gtext($_POST['jabber']))."' ,
	`site` = '".mysql_escape_string(gtext($_POST['site']))."',
	`about` = '".mysql_escape_string(gtext($_POST['about']))."' ,
	`postre` = '".$pr."' ,
	`comre` = '".$cr."' ,
	`pmre` = '".$pmr."' ,
	`juse` = '".intval($_POST['juse'])."' ,
	`jname` = '".mysql_escape_string(gtext($_POST['jname']))."' ,
	`jdate` = '',
	`city` = '".mysql_escape_string(gtext($_POST['city']))."'
	WHERE `users`.`name` = '".$usr->login."'";
$result=mysql_query($sql_get,$sql);
$lst="user/";
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>