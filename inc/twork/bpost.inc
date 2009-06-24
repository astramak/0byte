<?php
$unb = request::get_get('unb');
$id = request::get_get('id');

if ($usr->lvl >= $rlvl && $unb && $id) {
	$un = 1 - $unb;
	db_query('UPDATE post SET blck = %d WHERE id = %d', $un, $id);
}
redirect('index.php?post=' . $id);
?>