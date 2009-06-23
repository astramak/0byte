<?php
$who=$_GET['who'];
if (isset($who)) {

	$sql_get="SELECT * FROM `users` WHERE name = '".$usr->login."' && ( frnd LIKE  '%, ".mysql_escape_string($_GET['who'])."%' || frnd LIKE  '%".mysql_escape_string($_GET['who']).",%' ) ORDER BY  id DESC ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['name']!=$usr->login) {
		$sl="UPDATE `users` SET `frnd` = CONCAT(`frnd`,', ".mysql_escape_string($_GET['who'])."')
	WHERE `users`.`name` = '".$usr->login."'";
		$result=mysql_query($sl,$sql);
	} else {
		$sql_get="SELECT * FROM `users` WHERE name = '".$usr->login."'
		ORDER BY  id DESC ";
		$result=mysql_query($sql_get,$sql);
		if (!$result) {
			echo  mysql_error();
		}
		$row = mysql_fetch_assoc($result);
		#echo ", ".$who;
		$frnd=str_replace(", ".$who,"",$row['frnd']);
		$sl="UPDATE `users` SET `frnd` = '".$frnd."'
	WHERE `users`.`name` = '".$usr->login."'";
		$result=mysql_query($sl,$sql);
		#echo $sl;
	}
}
$lst=$_GET['cur'];
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);
redirect($lst);
?>