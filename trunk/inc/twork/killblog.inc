<?php
if (isset($_GET['id'])) {
	$sq="SELECT `owner` FROM `blogs` WHERE `id`=".intval($_GET['id']);
	$result=mysql_result($sq,$sql);
	$arr=mysql_fetch_assoc($result);
	if ($arr['owner']==$usr->loging) {
		$sq="DELETE FROM `blogs` WHERE `id`=".intval($_GET['id'])." && `owner`='".$usr->login."' LIMIT 1";
		mysql_query($sq,$sql);
		$sql_get="UPDATE `post` SET `blog` = 'own', `blogid` = 0 WHERE `blogid`=".intval($_GET['id']);
		mysql_query($sql_get,$sql);
		$sq="DELETE FROM `inblog` WHERE `blogid`=".intval($_GET['id']);
		mysql_query($sq,$sql);
		$sq="DELETE FROM `brate` WHERE `pid`=".intval($_GET['id']);
		mysql_query($sq,$sql);
	}
}
redirect('work/myblog');
?>