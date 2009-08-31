<?php
$id = request::get_get('id');
$result = db_query('SELECT * FROM blogs WHERE id = %d', $id);
$ro = db_fetch_assoc($result);
if ($ro['owner'] != $usr->login) {
    $result = db_query('SELECT * FROM inblog WHERE blogid = %d AND name = %s', $id, $usr->login);
    $row = db_fetch_assoc($result);

    if ($row['name'] == $usr->login) {
        if ($row['out'] == 1) {
            db_query('UPDATE inblog SET out = 0 WHERE blogid = %d', $id);
        } else {
            db_query('UPDATE inblog SET out = 1 WHERE blogid = %d', $id);
        }
    } else {
        db_query('INSERT INTO inblog SET blogid = %d, name = %s, bname = %s', $id, $usr->login, $ro['name']);
    }
}
redirect('index.php?blog=' . $id);
?>