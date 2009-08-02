<?php
$unb = request::get_get('unb');
$who = request::get_get('who');
echo $who;
if ($usr->lvl >= $blvl && strlen($unb)) {
	db_query('UPDATE users SET lck = %d WHERE name = %s', (1 - $unb), $who);

        if (!$unb) {db_query("INSERT INTO `block_user` (`user` ,`cause` ,`end`) VALUES (%s, %s, %s)",$who,request::get_post('cause'),
       (time()+request::get_post('end'))); } else {
        db_query("DELETE FROM `block_user` WHERE `user` = %d LIMIT 1",$who);
       }
//   echo "INSERT INTO `block_user` (`user` ,`cause` ,`end`) VALUES ('$who', '".request::get_post('cause')."', '".time()+request::get_post('end')."')";
// echo 1;
}

$lst = request::get_get('cur');
$lst = str_replace("*amp", "&", $lst);
$lst = str_replace("*qw", "?", $lst);
redirect($lst);
?>