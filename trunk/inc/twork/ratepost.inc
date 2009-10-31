<?php
if ($usr->rate()<$pr_rate) {
    j_err("У вас недостаточно рейтинга для этого действия!");
    jkill();
    redirect($dir.'error/not_allow');
}
$id = request::get_get('id');
$rate = request::get_get('rate');

$lst = request::get_get('from');
$lst = str_replace("*amp", "&", $lst);
$lst = str_replace("*qw", "?", $lst);
$lstw = strrpos($lst, "hl");

if ($lstw !== false) {
    $lst = substr($lst, 0, $lstw) . "hl=$id#hl";
} elseif (strstr($lst, "?") !== false) {
    $lst .= "&hl=$id#hl";
} else {
    $lst .= "?hl=$id#hl";
}

$voted = db_result(db_query('SELECT COUNT(id) FROM rate WHERE who = %s AND pid = %d', $usr->login, $id));
if ($voted) {
    if ($json == 1) {
        j_err("Вы уже голосовали!");
    }
    jkill();
    redirect($lst);
} else {
    $result = db_query('SELECT * FROM post WHERE id = %d', $id);
    $row = db_fetch_assoc($result);
    if (time()-$row['date']>$post_rate_time_limit) {
//        db_query("DELETE FROM `rate` WHERE `pid` = %d", $id);
        if ($json==1) {
            j_err("Время голосования за этот пост истекло");
        }
        jkill();
        redirect($lst);
    }
    if (($row['blck']-$row['blck']%10)/10==1 || ($row['blck']-$row['blck']%10)/10==11) {
        if ($json==1) {
            j_err("За этот пост запрещено голосовать!");
        }
        jkill();
        redirect($lst);
    } else 	if ($row['auth'] == $usr->login) {
            if ($json==1) {
                j_err("За свой пост нельзя голосовать!");
            }
            jkill();
            redirect($lst);
        } else {
            if ($rate == 'p') {
                db_query('UPDATE post SET ratep = ratep + 1 WHERE id = %d', $id);
                db_query('UPDATE users SET prate = prate + 1 WHERE name = %s', $row['auth']);
            } else {
                db_query('UPDATE post SET ratem = ratem + 1 WHERE id = %d', $id);
                db_query('UPDATE users SET prate = prate - 1 WHERE name = %s', $row['auth']);
            }
            db_query('INSERT INTO rate SET who = %s, pid = %d', $usr->login, $id);

            if ($json == 1) {
                $rr = $rate == 'p' ? 1 : -1;
                echo json_encode(array('id'=>$id,'rate'=> $row['ratep'] - $row['ratem'] + $rr,'title'=>
                        'Всего '.($row['ratep']+$row['ratem']+1).' '.inducing($row['ratep']+$row['ratem']+1, array('голоса','голосов','голос'))));
                }
            jkill();
            redirect($lst);
        }
}
?>