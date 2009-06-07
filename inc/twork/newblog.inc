<?php
if( !isset($_POST['btitle']) || strlen(trim($_POST['btitle']))<3) {
	header("Request-URI: index.php");
	header("Content-Location: index.php");
	header("Location: index.php");
	die;
}


$btitle=mysql_escape_string(gtext($_POST['btitle']));
if ($usr->rate()<$nb_rate) {
	header("Request-URI: index.php");
	header("Content-Location: index.php");
	header("Location: index.php");
}
$sl="SELECT * FROM `blogs` where LOWER(`name`) = LOWER('$btitle')  ";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
if (strlen($row['name'])==strlen($btitle)) {
	header("Request-URI: index.php");
	header("Content-Location: index.php");
	header("Location: index.php");
	die;
}
$sl="INSERT INTO `$sql_db`.`blogs` (`name` ,`owner` )
VALUES ('".$btitle."' , '".$usr->login."')";
$result=mysql_query($sl,$sql);
$sl="SELECT * FROM `blogs` where `name` = '$btitle'  ";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
$id=$row['id'];
$sl="INSERT INTO `$sql_db`.`inblog` (`blogid` ,`name` , `bname` )
	 VALUES ( '".$id."', '".$usr->login."' , '".$btitle."')";
$result=mysql_query($sl,$sql);
$lst="work/newpost";

header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>