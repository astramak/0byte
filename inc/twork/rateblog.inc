<?php
$lst=$_GET['from'];
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);
$sl="SELECT * FROM `brate` WHERE who = '".$usr->login."' && pid = '".$_GET['id']."'";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
#echo $sl;
if (strcmp($row['pid'],$_GET['id'])==0) {
	j_err("Повторное голосование запрещено!");
	jkill();
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
} else {
	$sql_get="SELECT * FROM `blogs` WHERE id = '".intval($_GET['id'])."'   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['owner']==$usr->login) {
		j_err("Нельзя голосовать за свой блог!")
		jkill();
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
	} else {
			
		$sl="UPDATE `$sql_db`.`blogs` SET `rate".$_GET['rate'][0]."` = `rate".$_GET['rate'][0]."`+1 WHERE `blogs`.`id`
				 = '".intval($_GET['id'])."'";
		$result=mysql_query($sl,$sql);

		if ($_GET['rate'][0]=='p') {
			$sl="UPDATE `$sql_db`.`users` SET `brate` = `brate`+1 WHERE `users`.`name`
				 = '".$row['owner']."'";
		} else {
			$sl="UPDATE `$sql_db`.`users` SET `brate` = `brate`-1 WHERE `users`.`name`
				 = '".$row['owner']."'";
		}

		$result=mysql_query($sl,$sql);
		$sql_get="SELECT * FROM `urate`";
		$sl="INSERT INTO `$sql_db`.`brate` (`who` ,`pid`) VALUES ('".$usr->login."', '".intval($_GET['id'])."')";
		$result=mysql_query($sl,$sql);
		if ($json==1) {
			if ($_GET['rate']=='p') {
				$rr=1;
			} else {$rr=-1;}
			cmpl($_GET['id'],$row['ratep']-$row['ratem']+$rr);
			die;
		}
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
	}
}
?>