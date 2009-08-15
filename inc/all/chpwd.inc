<?php
if (request::get_get('user') && request::get_get('ld')) {
        $row=db_fetch_assoc(db_query('SELECT *, COUNT(*) AS count FROM `restore` WHERE `user` = %s && `code` = %s',request::get_get('user'),request::get_get('ld')));
//	$sql_get="SELECT * FROM `users` WHERE name = '".mysql_escape_string($_GET['user'])."' && lck = 0  ";
//	$result=mysql_query($sql_get,$sql);
//	if (!$result) {
//		echo  mysql_error();
//	}
//	$row = mysql_fetch_assoc($result);
//	$sql_get="UPDATE `users` SET `pwd` = '".mysql_escape_string($_GET['ld'])."' WHERE `users`.`name` = '".mysql_escape_string($_GET['user'])."'";
//	$result=mysql_query($sql_get,$sql);
	if ($row['count']) {
            db_query('UPDATE `users` SET `pwd` = %s WHERE `name` = %s LIMIT 1',md5($db_salt.$row['pwd']),$row['user']);
            db_query('DELETE FROM `restore` WHERE `id` = %d',$row['id']);
        }
        echo "<h2>Теперь вы можете войти со своим новым паролем</h2>";
}
?>