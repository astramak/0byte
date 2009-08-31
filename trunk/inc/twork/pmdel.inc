<?php
$id = request::get_get('id');
$result = db_query('SELECT * FROM pm WHERE id = %d', $id);
$row = db_fetch_assoc($result);
if ($row['auth'] == $usr->login) {
    if ($row['dto'] == 2) {
        db_query('DELETE FROM pm WHERE id = %d', $id);
    }  else {
        db_query('UPDATE pm SET dto = 1 WHERE id = %d', $id);
    }
} elseif ($row['to'] == $usr->login) {
    if ($row['dto'] == 1) {
        db_query('DELETE FROM pm WHERE id = %d', $id);
    }  else {
        db_query('UPDATE pm SET dto = 2 WHERE id = %d', $id);
    }
}
jkill();
$lst = request::get_get('cur');
$lst = str_replace("*amp", "&", $lst);
$lst = str_replace("*qw", "?", $lst);
redirect($lst);
?>