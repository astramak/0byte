<?php
$sql_get="SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row=mysql_fetch_assoc($result);
if (!isset($_POST['text']) || (($usr->login!=$row['who'] && $cedit==1 )&& $usr->lvl<$elvl) ) {
	redirect("post/".$row['krnl']."#cmnt".$_GET['id']);
}
$sql_get="UPDATE `comment` SET `text` = '".mysql_escape_string(gtext($_POST['text']))."'
		 WHERE `comment`.`id` = '".$_GET['id']."'";

$result=mysql_query($sql_get,$sql);
redirect("post/".$row['krnl']."#cmnt".$_GET['id']);
?>