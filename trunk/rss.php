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
header("content-type: application/rss+xml"); 
if (isset($_GET['pg'])) {
	if ($_GET['pg']=="main") {
		$sql_get="SELECT * FROM `post` WHERE `blogid`!= 0 && `blck` = 0 ORDER BY  id DESC LIMIT 100";
		$lnk=$site."main";
		$title="Персональное на ".$ls_name;
	} else if ($_GET['pg']=="pers") {
		$sql_get="SELECT * FROM `post` WHERE `blogid`= 0 && `blck` = 0 ORDER BY  id DESC LIMIT 100";
		$title="Коллективное на ".$ls_name;
		$lnk=$site."pers";
	}
} else if (isset($_GET['blog'])) {
	$sql_get="SELECT * FROM `post` WHERE `blogid`= ".gint($_GET['blog'])." && `blck` = 0 ORDER BY  id DESC LIMIT 100";
	$lnk=$site."blog/".gint($_GET['blog']);
	$sqlg="SELECT * FROM `blogs` WHERE `id`= ".gint($_GET['blog']);
	$result=mysql_query($sqlg,$sql);
	$row = mysql_fetch_assoc($result);
	$title=$ls_name." Блог ".$row['name'];
} else if (isset($_GET['auth'])) {
	$sql_get="SELECT * FROM `post` WHERE `auth`= '".mysql_escape_string(gtext($_GET['auth']))."' && `blck` = 0 ORDER BY  id DESC LIMIT 100";
	$title=$ls_name."Посты от ".$_GET['auth'];
	$lnk=$site."auth/".$_GET['auth'];
} else if (isset($_GET['lenta'])) {
	$name=base64_decode($_GET['lenta']);
	$sql_get="SELECT * FROM `post` WHERE ";
	$sl="SELECT * FROM `inblog` WHERE  `name` = '".$name."' &&  `out` = 0 ORDER BY  id DESC ";
	$rt=mysql_query($sl,$sql);
	$rwo = mysql_fetch_assoc($rt);
	$sql_get.="`blogid` = '".$rwo['blogid']."'";
	while ($rwo = mysql_fetch_assoc($rt)) {
		$sql_get.=" || `blogid` = '".$rwo['blogid']."'";
	}
	$sl="SELECT * FROM `users` WHERE  `name` = '".$name."'";
	$rt=mysql_query($sl,$sql);
	$rwo = mysql_fetch_assoc($rt);
	$arr=split(",",$rwo['frnd']);
	$q=sizeof($arr);
	for ($z=1;$z<$q;$z++) {
		$f=trim($arr[$z]);
		$sql_get.=" || `auth` = '".$f."'";
	}
	$sql_get.=" ORDER BY  id DESC LIMIT 100";
	$title="Персональная лента ".$name;
} else {
	$sql_get="SELECT * FROM `post` WHERE ratep >= ratem && `blck` = 0 ORDER BY  id DESC LIMIT 100";
	$title=$ma->title;
	$lnk=$site;
}
echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<rss version=\"2.0\">
<channel>
<title>".htmlspecialchars($title)."</title>
<link>".$lnk."</link>
<description>".htmlspecialchars($title)."; rss канал</description>
 <language>ru-ru</language>

";
$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if ($row['blogid']==0 ) {
		$us=$row['auth'];
		} else {
			$us=$row['blog'];
		}
		echo '<pubDate>'.
date("r", $row['date']).
'</pubDate>
<item>
<title>'.htmlspecialchars($us).' -&gt;'.htmlspecialchars($row['title']).'</title>
<link>'.$site.'post/'.$row['id'].'</link>
<description>'.htmlspecialchars(code(str_replace("[cut]"," ",str_replace("[fcut]"," ",$row['text'])))).
'</description>
<pubDate>'.
date("r", $row['date']).
'</pubDate>
<guid>'.$site.'post/'.$row['id'].'</guid>
</item>';

	while ($row = mysql_fetch_assoc($result)) {
	if ($row['blogid']==0) {
		$us=$row['auth'];
		} else {
			$us=$row['blog'];
		}
		echo '
<item>
<title>'.htmlspecialchars($us).' -&gt;'.htmlspecialchars($row['title']).'</title>
<link>'.$site.'post/'.$row['id'].'</link>
<description>'.htmlspecialchars(code(str_replace("[cut]"," ",str_replace("[fcut]"," ",$row['text'])))).
'</description>
<category>'.
htmlspecialchars($us).
'</category>
<pubDate>'.
date("r", $row['date']).
'</pubDate>
<guid>'.$site.'post/'.$row['id'].'</guid>
</item>';
	}
?>
</channel>
</rss>