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
include("inc/head.php");
include("inc/top.php");
?>
<?php 
if (isset($_GET['post'])) {
	include("inc/spost.php"); 
	$tpl->assign("post",1);
} else {
	include("inc/post.php");
	$tpl->assign("post_list",1);
}
?>
<?php

include("inc/foot.php");
?>
