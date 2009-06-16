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
$sl="SELECT * FROM `rate` WHERE who = '".$usr->login."' && pid = ".intval($_GET['id']);
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
if (strcmp($row['pid'],$_GET['id'])==0) {
	if ($json==1) {
		j_err("Вы уже голосовали!");
	}
	jkill();
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
} else {
	$sql_get="SELECT * FROM `post` WHERE id = '".intval($_GET['id'])."'   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['auth']==$usr->login) {
		if ($json==1) {
			j_err("За свой пост нельзя голосовать!");
		}
		jkill();
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
	} else {
			
		$sl="UPDATE `post` SET `rate".$_GET['rate'][0]."` = `rate".$_GET['rate'][0]."`+1 WHERE `post`.`id` = ".intval($_GET['id']);
		$result=mysql_query($sl,$sql);

		if ($_GET['rate'][0]=='p') {
			$sl="UPDATE `users` SET `prate` = `prate`+1 WHERE `users`.`name`
				 = '".$row['auth']."'";
		} else {
			$sl="UPDATE `users` SET `prate` = `prate`-1 WHERE `users`.`name`
				 = '".$row['auth']."'";
		}
		$result=mysql_query($sl,$sql);
		$sl="INSERT INTO `rate` (`who` ,`pid`) VALUES ( '".$usr->login."', '".intval($_GET['id'])."')";
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