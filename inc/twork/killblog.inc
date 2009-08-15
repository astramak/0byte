<?php
$id = request::get_get('id');
$owner = db_result(db_query('SELECT owner FROM blogs WHERE id = %d', $id));
if ($owner == $usr->login || $usr->lvl>=$elvl) {
	db_query('DELETE FROM blogs WHERE id = %d', $id);
	db_query('DELETE FROM inblog WHERE blogid = %d', $id);
	db_query('DELETE FROM brate WHERE pid = %d', $id);
	db_query('UPDATE post SET blog = "own", blogid = 0 WHERE blogid = %d', $id);
}
redirect('work/myblog');
?>