<?php
$lst=$_GET['from'];
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);
$sl="SELECT * FROM `urate` WHERE who = '".$usr->login."' && pid = '".mysql_escape_string($_GET['name'])."'";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
if ($_GET['rate']=='p') {
	$type=1;
} else {
	$type=2;
}
$nr=1;
if (strcmp($row['pid'],$_GET['name'])==0) {
	$nr=2;
}
if (strcmp($row['pid'],$_GET['name'])==0 && $row['type']==$type) {
	j_err("Нельзя дважды поднимать или опускать рейтинг!");
	jkill();
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
} else {
	$sql_get="SELECT * FROM `users` WHERE name = '".mysql_escape_string($_GET['name'])."'   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['name']==$usr->login) {
		j_err("Нельзя голосовать за себя!");
		jkill();
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
	} else {
			
		$sl="UPDATE `$sql_db`.`users` SET `rate".$_GET['rate'][0]."` = `rate".$_GET['rate'][0]."`+".$nr."
				WHERE `users`.`name` = '".mysql_escape_string($_GET['name'])."'";
		$result=mysql_query($sl,$sql);
		$sl="DELETE FROM `urate` WHERE `who`='".$usr->login."' && `pid` = '".mysql_escape_string($_GET['name'])."' LIMIT 1";
		$result=mysql_query($sl,$sql);
		$sl="INSERT INTO `$sql_db`.`urate` ( `who` ,`pid`,`type`) VALUES ('".$usr->login."',
				 '".mysql_escape_string($_GET['name'])."','".$type."')";
		$result=mysql_query($sl,$sql);
		if ($json==1) {
			if ($_GET['rate']=='p') {
				$rr=$nr;
			} else {$rr=0-$nr;}
			$otr=$row['ratep']-$row['ratem']+$rr;
			
			$otr+=$row['brate']/$blog_r+$row['crate']/$com_r+$row['prate']/$post_r;
			cmpl($_GET['name'],$otr);
			die;
		}
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
	}
}
?>