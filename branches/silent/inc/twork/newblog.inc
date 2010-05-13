<?php
if ($usr->rate()<$nb_rate) {
    j_err("У вас недостаточно рейтинга для этого действия!");
    jkill();
    redirect($dir.'error/not_allow');
}
$btitle = gtext(trim(request::get_post('btitle')));

if ($usr->rate() < $nb_rate || strlen($btitle) < 3) {
    redirect($dir.'error/not_allow');
}

$exists = db_result(db_query('SELECT COUNT(id) FROM blogs WHERE LOWER(name) = LOWER(%s)', $btitle));
if ($exists) {
    redirect($dir.'error/new_blog_used');
}

db_query('INSERT INTO blogs SET name = %s, owner = %s, about = %s', $btitle, $usr->login, gtext(request::get_post('about')));
$id = db_last_insert_id('blogs');
db_query('INSERT INTO inblog SET blogid = %d, name = %s, bname = %s', $id, $usr->login, $btitle);

redirect("work/newpost");
?>