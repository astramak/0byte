<?php

if (isset($_GET['tp'])) {
	$e="auth";
	$in="`dto` != 1";
} else {
	$e="to";
	$in="`dto` != 2";
}
$sql_get="SELECT * FROM `pm` WHERE `$e` = '".$usr->login."' && $in   ORDER BY  id DESC  ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}

while($row = mysql_fetch_assoc($result)) {
	pm_ls($row);
}

?>