<?php
if ($json!=1) {
	$lst=$_GET['from'];
	$lst=str_replace("*amp","&",$lst);
	$lst=str_replace("*qw","?",$lst);
}
if ($json==1 && strlen($_POST['text'])<3) {
	$out['err']="Вы не ввели комментарий!";
	echo json_encode($out);
	die;
} else if( strlen($_POST['text'])<3) {
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
	die;
}
if (isset($_GET['lvl'])) {
	$lvl=$_GET['lvl'];
	$sql_get="SELECT * FROM `comment` WHERE `id` = '".gint($_GET['id'])."'   ";
	$result=mysql_query($sql_get,$sql);
	$rw = mysql_fetch_assoc($result);
	$krnl=$rw['krnl'];
	$ceauth=$rw['who'];

} else {
	$lvl=0;
	$krnl=gint($_GET['id']);
	$ceauth="";
}
$sql_get="SELECT * FROM `post` WHERE `id` = '".$krnl."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
	
$raw = mysql_fetch_assoc($result);
if ($raw['id']!=$krnl || $_GET['id']=="") {
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
	die;
}

$pauth=$raw['auth'];
$pid=$raw['id'];
$listp=$raw['flw'];
$text=mysql_escape_string(gtext($_POST['text']));
$date=time();
$sl="INSERT INTO `$sql_db`.`comment` (`date` ,`text`,`who`, `cid` , `lvl` , `krnl`)
VALUES ( '".$date."', '".$text."' , '".$usr->login."' ,".gint($_GET['id'])." , ".$lvl." , '".$krnl."')";
$result=mysql_query($sl,$sql);
$sql_get="SELECT * FROM `comment` WHERE `cid` = '".gint($_GET['id'])."' && `date`= '".$date."'   ";
$result=mysql_query($sql_get,$sql);
$rw = mysql_fetch_assoc($result);
$cm=new com;
$cm->make($rw);
$lst.='#cmnt'.$cm->id;
if ($ceauth!="" && $ceauth!=$usr->login) {
	$sql_get="SELECT * FROM `users` WHERE `name` = '".$ceauth."'";
	$result=mysql_query($sql_get,$sql);
	$row = mysql_fetch_assoc($result);
	$sql_get="DELETE FROM `eye` WHERE `pid`='".$pid."' && `who`='".$ceauth."' LIMIT 1";
	$result=mysql_query($sql_get,$sql);
	$sql_get="INSERT INTO `eye` ( `who` ,`pid`) VALUES ('".$ceauth."','".$pid."')";
	$result=mysql_query($sql_get,$sql);

	if ($row['comre']==1) {
		mail($row['mail'], "Ответ на ваш комментарий на ".$s_name,
		 "Пользователь ".$usr->login." ответил на ваш <a href='".$site."post/".$pid.$lst."'>комментарий</a>"
		 , "Content-type: text/html; charset='UTF-8'\r\n" .
		'From: reply'.$eml."\r\n" .
    'Reply-To: reply'.$eml."\r\n" .
    'X-Mailer: PHP/' . phpversion());
	}
}
if ($pauth!=$usr->login) {
	$sql_get="SELECT * FROM `users` WHERE name = '".$pauth."'";
	$result=mysql_query($sql_get,$sql);
	$row = mysql_fetch_assoc($result);
	$sql_get="DELETE FROM `eye` WHERE `pid`='".$pid."' && `who`='".$pauth."' LIMIT 1";
	$result=mysql_query($sql_get,$sql);
	$sql_get="INSERT INTO `eye` ( `who` ,`pid`) VALUES ('".$pauth."','".$pid."')";
	$result=mysql_query($sql_get,$sql);
	if ($row['postre']==1) {
		mail($row['mail'], "Ответ на ваш пост на ".$s_name,
		 "Пользователь ".$usr->login." ответил на ваш <a href='".$site."post/".$pid.$lst."'>пост</a>"
		 , "Content-type: text/html; charset='UTF-8'\r\n" .
		'From: reply'.$eml."\r\n" .
    'Reply-To: reply'.$eml."\r\n" .
    'X-Mailer: PHP/' . phpversion());

	}
}
flsnd($listp,$usr->login,$pid,$cm->id);

$sql_get="DELETE FROM `eye` WHERE `pid`='' || `who`=''";
$result=mysql_query($sql_get,$sql);
if ($json==1)
{
	$post11=$pid;
	$v_date=0;
	$out['id']=$pid;
	$out['cid']=gint($_GET['id']);
	$out['txt']=com_echo($cm,1);
	echo json_encode($out);
	jkill();
}
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>