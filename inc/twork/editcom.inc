<?php
$sql_get="SELECT * FROM `comment` WHERE id = '".gint($_GET['id'])."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row=mysql_fetch_assoc($result);
if (!isset($_POST['text']) || (($usr->login!=$row['who'] && $cedit==1 )&& $usr->lvl<$elvl) ) {
	$lst="post/".$row['krnl']."#cmnt".$_GET['id'];
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
	die;
}
$sql_get="UPDATE `$sql_db`.`comment` SET `text` = '".mysql_escape_string(gtext($_POST['text']))."'
		 WHERE `comment`.`id` = '".$_GET['id']."'";

$result=mysql_query($sql_get,$sql);
$lst="post/".$row['krnl']."#cmnt".$_GET['id'];
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>