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
function pm_echo($row) {
    echo render_template(TPL_PM.'/read.tpl.php', array('auth'=>$row['auth'],'date'=> date('d.m.y  H:i',$row['date']),
        'title'=>$row['title'],'text'=>str_replace("[cut]"," ",str_replace("[fcut]"," ",$row['text']))));
}
?>