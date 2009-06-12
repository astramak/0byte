<?php
if (!isset($_POST['title']{2}) || !isset ($_POST['text']{2}) || !isset($_POST['to']{2})) {
	header("Request-URI: work/pmls");
	header("Content-Location: work/pmls");
	header("Location: work/pmls");
	die;
}
$alien=new user;
$alien->find($_POST['to']);
if ($alien->login!=$_POST['to'] || $alien->login==$usr->login) {
	header("Request-URI: work/pmls");
	header("Content-Location: work/pmls");
	header("Location: work/pmls");
	die;
}
$text=mysql_escape_string(gtext($_POST['text']));

$to=$_POST['to'];
$sql_get="SELECT * FROM `users` WHERE `name` = '".mysql_escape_string($_POST['to'])."' ORDER BY  id DESC  ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}

$row = mysql_fetch_assoc($result);
if (strlen($row['name'])<1) {
	header("Request-URI: work/pmls");
	header("Content-Location: work/pmls");
	header("Location: work/pmls");

	die;
}
if (isset($_GET['lock']) && $_GET['lock']=="on" ) {
	$lock=1;
} else {
	$lock=0;
}
$time=time();
$sl="INSERT INTO `$sql_db`.`pm` (`date` ,`title`,`auth`, `text` ,`to` )
VALUES ( '".$time."', '".mysql_escape_string(gtext($_POST['title']))."' , 
'".$usr->login."' ,'".$text."'
,'$to' )";
$result=mysql_query($sl,$sql);
$sl="SELECT * FROM `pm` WHERE `date` = '".$time."'";
$result=mysql_query($sl,$sql);
$rw = mysql_fetch_assoc($result);
if ($row['pmre']==1) {
	$to = $row['mail'];
	$subject = "Личное сообщение на ".$s_name;
	$message = "Пользователь ".$usr->login." отправил вам лично <a href='".$site."work/pmread/".$rw['id']."'>сообщение</a>";
	$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
	nullbyte_mail($to, $subject, $message, true, $headers);
}
$lst="work/pmls/1";
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>