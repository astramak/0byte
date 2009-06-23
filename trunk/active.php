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

$name = request::get_get('name');
$id = request::get_get('id');
if ($name && $id) {
	$result = db_query('SELECT * FROM users WHERE id = %d AND name = %s', $id, $name);
	$row = db_fetch_assoc($result);
	if ($row) {
		db_query('UPDATE users SET activ = 1 WHERE id = %d', $id);
	}
}
redirect('login');
?>