<?php
if (isset($_POST['old']) && isset($_POST['new']) && strlen($_POST['new'])>4) {
	if ($usr->pwd==md5($_POST['old'])) {
		$sql_get="UPDATE `users` SET `pwd` = '".md5($_POST['new'])."' WHERE `users`.`name` = '".$usr->login."'";
		$result=mysql_query($sql_get,$sql);
		$lst="login.php?cur=users.php&un=1";
	} else {
		$lst="users.php?cpw=1";
	}
} 	 else {
	$lst="users.php?cpw=2";
}
redirect($lst);
?>