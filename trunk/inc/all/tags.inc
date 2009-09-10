<?php
if (request::get_get('city',0)) {
    $name='city';
} else {
    $name='tag';
}
if (!($cache = readCache($name.'_list.cache', 30))) {
    if (request::get_get('city',0)) {
        $result=db_query('SELECT DISTINCT * FROM (SELECT `city` as `name`,COUNT(`city`) as `cnt` FROM `users` WHERE `name`!="" GROUP BY `name`) ORDER BY `cnt` DESC');
    } else {
        $result=db_query('SELECT * FROM `tags` WHERE `num` > 0 ORDER BY `num` DESC');
    }
    $cache=render_template(TPL_FRAMES.'/tags.tpl.php', array('tags'=>generate_tag_array($result),'type'=>request::get_get('city',0)==0?'tag':'list/user/city'));
     writeCache($cache,$name.'_list.cache');
}
echo $cache;
?>
