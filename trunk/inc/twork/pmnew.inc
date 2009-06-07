<?php
#echo 1111111;

if (!isset($_POST['title']{2}) || !isset ($_POST['text']{2}) || !isset($_POST['to']{2})
) {
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
} else {$lock=0;}
$time=time();
$sl="INSERT INTO `$sql_db`.`pm` (`date` ,`title`,`auth`, `text` ,`to` )
VALUES ( '".$time."', '".mysql_escape_string(gtext($_POST['title']))."' , 
'".$usr->login."' ,'".$text."'
,'$to' )";
#echo $sl; die;
$result=mysql_query($sl,$sql);
$sl="SELECT * FROM `pm` WHERE `date` = '".$time."'";
$result=mysql_query($sl,$sql);
$rw = mysql_fetch_assoc($result);
if ($row['pmre']==1) {
	mail($row['mail'], "Личное сообщение на ".$s_name,
		 "Пользователь ".$usr->login." отправил вам лично <a href='".$site."work/pmread/".$rw['id']."'>сообщение</a>"
		 , "Content-type: text/html; charset='UTF-8'\r\n" .
		'From: reply'.$eml."\r\n" .
    'Reply-To: reply'.$eml."\r\n" .
    'X-Mailer: PHP/' . phpversion());
}
$lst="work/pmls/1";
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");

?>