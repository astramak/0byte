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
if (isset($_GET['pg'])) {
	$pg=$_GET['pg'];
} else {
	$pg='main';
}
//user cfg
include("config.php");
//end of user cfg

$sql=mysql_connect($sql_srv,$sql_usr,$sql_pwd) or die ('e1');
mysql_select_db($sql_db) or die ('e2');
$sqs="SET NAMES UTF8";
mysql_query($sqs,$sql);

//lib load
include("lib/blog.inc");
include("lib/comment.inc");
include("lib/post.inc");
include("lib/menu.inc");
include("lib/seq.php");
include("lib/tag.inc");
include("lib/pm.inc");
include("lib/text.inc");
include("lib/user.inc");
include("lib/cache.inc");
include("lib/geshi/geshi.php");
include("lib/tmplr.inc");
include("lib/flw.inc");
include("lib/json.inc");
//end
if (!isset($_GET['debug'])) ini_set ('display_errors', 0);

$ma=new mn;
$ma->title=$s_name;
$ma=cmenu($ma);
$usr=new user;
function crl($a) {
	if ($a==0) {
		echo '<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>';
	} else {
		echo '<b class="b4"></b><b class="b3"></b><b class="b2"></b><b class="b1"></b>';
	}
}
?>