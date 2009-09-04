<?php
if ($usr->rate()<$ur_rate || $no_user_rate) {
    j_err("У вас недостаточно рейтинга для этого действия!");
    jkill();
    redirect($dir.'error/not_allow');
}
$lst = request::get_get('from');
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);

$name = request::get_get('name');
$type = request::get_request('rate') == 'p' ? 1 : 2;

$result = db_query('SELECT * FROM urate WHERE who = %s AND pid = %s', $usr->login, $name);
$row = db_fetch_assoc($result);

$nr = $row['pid'] == $name ? 2 : 1;

if ($row['pid'] == $name && $row['type'] == $type) {
    j_err("Нельзя дважды поднимать или опускать рейтинг!");
    jkill();
    redirect($lst);
} else {
    $result = db_query('SELECT * FROM users WHERE name = %s', $name);
    $row = db_fetch_assoc($result);
    if ($row['name'] == $usr->login) {
        j_err("Нельзя голосовать за себя!");
        jkill();
        redirect($lst);
    } else {
        if ($type == 1) {
            db_query('UPDATE users SET ratep = ratep + %d WHERE name = %s', $nr, $name);
        } else {
            db_query('UPDATE users SET ratem = ratem + %d WHERE name = %s', $nr, $name);
        }
        db_query('DELETE FROM urate WHERE who = %s AND pid = %s LIMIT 1', $usr->login, $name);
        db_query('INSERT INTO urate SET who = %s, pid = %s, type = %d', $usr->login, $name, $type);

        if ($json == 1) {
            $rr = $type == 1 ? $nr : (0 - $nr);
            $otr = $row['ratep'] - $row['ratem'] + $rr;
            $otr += $row['brate'] / $blog_r + $row['crate'] / $com_r + $row['prate'] / $post_r;
            cmpl($name, $otr);
            die;
        }
        redirect($lst);
    }
}
?>