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
/**
 * Display personal message
 *
 * @param array $row
 */
function pm_echo($row) {
    echo render_template(TPL_PM.'/read.tpl.php', array('auth'=>$row['auth'],'date'=> date('d.m.y  H:i',$row['date']),
    'title'=>$row['title'],'text'=>str_replace("[cut]"," ",str_replace("[fcut]"," ",$row['text']))));
}
/**
 * Remove personal message
 *
 * @global user $usr
 * @param numeric $id
 */
function pm_del($id) {
    global $usr;
    $result = db_query('SELECT * FROM pm WHERE id = %d', $id);
    $row = db_fetch_assoc($result);
    if ($row['auth'] == $usr->login) {
        if ($row['dto'] == 2) {
            db_query('DELETE FROM pm WHERE id = %d', $id);
        }  else {
            db_query('UPDATE pm SET dto = 1 WHERE id = %d', $id);
        }
    } else if ($row['to'] == $usr->login) {
        if ($row['dto'] == 1) {
            db_query('DELETE FROM pm WHERE id = %d', $id);
        }  else {
            db_query('UPDATE pm SET dto = 2 WHERE id = %d', $id);
        }
    }
}
?>