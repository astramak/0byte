<?php

if(!isset($_POST['title']) || (!isset($_POST['text']) && !isset($_POST['len']) ) || strlen(trim($_POST['title']))<2) {
	header("Request-URI: index.php");
	header("Content-Location: index.php");
	header("Location: index.php");
	die;
} else if ($_POST['blog']==0) {
	$blog="own";
}
else {
	$sql_get="SELECT * FROM `blogs` WHERE id = '".intval($_POST['blog'])."'  ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	$blog=$row['name'];
}

$text=gtext($_POST['text']);
$tag=stag($_POST['tag']);
$tz=new dtxt;
$tz->cut($_POST['text']);
$text=$tz->o;
$txt=$tz->t;
if (isset($_POST['lock']) && $_POST['lock']=="on" ) {
	$lock=1;
} else {$lock=0;}

$time=time();
if ($_GET['tp']==0) {
	$sl="INSERT INTO `post` (`date` ,`title`,`auth`, `text`,`ftext` , `blog`, `blogid`, `tag` ,`lock` )
VALUES ( '".$time."', '".mysql_escape_string(gtext($_POST['title']))."' , '".$usr->login."' ,'".mysql_escape_string(gtext($txt))."'
, '".mysql_escape_string(gtext($text))."', '".$blog."', '".intval($_POST['blog'])."','".mysql_escape_string($tag)."' ,
'".intval($lock)."' )";
} else if ($_GET['tp']==1) {
	if (!isset($_POST['lnk'])) {
		header("Request-URI: index.php");
		header("Content-Location: index.php");
		header("Location: index.php");
		die;
	}
	$sl="INSERT INTO `post` (`date` ,`title`,`auth`, `text`,`ftext` , `blog`, `blogid`, `tag` ,`lock` , `tp` , `lnk` )
VALUES ( '".$time."', '".mysql_escape_string(gtext($_POST['title']))."' , '".$usr->login."' ,'".mysql_escape_string(gtext($txt))."'
, '".mysql_escape_string(gtext($text))."', '".$blog."', '".intval($_POST['blog'])."','".mysql_escape_string($tag)."'
 ,'".intval($lock)."' ,'1' , '".mysql_escape_string(gtext($_POST['lnk']))."' )";

} else if ($_GET['tp']==2) {
	if (!isset($_POST['org'])) {
		header("Request-URI: index.php");
		header("Content-Location: index.php");
		header("Location: index.php");
		die;
	}
	$sl="INSERT INTO `$sql_db`.`post` (`date` ,`title`,`auth`, `text`,`ftext` , `blog`, `blogid`, `tag` ,`lock` , `tp` , `lnk` )
VALUES ( '".$time."', '".mysql_escape_string(gtext($_POST['title']))."' , '".$usr->login."' 
,'".mysql_escape_string(gtext($txt))."'
, '".mysql_escape_string(gtext($text))."', '".$blog."', '".intval($_POST['blog'])."','".mysql_escape_string($tag)."' 
,'".intval($lock)."' ,'2' , '".mysql_escape_string(gtext($_POST['org']))."' )";

} else if ($_GET['tp']==3) {
	if (!isset($_POST['len'])) {
		header("Request-URI: index.php");
		header("Content-Location: index.php");
		header("Location: index.php");
		die;
	}

	if (isset($_POST['mng']) && $_POST['mng']=="on") {
		$nm=1;
	} else {
		$nm=0;
	}
	$sl="INSERT INTO `post` (`date` ,`title`,`auth`, `blog`, `blogid`, `tag` ,`lock` , `tp` , `lnk`  )
VALUES ( '".$time."', '".mysql_escape_string(gtext($_POST['title']))."' , '".$usr->login."' , '".$blog."', 
'".intval($_POST['blog'])."','".mysql_escape_string($tag)."' ,'".intval($lock)."' ,'3' , '".$nm."' )";
	//	echo $sl;die;
}
//die;
$result=mysql_query($sl,$sql);
$sl="SELECT * FROM `post` where `date` = '$time' and `tag` = '$tag'  ";
$result=mysql_query($sl,$sql);
$row = mysql_fetch_assoc($result);
$id=$row['id'];
if ($_GET['tp']==3) {
	for ($q=1;$q<=$_POST['len'];$q++) {
		if (strlen(trim($_POST['an'.$q]))>0) {
			$sl="INSERT INTO `answ` (`title`,`cid` )
VALUES ( '".gtext($_POST['an'.$q])."', '".$id."')";
			$result=mysql_query($sl,$sql);	}
	}
}
//die;
$lst="post/".$id;
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>