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
$index=1;
include("cfg.php");
$ajax = request::get_get('ajax');
if ($ajax) {
    if (login()) {
        db_query('UPDATE users SET online = %d WHERE name = %s', time(), $usr->login);
        DEFINE('TZ',($usr->timezone-$server_time)*3600);
    } else {
        DEFINE('TZ',0);
    }
    include("inc/ajax/" . sfin($ajax) . ".inc");
    die;
}

include("inc/head.php");
include("inc/top.php");

if (isset($_GET['post'])) {
    include("inc/spost.php");
} else {
    include("inc/post.php");
}


include("inc/foot.php");
?>
