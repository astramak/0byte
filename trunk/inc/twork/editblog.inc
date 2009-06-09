<?php
$sl="UPDATE `".$sql_db."`.`blogs` SET `about`= '".gtext($_POST['text'])."' WHERE `owner` = '".$usr->login."' && `id` = '".intval($_GET['bid'])."'";
$result=mysql_query($sl,$sql);
//echo $sl; die;
$lst="work/myblog";
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>