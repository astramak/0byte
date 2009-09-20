<?php
$lst = request::get_get('cur');
$lst = str_replace("*amp","&",$lst);
$lst = str_replace("*qw","?",$lst);

$id = request::get_get('id');
$answ = request::get_post('answ',0);

if (request::get_post('nox',0)) {
    if (db_result(db_query('SELECT `id` FROM `wansw` WHERE `who` = %s && `cid` = %d GROUP BY `id`', $usr->login, $id))>0) {
        jkill();
        redirect($lst);
    }
    db_query('INSERT INTO `wansw` SET `who` = %s && `cid` = %d', $usr->login, $id);
    if ($json == 1) {
        echo answ_echo($id);
    }
    jkill();
    redirect($lst);
}
$row = db_fetch_assoc(db_query('SELECT * FROM post WHERE id = %d', $id));
if (!$answ && $row['lnk'] == 0) {
    jkill();
    redirect($lst);
}
print_r($_POST);
if ($row['lnk'] == 1) {
    echo 1;
    $result = db_query('SELECT * FROM answ WHERE cid = %d', $id);
    while ($raw = db_fetch_assoc($result)) {
        if (request::get_post($raw['id']) == 'on') {
            db_query('UPDATE `answ` SET `val` = `val` + 1 WHERE `id` = %d', $raw['id']);
        }
    }
} else {
    if (db_num_rows(db_query('SELECT cid FROM wansw WHERE who = %s && cid = %d', $usr->login, $id))>=1) {
        jkill();
        redirect($lst);
   }
    db_query('UPDATE answ SET val = val + 1 WHERE id = %d', $answ);
}
db_query('INSERT INTO wansw SET who = %s, cid = %d', $usr->login, $id);
if ($json == 1) {
    echo answ_echo($id);
}
jkill();

redirect($lst);
?>