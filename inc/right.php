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
$e = 0;
$tarr = array();

$result = db_query('SELECT * FROM `post` WHERE `blck` = 0 && `lock` = 0 ORDER BY id DESC LIMIT 16');
$e += db_num_rows($result);
while ($row = db_fetch_assoc($result)) {
    $row['type'] = 'post';
    $row['rate'] = $row['ratep'] - $row['ratem'];
    $tarr[] = $row;
}

$result = db_query('SELECT *, p.id AS pid, p.date as pate
					FROM post p
					INNER JOIN comment c ON p.id = c.krnl
					WHERE p.blck = 0
					ORDER BY c.id DESC
					LIMIT 16');
$e += db_num_rows($result);
while ($row = db_fetch_assoc($result)) {
    $row['type'] = 'comment';
    $row['rate'] = $row['ratep'] - $row['ratem'];
    $tarr[] = $row;
}

$siz = count($tarr) - 1;
for ($i = $siz; $i >= 0; $i--) {
    for ($j = 0; $j <= ($i-1); $j++) {
        if ($tarr[$j]['date'] < $tarr[$j+1]['date']) {
            $k = $tarr[$j];
            $tarr[$j] = $tarr[$j+1];
            $tarr[$j+1] = $k;
        }
    }
}
array_splice($tarr, 16);
echo render_hands_free($tarr,$siz);
echo render_search_panel();
if (!($tops = readCache('tops.cache', CACHE_TIME_LIMIT*10))) {
    $tops = '';
    $result = db_query('SELECT * FROM `tags` WHERE `num` > 0 ORDER BY `num` DESC LIMIT %d',COUNT_TAG); //get tags from db
    $tops .= render_tags(generate_tag_array($result,28,6)); //render tag-cloud
    $city_num = db_num_rows(db_query('SELECT `id`  FROM `users` WHERE `city`!="" GROUP BY `city`'));//get city count
    $users_num = db_result(db_query('SELECT COUNT(`id`) FROM `users`'));//get users count
    $result = db_query('SELECT *, (ratep - ratem) AS rate FROM blogs ORDER BY rate DESC LIMIT %d',TOP_COUNT);//get top blog
    $blogs = array();
    while ($row = db_fetch_assoc($result)) {
        $blogs[] = $row;
    }
    $blogs_num = db_result(db_query('SELECT COUNT(`id`) FROM `blogs`'));//get blogs count
    $result = db_query('SELECT *, (ratep - ratem + prate / %d + crate / %d + brate / %d) AS rate  FROM users WHERE lvl = 0 && lck = 0 ORDER BY rate DESC LIMIT %d', $post_r, $com_r, $blog_r,TOP_COUNT); //get top users from db
    $users = array();
    while ($row = db_fetch_assoc($result)) {
        $row['rate']=(float) $row['rate'];
        $users[] = $row;
    }
    $tops .= render_tops($users, $blogs,$city_num,$users_num,$blogs_num);//render user and blog top
    writeCache($tops,'tops.cache');
}
echo $tops;

$result = db_query('SELECT name FROM users WHERE online >= %d ORDER BY online DESC', time() - 300);
while ($row = db_fetch_assoc($result)) {
    $onlines[] = $row['name'];
}

$result = db_query('SELECT name FROM users ORDER BY id DESC LIMIT 5');
while ($row = db_fetch_assoc($result)) {
    $news[] = $row['name'];
}

echo render_online_and_new($onlines, $news);

$scr='var ulist=document.getElementById("ulister").innerHTML;
var blist=document.getElementById("blist").innerHTML;
if (document.getElementById("ped")) {
var pd=document.getElementById("ped").innerHTML; } else {
var pd=null;
}
if (document.getElementById("ced")) {
var cd=document.getElementById("ced").innerHTML; } else {
var cd=null;
}';
define('NO_PANEL_ACTIVE',0);
define('FIRST_PANEL_ACTIVE',1);
define('SECOND_PANEL_ACTIVE',2);
$e=NO_PANEL_ACTIVE;
if (isset($_SESSION['tp1']) && strlen($_SESSION['tp1'])>2) {
    $scr.="g_plist('".$_SESSION['tp1']."'";
    $e=FIRST_PANEL_ACTIVE;
}
if (isset($_SESSION['tp2'])) {
    if ($_SESSION['tp2']=='us') {
        if ($e==FIRST_PANEL_ACTIVE) {
            $scr.=",1,'top_user');";
            $e=SECOND_PANEL_ACTIVE;
        } else {
            $scr.="g_plist('top_user');";
        }
    } elseif ($_SESSION['tp2']=='bl') {
        if ($e==FIRST_PANEL_ACTIVE) {
            $scr.=",1,'top_blog');";
            $e=SECOND_PANEL_ACTIVE;
        } else {
            $scr.="g_plist('top_blog');";
        }
    }
}
if ($e==FIRST_PANEL_ACTIVE) {$scr.=");";}
$script->add($scr);
?>
