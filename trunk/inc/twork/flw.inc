<?php
if ($usr->login==$row['auth']) {
	$lst="http://".$_SERVER['HTTP_HOST'].$dir."post/".$row['id'];
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
}
$sql_get="SELECT * FROM `post` WHERE id = '".gint($_GET['id'])."'   ";
$result=mysql_query($sql_get,$sql);
$row=mysql_fetch_assoc($result);
if (isset($_GET['un'])) {
	$lst=flrm($row['flw'],$usr->login);
	$lnk="";
	$txt="Отслеживать";
} else {
	$lst=fladd($row['flw'],$usr->login);
	$lnk="&un=1";
	$txt="Перестать отслеживать";
}
$sl="UPDATE `post` SET `flw` = '".$lst."'	WHERE `post`.`id` = '".gint($_GET['id'])."'";
$result=mysql_query($sl,$sql);
if ($json) {
	echo '{
	"lnk" : "javascript: x_r(\'twork.php?wt=flw&id='.gint($_GET['id']).$lnk.'&json=1\',\'f\')" ,
	"txt" : "'.$txt.'"
	}';
	jkill();
}
$lst="http://".$_SERVER['HTTP_HOST'].$dir."post/".gint($_GET['id']);
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>