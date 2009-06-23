<?php
$lst=$_GET['cur'];
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);
if (isset($_POST['nox'])) {
	$sl="SELECT * FROM `wansw` WHERE who = '".$usr->login."' && cid = '".intval($_GET['id'])."'";
	$result=mysql_query($sl,$sql);
	$row = mysql_fetch_assoc($result);
	#echo $sl;
	if (strcmp($row['cid'],$_GET['id'])==0) {
		jkill();
		redirect($lst);
	}
	$sl="INSERT INTO `wansw` (`who` ,`cid`) VALUES ('".$usr->login."', '".intval($_GET['id'])."')";
	$result=mysql_query($sl,$sql);
	if ($json==1) {
		echo answ_echo($_GET['id']);
	}
	jkill();
	redirect($lst);
}

$sl="SELECT * FROM `post` WHERE id = '".intval($_GET['id'])."'";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
if (!isset($_POST['answ']) && $row['lnk']==0) {
	jkill();
	redirect($lst);
}
if ($row['lnk']==1) {
	$sl="SELECT * FROM `answ` WHERE cid = '".intval($_GET['id'])."'";
	$result=mysql_query($sl,$sql);
	while ($raw = mysql_fetch_assoc($result)) {
		if (isset($_POST[$raw['id']]) && $_POST[$raw['id']]=="on") {
			$sla="UPDATE `answ` SET `val` = `val`+1 WHERE `answ`.`id` = '".$raw['id']."'";
			$rest=mysql_query($sla,$sql);
		}
	}
} else {
#echo $sl;
	if (strcmp($row['cid'],$_GET['id'])==0) {
		jkill();
		redirect($lst);
	}
	$sl="UPDATE `answ` SET `val` = `val`+1 WHERE `answ`.`id` = '".intval($_POST['answ'])."'";
	$result=mysql_query($sl,$sql);

}
$sl="INSERT INTO `wansw` (`who` ,`cid`) VALUES ('".$usr->login."', '".intval($_GET['id'])."')";
$result=mysql_query($sl,$sql);
if ($json==1) {
	echo answ_echo($_GET['id']);
}
jkill();
redirect($lst);
?>