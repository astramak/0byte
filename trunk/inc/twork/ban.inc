<?php
$unb = request::get_get('unb');
$who = request::get_get('who');
if ($usr->lvl >= $blvl && strlen($unb) && $who) {
	db_query('UPDATE users SET lck = %d WHERE name = %s', (1 - $unb), $who);
}

$lst = request::get_get('cur');
$lst = str_replace("*amp", "&", $lst);
$lst = str_replace("*qw", "?", $lst);
redirect($lst);
?>