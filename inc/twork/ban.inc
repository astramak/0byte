<?php
if ($usr->lvl>=$blvl && isset($_GET['unb']) && isset($_GET['who'])) {
	$un=1-$_GET['unb'];
	$sql_get="UPDATE `$sql_db`.`users` SET `lck` = ".gint($un)."  WHERE `users`.`name` = '".mysql_escape_string($_GET['who'])."'";
	#echo $sql_get;
	$result=mysql_query($sql_get,$sql);


}
$lst=$_GET['cur'];
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>