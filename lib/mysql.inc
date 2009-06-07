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
$sql=mysql_connect($sql_srv,$sql_usr,$sql_pwd) or die ('e1');
mysql_select_db($sql_db) or die ('e2');
$sqs="SET NAMES UTF8";
mysql_query($sqs,$sql);
function sqlq($sql) {
	return mysql_query($sql_get,$sql);
}
function sqlnum($sql) {
	return mysql_num_rows($sql);
}
function sqlfetch($sql) {
	return mysql_fetch_assoc($sql);
}
?>