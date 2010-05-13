<?php
$unb = request::get_get('unb',-1);
$who = request::get_get('who');
if ($usr->lvl >= $blvl && $unb!=-1) {
	db_query('UPDATE `users` SET `lck` = %d WHERE `name` = %s', (1 - $unb), $who);
        if (!$unb) {
            $end=request::get_post('end',0)?1:time()+((request::get_post('day')*24+request::get_post('hour'))*60+request::get_post('minut'))*60;
            db_query("INSERT INTO `block_user` (`user` ,`cause` ,`end`) VALUES (%s, %s, %s)",$who,request::get_post('cause'),
        $end); } else {
        db_query("DELETE FROM `block_user` WHERE `user` = %d LIMIT 1",$who);
       }
}

$lst = request::get_get('cur');
$lst = str_replace("*amp", "&", $lst);
$lst = str_replace("*qw", "?", $lst);
redirect($lst);
?>