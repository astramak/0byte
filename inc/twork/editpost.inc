<?php
$sql_get="SELECT * FROM `post` WHERE id = '".intval($_GET['post'])."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
if (isset($_POST['text'])) {
	$tz=new dtxt;
	$tz->cut($_POST['text']);
	$text=$tz->o;
	$txt=$tz->t;
}

if ($_POST['blog']==0) {
	$blog="own";
}
else {
	$sql_get="SELECT * FROM `blogs` WHERE id = '".intval($_POST['blog'])."'  ";
	$res=mysql_query($sql_get,$sql);
	$row = mysql_fetch_assoc($res);
	$blog=$row['name'];
}



$row = mysql_fetch_assoc($result);
if ( ( $usr->lvl>$elvl || $usr->login==$row['auth'] ) && ((isset($_POST['title']) && isset($_POST['text']) ) || $row['tp']==3 )) {
	if (isset($_POST['lock']) && $_POST['lock']=="on" ) {
		$lock=1;
	} else {$lock=0;}
	$tag=stag($_POST['tag']);
	rtag($row['tag']);


	if ($row['tp']==3) {
		$sql_get="UPDATE `post` SET `lock` = '".intval($lock)."', `tag` = '".mysql_escape_string(gtext($tag))."', `blog` = '".$blog."',
		`blogid` = '".intval($_POST['blog']);

	} else {
		$sql_get="UPDATE `post` SET `title` = '".mysql_escape_string(gtext($_POST['title']))."' ,
		`text` = '".mysql_escape_string(gtext($txt))."' ,`ftext` = '".mysql_escape_string(gtext($text))."',
		`lock` = '".intval($lock)."',
		`blog` = '".$blog."', 
		`blogid` = '".intval($_POST['blog'])."',
		`tag` = '".mysql_escape_string(gtext($tag)); }
		if (isset($_POST['lnk'])) {
			$sql_get.="' ,`lnk` = '".mysql_escape_string(gtext($_POST['lnk']))." ";
		}

		$sql_get.="' WHERE `post`.`id` =".intval($_GET['post']);
		$result=mysql_query($sql_get,$sql);
		$lst="post/".$_GET['post'];
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
} else {
	header("Request-URI: index.php");
	header("Content-Location: index.php");
	header("Location: index.php");
}

?>