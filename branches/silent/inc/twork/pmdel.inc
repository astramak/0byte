<?php
$id = request::get_get('id');
pm_del($id);
jkill();
$lst = request::get_get('cur');
$lst = str_replace("*amp", "&", $lst);
$lst = str_replace("*qw", "?", $lst);
redirect($lst);
?>