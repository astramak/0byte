<?php
if (isset($_GET['id'])) {
	$sq="SELECT `owner` FROM `blogs` WHERE `id`=".gint($_GET['id']);
	$result=mysql_result($sq,$sql);
	$arr=mysql_fetch_assoc($result);
	if ($arr['owner']==$usr->loging) {
		$sq="DELETE FROM `blogs` WHERE `id`=".gint($_GET['id'])." && `owner`='".$usr->login."' LIMIT 1";
		mysql_query($sq,$sql);
		$sql_get="UPDATE `post` SET `blog` = 'own', `blogid` = 0 WHERE `blogid`=".gint($_GET['id']);
		mysql_query($sql_get,$sql);
		$sq="DELETE FROM `inblog` WHERE `blogid`=".gint($_GET['id']);
		mysql_query($sq,$sql);
		$sq="DELETE FROM `brate` WHERE `pid`=".gint($_GET['id']);
		mysql_query($sq,$sql);
	}
}
$lst=$dir."/work/myblog";
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>