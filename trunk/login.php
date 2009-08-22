<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it andor modify
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
include ("cfg.php");
$reg = 1;
$js = request::get_get("js",0);
if ($js) {
	header("Content-Type: text/html; charset=utf-8");
}

$cur = request::get_get("cur");
if (strlen($cur) < 3) {
	$lst = $site;
} else {
	$lst = $cur;
	$lst = str_replace("*amp", "&", $lst);
	$lst = str_replace("*qw", "?", $lst);
}

$login = request::get_post('login');
$pwd = request::get_post('pwd');
$err=0;
if (strlen($login) > 2 && strlen($pwd) > 2) {
	$usr->login = $login;
	$usr->pwd = md5($pwd);
	if ($usr->check()) {
		session_start();
		if (request::get_post('zap')) {
			$dt = mktime(0, 0, 0, 1, 1, 2010);
			setcookie('login', request::get_post('login'), $dt);
			// TOFIX: very-very-very unsecure, use md5 or sha1
			setcookie('pwd', base64_encode(request::get_post('pwd')), $dt);
		}
		$_SESSION['login'] = $login;
		// TOFIX: very-very-very unsecure, use md5 or sha1
		$_SESSION['pwd'] = base64_encode($pwd);
		redirect($lst);
	} else {
		$err = 1;
	}
} 
if (!$js) {
	include ("inc/head.php");
	include("inc/top.php");
        if ($err) {
        echo render_error('Данные введены неверно!');
    }
}
echo render_login(request::get_post("login", 0), $cur, $js, (request::get_get("new") && $eml_a),$err);

if (!$js) {
	include("inc/foot.php");
}
?>