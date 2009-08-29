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
session_start();

include ("cfg.php");
$loged = login();
$json = request::get_get('json');
if ($json) {
    header("Content-Type: text/html; charset=utf-8");
}

if ($loged == 0) {
    j_err("Для совершения этого действия требуется авторизация!");
    jkill();
    redirect('login.php');
} else {
    db_query('UPDATE users SET online = %d WHERE name = %s', time(), $usr->login);
    DEFINE('TZ',($usr->timezone-$server_time)*3600);
    include("inc/twork/" . sfin(request::get_get('wt')) . ".inc");
}
?>