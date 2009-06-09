<?php
$lst=$_GET['from'];
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);
$lstw=strrpos($lst,"hl");
if ($lstw!=false) {
	$lst=substr($lst,0,$lstw)."hl=".$_GET['id']."#hl";
} else if (strstr($lst,"?")!=false) {
	$lst.="&hl=".$_GET['id']."#hl";
} else {
	$lst.="?hl=".$_GET['id']."#hl";
}

$sl="SELECT * FROM `crate` WHERE who = '".$usr->login."' && pid = ".intval($_GET['id']);
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
if (strcmp($row['pid'],$_GET['id'])==0) {
	j_err("Повторное голосование запрещено!");
	jkill();
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
} else {
	$sql_get="SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['who']==$usr->login) {
		j_err("Нельзя голосовать за свой комментарий!");
		jkill();
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
	} else {
			
		$sl="UPDATE `$sql_db`.`comment` SET `rate".$_GET['rate'][0]."` = `rate".$_GET['rate'][0]."`+1 WHERE `comment`.`id` = ".intval($_GET['id']);
		$result=mysql_query($sl,$sql);


		if ($_GET['rate'][0]=='p') {
			$sl="UPDATE `$sql_db`.`users` SET `crate` = `crate`+1 WHERE `users`.`name`
				 = '".$row['who']."'";
		} else {
			$sl="UPDATE `$sql_db`.`users` SET `crate` = `crate`-1 WHERE `users`.`name`
				 = '".$row['who']."'";
		}

		$result=mysql_query($sl,$sql);
		$sl="INSERT INTO `$sql_db`.`crate` (`who` ,`pid`) VALUES ( '".$usr->login."', '".intval($_GET['id'])."')";
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
		header("Location: $lst"); }
}
?>