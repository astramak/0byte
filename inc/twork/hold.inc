<?php
if ($usr->lvl>=$hlvl) {
    db_query("UPDATE `post` SET `top` = %d WHERE `id` = %d LIMIT 1",db_result(db_query("SELECT `top`,`id` FROM `post` WHERE `id`=%d",request::get_get('id')))?0:1,request::get_get('id'));
    redirect($dir.'post/'.request::get_get('id'));
} else {
    redirect($dir.'error/not_allow');
}
?>
