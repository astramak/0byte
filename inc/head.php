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

ob_start("ob_gzhandler");
$loged=login();
if ($loged) {
	db_query('UPDATE users SET online = %d WHERE name = %s', time(), $usr->login);
        DEFINE('TZ',($usr->timezone-$server_time)*3600);
//        echo $usr->timezone;
} else {
        DEFINE('TZ',0);
}
$post_id = intval(request::get_get('post'));

$vars = array();

if ($post_id && !isset($_GET['wt'])) {
	$row = db_fetch_assoc(db_query('SELECT `blogid`,`auth`,`blog`,`title` FROM `post` WHERE `id` = %d', $post_id));
	if ($row['blogid'] == 0) {
		$blog = $row['auth'];
	} else {
		$blog = $row['blog'];
	}
	$vars['title'] = $sl_name."/".$blog." &#8212; ".$row['title'];
} else {
// FIXME: why did you removed $ma instance initialization but left this piece of code?
	$vars['title'] = $s_name;
//$ma->gt();
}

if ($post_id) {
	$tags = db_result(db_query('SELECT tag FROM post WHERE id = %d', $post_id));
	$vars['kwd'] = str_replace(',', ', ', $tags);
} else {
	if (!$vars['kwd'] = readCache('kwd.cache', 30)) {
		$result = db_query('SELECT name FROM tags WHERE num > 0 ORDER BY num DESC LIMIT 10');
		$tags = array();
		while ($row = db_fetch_object($result)) $tags[] = $row->name;
		$vars['kwd'] = implode(', ', $tags);
		writeCache($vars['kwd'], 'kwd.cache');
	}
}

$pg = request::get_get('pg');
$blog = intval(request::get_get('blog'));
$auth = request::get_get('auth');

if ($pg) {
	if ($pg == 'lenta' && $loged == 1) {
		$vars['rss'] = "rss/lenta/" . base64_encode($usr->login);
	} else {
		$vars['rss'] = "rss/" . gtext($pg);
	}
} elseif ($blog) {
	$vars['rss'] = "rss/blog/" . $blog;
} elseif ($auth) {
	$vars['rss'] = "rss/auth/" . gtext($auth);
} else {
	$vars['rss'] = "rss";
}
$vars['base']="http://".$_SERVER['SERVER_NAME'].$dir;
if (!$native_script) {
    $SCRIPT="";
}
 if (@count($script_plugins)>0) {
         foreach($script_plugins as $plugin) {
            include('plugins/'.$plugin['name'].'/actions.php');
        }
    }
$script=new script;
$vars['SCRIPT']=$SCRIPT;
echo render_template(TPL_ROOT . '/head.tpl.php', $vars);
?>