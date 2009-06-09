<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License.
 *
 *  0byte is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  See <http://www.gnu.org/licenses/>.
 *
 */
include 'cfg.php';
if (isset($_GET['name']) && isset($_GET['id'])) {
	$sql_get="SELECT * FROM `users` WHERE id = ".intval($_GET['id'])."   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['name']==$_GET['name']) {
		$sql_get="UPDATE `$sql_db`.`users` SET `activ` = 1  WHERE `users`.`name` = '".mysql_escape_string($_GET['name'])."'";


		$result=mysql_query($sql_get,$sql);
	}
}
$lst='login/';

header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>