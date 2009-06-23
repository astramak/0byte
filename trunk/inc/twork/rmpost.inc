<?php
if ($usr->lvl<$elvl ) {
	redirect('post/' . request::get_get('id'));
}

$sql_get="SELECT * FROM `post` WHERE id = '".intval($_GET['id'])."'   ";
$result=mysql_query($sql_get,$sql);
$row=mysql_fetch_assoc($result);
tags_remove_list($row['tag']);
$sql_get="DELETE FROM `post` WHERE `post`.`id` = ".intval($_GET['id']);
$result=mysql_query($sql_get,$sql);
$sql_get="DELETE FROM `comment` WHERE `comment`.`krnl` = ".intval($_GET['id']);
$result=mysql_query($sql_get,$sql);

redirect($site);
?>