<?php
if ($usr->lvl >= $blvl) {
    echo render_template(TPL_FRAMES.'/cause.tpl.php', array('type'=>request::get_get('type'),
    'url'=>"twork.php?wt=ban&who=".request::get_get('name')."&cur=user/".request::get_get('name')."&unb=0"));
} else {
    redirect($dir.'error/not_allow');
}
?>
