<?php
if ($json != 1) {
	$lst = request::get_get('from');
	$lst=str_replace("*amp","&",$lst);
	$lst="/".str_replace("*qw","?",$lst);
}

$text = request::get_post('text');
if (strlen($text) < 3) {
	if ($json == 1) {
		$out['err']="Вы не ввели комментарий!";
		die(json_encode($out));
	} else {
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
		die;
	}
}

$lvl = request::get_get('lvl', 0, true);
$id = request::get_get('id');
if ($lvl) {
	$sql_get="SELECT * FROM `comment` WHERE `id` = '".intval($id)."'   ";
	$result=mysql_query($sql_get,$sql);
	$rw = mysql_fetch_assoc($result);
	$krnl=$rw['krnl'];
	$ceauth=$rw['who'];
} else {
	$krnl=intval($id);
	$ceauth="";
}

$sql_get="SELECT * FROM `post` WHERE `id` = '".$krnl."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo mysql_error();
}

$raw = mysql_fetch_assoc($result);
if ($raw['id'] != $krnl || $id == "") {
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
	die;
}

$pauth=$raw['auth'];
$pid=$raw['id'];
$listp=$raw['flw'];
$text=mysql_escape_string(gtext($text));
$date=time();
$sl="INSERT INTO `comment` (`date` ,`text`,`who`, `cid` , `lvl` , `krnl`)
VALUES ( '".$date."', '".$text."' , '".$usr->login."' ,".intval($id)." , ".$lvl." , '".$krnl."')";
$result=mysql_query($sl,$sql);
$sql_get="SELECT * FROM `comment` WHERE `cid` = '".intval($id)."' && `date`= '".$date."'   ";
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
		$to = $row['mail'];
		$subject = "Ответ на ваш комментарий на " . $s_name;
		$message = render_mail('comment_reply', array(
			'user' => $usr->login,
			'pid' => $pid,
			'lst' => $lst,
		));
		$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
		nullbyte_mail($to, $subject, $message, true, $headers);
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
		$to = $row['mail'];
		$subject = "Ответ на ваш пост на ".$s_name;
		$message = render_mail('post_reply', array(
			'user' => $usr->login,
			'pid' => $pid,
			'lst' => $lst,
		));
		$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
		nullbyte_mail($to, $subject, $message, true, $headers);
	}
}
flsnd($listp,$usr->login,$pid,$cm->id);

$sql_get="DELETE FROM `eye` WHERE `pid`='' || `who`=''";
$result=mysql_query($sql_get,$sql);

if ($json == 1) {
	$post11=$pid;
	$v_date=0;
	$out['id']=$pid;
	$out['cid']=intval($id);
	$out['txt']=com_echo($cm,1);
	die(json_encode($out));
}
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>