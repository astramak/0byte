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

$id = request::get_get('id');
$result = db_query('SELECT* FROM comment WHERE id = %d', $id);
$row = db_fetch_assoc($result);

$cm = new comment($row);
echo render_edit_comment($id, utext($cm->text));
$script->add("mk('mq','new');");
?>
