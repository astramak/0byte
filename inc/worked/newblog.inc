<?php
if ($usr->rate()>=$nb_rate) {
    echo render_template(TPL_FRAMES.'/new_blog.tpl.php', null);
} else {
    redirect($dir.'error/not_allow');
}
?>