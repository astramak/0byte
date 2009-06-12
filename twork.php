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
$logged=login();
$loged=$logged;
if (isset($_GET['json'])) {
	$json=1;
	header("Content-Type: text/html; charset=utf-8");
} else {
	$json=0;
}
if ($logged==0) {
	if ($json==1) die;
	header("Request-URI: login.php");
	header("Content-Location: login.php");
	header("Location: login.php");
} else {
	include("inc/twork/".sfin($_GET['wt']).".inc");
}
?>