<?php
$sql_get="SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row=mysql_fetch_assoc($result);
if ($usr->lvl<$elvl ) {
	$lst="post/".$row['krnl']."#cmnt".$_GET['id'];
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
	die;
}
$cm=new com;
$cm->make($row);
rmcom($cm);
$lst="http://".$_SERVER['HTTP_HOST'].$dir."post/".$row['krnl'];
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>