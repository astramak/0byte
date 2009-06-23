<?php
if( !isset($_POST['btitle']) || strlen(trim($_POST['btitle']))<3) {
	redirect('index.php');
}

$btitle=mysql_escape_string(gtext($_POST['btitle']));
if ($usr->rate()<$nb_rate) {
	redirect('index.php');
}
$sl="SELECT * FROM `blogs` where LOWER(`name`) = LOWER('$btitle')  ";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
if (strlen($row['name'])==strlen($btitle)) {
	redirect('index.php');
}
$sl="INSERT INTO `blogs` (`name` ,`owner` )
VALUES ('".$btitle."' , '".$usr->login."')";
$result=mysql_query($sl,$sql);
$sl="SELECT * FROM `blogs` where `name` = '$btitle'  ";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
$id=$row['id'];
$sl="INSERT INTO `inblog` (`blogid` ,`name` , `bname` )
	 VALUES ( '".$id."', '".$usr->login."' , '".$btitle."')";
$result=mysql_query($sl,$sql);

redirect("work/newpost");
?>