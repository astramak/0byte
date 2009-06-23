<?php
if ($usr->login==$row['auth']) {
	redirect($site . 'post/' . $row['id']);
}
$sql_get="SELECT * FROM `post` WHERE id = '".intval($_GET['id'])."'   ";
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
$sl="UPDATE `post` SET `flw` = '".$lst."'	WHERE `post`.`id` = '".intval($_GET['id'])."'";
$result=mysql_query($sl,$sql);
if ($json) {
	echo '{
	"lnk" : "javascript: x_r(\'twork.php?wt=flw&id='.intval($_GET['id']).$lnk.'&json=1\',\'f\')" ,
	"txt" : "'.$txt.'"
	}';
	jkill();
}
redirect($site . 'post/' . intval($_GET['id']));
?>