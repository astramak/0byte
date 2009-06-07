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
ob_start("ob_gzhandler");
$loged=login();
if ($loged==1) {
	$sql_get="UPDATE `users` SET online = '".time()."' WHERE `users`.`name` ='".$usr->login."'";
	$result=mysql_query($sql_get,$sql);
}
if (isset($_GET['post'])) {
	$post11=gint($_GET['post']);
}
echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
<base href="<?php echo "http://".$_SERVER['HTTP_HOST'].$dir; ?>" />
<title><?php 
if (isset($_GET['post']) && !isset($_GET['wt'])) {
	$sql_get="SELECT * FROM `post` WHERE id = '".gint($_GET['post'])."'   ";
	$result=mysql_query($sql_get,$sql);
	$row = mysql_fetch_assoc($result);
	if ($row['blog']=="own") {
		$blog=$row['auth'];
	} else {$blog=$row['blog'];}
	echo $sl_name."/".$blog." &#8212; ".$row['title'];
} else {
	$ma->gt(); }?></title>
<meta name="keywords"
	content="<?php 
		if (!isset($_GET['post'])) {
			ob_start(); 
			if (!$kwd = readCache('kwd.cache', 30)) {
				$sql_get="SELECT * FROM `tags` WHERE num > 0 ORDER BY  num DESC LIMIT 10";
				$result=mysql_query($sql_get,$sql);
				$row = mysql_fetch_assoc($result);
				echo $row['name'];
				while ($row = mysql_fetch_assoc($result)) {
					echo ", ".$row['name'];
				}
			  $kwd = ob_get_contents();
  			  writeCache($kwd,'kwd.cache'); 
			}
 			ob_end_clean();
 			echo $kwd;
		} {
			$sql_get="SELECT * FROM `post` WHERE id = '".gint($_GET['post'])."'   ";
			$result=mysql_query($sql_get,$sql);
			$row = mysql_fetch_assoc($result);
			echo str_replace(',',', ',$row['tag']);
		}
				
		?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" />
<link rel="stylesheet" href="style/css.php?css=new.css" type="text/css" />
<link rel="search" type="application/opensearchdescription+xml"
	href="opensearch.php" title="<?php echo $sl_name; ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS"
	href="<?php 
		if (isset($_GET['pg'])) {
			if ($_GET['pg']=='lenta' && $loged==1) {
				echo "rss/lenta/".base64_encode($usr->login);
			} else {
				echo "rss/".gtext($_GET['pg']);
			}
		} else if (isset($_GET['blog'])) {
			echo "rss/blog/".gint($_GET['blog']);
		} else if (isset($_GET['auth'])) {
			echo "rss/auth/".gtext($_GET['auth']);
		} else {
			echo "rss";
		}
		?>" />
<script type="text/javascript" src="js/js.php?js=main.js"></script>
<script type="text/javascript" src="js/js.php?js=right.js"></script>
<script type="text/javascript" src="js/js.php?js=login.js"></script>
<script type="text/javascript" src="js/js.php?js=ve.js"></script>
<script type="text/javascript" src="js/js.php?js=pm.js"></script>
</head>
<body onkeydown="to_(event)">