<?php
$sl="SELECT * FROM `inblog` WHERE name = '".$usr->login."' && blogid = '".intval($_GET['id'])."'";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
$sl="SELECT * FROM `blogs` WHERE id = '".intval($_GET['id'])."'";
$resul=mysql_query($sl,$sql);
$ro = mysql_fetch_assoc($resul);
$lst="index.php?blog=".$_GET['id'];
if ($ro['id']!=$_GET['id'] || $ro['owner']==$usr->login) {

	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
}
if ($row['name']==$usr->login) {
	if ($row['out']==1) {
		$sl="UPDATE `$sql_db`.`inblog` SET `out` = '0' WHERE `inblog`.`blogid` =".intval($_GET['id'])."
		&& `inblog`.`name` = '".$usr->login."'";
	} else {
		$sl="UPDATE `$sql_db`.`inblog` SET `out` = '1' WHERE `inblog`.`blogid` =".intval($_GET['id'])."
		&& `inblog`.`name` = '".$usr->login."'";
		#echo $sl;
	}
} else {

	$sl="INSERT INTO `$sql_db`.`inblog` (`blogid` ,`name` , `bname` )
	 VALUES ( '".intval($_GET['id'])."', '".$usr->login."' , '".$ro['name']."')";
	#echo $sl;
}
$resul=mysql_query($sl,$sql);
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>