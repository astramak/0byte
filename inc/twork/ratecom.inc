<?php
if ($usr->rate()<$cr_rate) {
    j_err("У вас недостаточно рейтинга для этого действия!");
    jkill();
    redirect($dir.'error/not_allow');
}
$lst = request::get_get('from');
$lst = str_replace("*amp","&",$lst);
$lst = str_replace("*qw","?",$lst);
$lstw = strrpos($lst,"hl");

$id = request::get_get('id');

if ($lstw != false) {
    $lst = substr($lst, 0, $lstw) . "hl=$id#hl";
} elseif (strstr($lst, "?") != false) {
    $lst .= "&hl=$id#hl";
} else {
    $lst .= "?hl=$id#hl";
}

$voted = db_result(db_query('SELECT COUNT(id) FROM crate WHERE who = %s AND pid = %d', $usr->login, $id));
if ($voted) {
    j_err("Повторное голосование запрещено!");
    jkill();
    redirect($lst);
} else {
    $row = db_fetch_assoc(db_query('SELECT * FROM comment WHERE id = %d', $id));
    if ($row['who'] == $usr->login) {
        j_err("Нельзя голосовать за свой комментарий!");
        jkill();
        redirect($lst);
    } else {
        $rate = request::get_get('rate');
        if ($rate == 'p') {
            db_query('UPDATE comment SET ratep = ratep + 1 WHERE id = %d', $id);
            db_query('UPDATE users SET crate = crate + 1 WHERE name = %s', $row['who']);
        } else {
            db_query('UPDATE comment SET ratem = ratem + 1 WHERE id = %d', $id);
            db_query('UPDATE users SET crate = crate - 1 WHERE name = %s', $row['who']);
        }
        db_query('INSERT INTO crate SET who = %s, pid = %d', $usr->login, $id);
        if ($json == 1) {
            if ($rate == 'p') {
                $rr = 1;
            } else {
                $rr = -1;
            }
            cmpl($id, $row['ratep'] - $row['ratem'] + $rr);
            die;
        }
        redirect($lst);
    }
}
?>