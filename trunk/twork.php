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
$logged = login();
// TODO: why do we need one more variable with the same value?
$loged = $logged;
$json = request::get_get('json');
if ($json) {
	header("Content-Type: text/html; charset=utf-8");
}

if ($logged == 0) {
	if (!$jsons) {
		header("Request-URI: login.php");
		header("Content-Location: login.php");
		header("Location: login.php");
	}
} else {
	include("inc/twork/" . sfin($_GET['wt']) . ".inc");
}
?>