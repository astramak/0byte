<?php
if ($usr->lvl>=$rlvl && isset($_GET['unb']) && isset($_GET['id'])) {
	$un=1-$_GET['unb'];
	$sql_get="UPDATE `$sql_db`.`post` SET `blck` = ".intval($un)."  WHERE `post`.`id` = '".intval($_GET['id'])."'";
	#echo $sql_get;
	$result=mysql_query($sql_get,$sql);


}
$lst="index.php?post=".$_GET['id'];
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>