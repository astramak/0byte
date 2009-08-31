<?php
if ($usr->lvl>=$rlvl) {
    $id = request::get_get('id');
    $blck=(request::get_post('comment')=="on")*100+(request::get_post('rate')=="on")*10 +(request::get_post('block')=="on");
    if ($id) {
        db_query('UPDATE post SET blck = %d WHERE id = %d', $blck, $id);
    }
}
redirect('post/' . request::get_get('id'));
?>