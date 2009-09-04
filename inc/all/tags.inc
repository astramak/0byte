<?php
$result=db_query('SELECT * FROM `tags` WHERE `num` > 0 ORDER BY `num` DESC');
echo render_template(TPL_FRAMES.'/tags.tpl.php', array('tags'=>generate_tag_array($result)));
?>
