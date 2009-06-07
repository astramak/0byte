<?php

if ($usr->lvl<$elvl ) {
	$lst="post/".$_GET['id'];
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
	die;
}
$sql_get="SELECT * FROM `post` WHERE id = '".gint($_GET['id'])."'   ";
$result=mysql_query($sql_get,$sql);
$row=mysql_fetch_assoc($result);
rtag($row['tag']);
$sql_get="DELETE FROM `post` WHERE `post`.`id` = ".gint($_GET['id']);
$result=mysql_query($sql_get,$sql);
$sql_get="DELETE FROM `comment` WHERE `comment`.`krnl` = ".gint($_GET['id']);
$result=mysql_query($sql_get,$sql);
$lst="http://".$_SERVER['HTTP_HOST'].$dir;
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>