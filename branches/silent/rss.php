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
include("cfg.php");

if (request::get_get('pg')) {
	$pg = request::get_get('pg');
	if ($pg == "main") {
		$sql_get = "SELECT * FROM post WHERE blogid != 0 && blck = 0 && ".get_special_blogs()." && ( `lock` = 0 || ".get_special()." )  ORDER BY id DESC";
		$lnk = $site . "main";
		$title = "Персональное на " . $ls_name;
	} elseif ($pg == "pers") {
		$sql_get = "SELECT * FROM post WHERE blogid = 0 && blck = 0 && ".get_special_blogs()." && ( `lock` = 0 || ".get_special()." ) ORDER BY id DESC";
		$title = "Коллективное на " . $ls_name;
		$lnk = $site . "pers";
	}
} elseif (request::get_get('blog')) {
	$blogid = intval(request::get_get('blog'));
	$sql_get="SELECT * FROM post WHERE blogid = " . $blogid . " AND blck = 0 ORDER BY id DESC";
	$lnk = $site . "blog/" . $blogid;
	$title = $ls_name . " Блог " . db_result(db_query('SELECT name FROM blogs WHERE id = %d', $blogid));
} elseif (request::get_get('auth')) {
	$auth = request::get_get('auth');
	$sql_get = "SELECT * FROM post WHERE auth = " . _db_escape_string($auth) . " AND blck = 0 ORDER BY id DESC";
	$title = $ls_name . "Посты от " . $auth;
	$lnk = $site . "auth/" . $auth;
} elseif (request::get_get('lenta')) {
	$name = base64_decode(request::get_get('lenta'));
	$where = array();

	$result = db_query('SELECT blogid FROM inblog WHERE name = %s AND `out` = 0 ORDER BY id DESC', $name);
	$ids = array();
	while ($row = db_fetch_object($result)) $ids[] = $row->blogid;
	if ($ids) $where[] = 'blogid IN (' . implode(',', $ids) . ')';

	$frnd = db_result(db_query('SELECT frnd FROM users WHERE name = %s', $name));
	if ($frnd) {
		$arr = explode(',', $frnd);
		trim_array($arr, '_db_escape_string');
		if ($arr) $where[] = 'auth IN (' . implode(',', $arr) . ')';
	}

	$sql_get = 'SELECT * FROM post WHERE ';
	if ($where) {
		$sql_get .= implode(' OR ', $where);
	} else {
		$sql_get .= '0';
	}
	$sql_get .= ' ORDER BY id DESC';
	$title = "Персональная лента " . $name;
} else {
	$sql_get = 'SELECT * FROM `post` WHERE `ratep` >= `ratem` and `blck` = 0  and '.get_special_blogs().'   ORDER BY `id` DESC';
	$title = $s_name;
	$lnk = $site;
}

$result = db_query($sql_get . ' LIMIT 30');
$items = array();
while ($row = db_fetch_assoc($result)) {
	$items[] = prepare_rss_post_item($row);
}

header("Content-type: application/rss+xml");
echo render_rss('posts', $title, $lnk, $items);

function prepare_rss_post_item($row) {
	global $site;

	$post_url = $site . 'post/' . $row['id'];
	$cut_url = $post_url;

	$has_cut = (strpos($row['text'], '[cut]') !== false);
	$has_fcut = (strpos($row['text'], '[fcut]') !== false);
	$row['descr'] = code(str_replace("[cut]", " ", str_replace("[fcut]", " ", $row['text'])));
	if ($has_cut || $has_fcut) {
		$row['descr'] .= '<br /><br /><a href="' . $cut_url . '">Полностью...</a>';
	}

	return $row;
}
?>
