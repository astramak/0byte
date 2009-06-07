<?php
if (isset($_GET['id']) && isset($_GET['user']) && isset($_GET['ld'])) {
	$sql_get="SELECT * FROM `users` WHERE name = '".mysql_escape_string($_GET['user'])."' && lck = 0  ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	$sql_get="UPDATE `$sql_db`.`users` SET `pwd` = '".mysql_escape_string($_GET['ld'])."' WHERE `users`.`name` = '".mysql_escape_string($_GET['user'])."'";
	$result=mysql_query($sql_get,$sql);
	echo "<h2>Теперь вы можете войти со своим новым паролем</h2>";

}
?>