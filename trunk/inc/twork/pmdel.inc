<?php
$sql_get="SELECT * FROM `pm` WHERE `id` = '".gint($_GET['id'])."'   ORDER BY  id DESC  ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row = mysql_fetch_assoc($result);
if ($row['auth']==$usr->login) {
	if ($row['dto']==2) {
		$sql_get="DELETE FROM `pm` WHERE `pm`.`id` = ".gint($_GET['id'])." LIMIT 1";
		$result=mysql_query($sql_get,$sql);
		if (!$result) {
			echo  mysql_error();
		}
	}  else  {
		$sql_get="UPDATE `$sql_db`.`pm` SET `dto` = 1   WHERE `pm`.`id` = ".gint($_GET['id']);
		$result=mysql_query($sql_get,$sql);
	}
} else if ($row['to']==$usr->login) {
	if ($row['dto']==1) {
		$sql_get="DELETE FROM `pm` WHERE `pm`.`id` = ".gint($_GET['id'])." LIMIT 1";
		$result=mysql_query($sql_get,$sql);
		if (!$result) {
			echo  mysql_error();
		}
	}  else  {
		$sql_get="UPDATE `$sql_db`.`pm` SET `dto` = 2   WHERE `pm`.`id` = ".gint($_GET['id']);
		$result=mysql_query($sql_get,$sql);
	}
}
jkill();
$lst=$_GET['cur'];
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>