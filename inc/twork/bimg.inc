<?php
$lst="worked.php?wt=myblog";
if (!isset($_FILES['img'])) {

	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
}
$sz = getimagesize($_FILES['img']['tmp_name']);
if (strncmp($_FILES['img']['type'],"image",5)==0 && $sz[0]<=70 && $sz[1]<=70
&& $_FILES['img']['size']<400000 ) {
	$uploaddir = "tmp/bl/";
	$sql_get="SELECT * FROM `blogs` WHERE id = '".intval($_GET['bid'])."'   ";
	$result=mysql_query($sql_get,$sql);
	$row = mysql_fetch_assoc($result);
	unlink("tmp/bl/".$row['av']);
	move_uploaded_file($_FILES['img']['tmp_name'],$uploaddir.$_GET['bid'].time().".".substr($_FILES['img']['type'],6));
	$sqlg="UPDATE `blogs` SET `av` = '".intval($_GET['bid']).time().".".substr($_FILES['img']['type'],6)."'
	WHERE `blogs`.`id` ='".intval($_GET['bid'])."'";
	$resul=mysql_query($sqlg,$sql);
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
} else {
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
}
?>