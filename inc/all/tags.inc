<?php
if (!($cache = readCache('tag_list.cache', 30))) {
    $result=db_query('SELECT * FROM `tags` WHERE `num` >= 1 ORDER BY `num` DESC');
    $cache=render_template(TPL_FRAMES.'/tags.tpl.php', array('tags'=>generate_tag_array($result),'type'=>request::get_get('city',0)==0?'tag':'list/user/city'));
    writeCache($cache,'tag_list.cache');
}
echo $cache;
?>
