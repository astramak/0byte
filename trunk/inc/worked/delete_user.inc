<?php
$content=render_template(TPL_FRAMES.'/delete_user.tpl.php', array('json' => @$json));
if (@$json) {
   $out['content']=$content;
} else {
    echo $content;
}
if (request::get_get('error',0)) {
    echo render_error("Капча введена неверно!");
}
?>
