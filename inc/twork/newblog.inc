<?php
$btitle = trim(request::get_post('btitle'));

if ($usr->rate() < $nb_rate || strlen($btitle) < 3) {
	redirect('index.php');
}

$exists = db_result(db_query('SELECT COUNT(id) FROM blogs WHERE LOWER(name) = LOWER(%s)', $btitle));
if ($exists) {
	redirect('index.php');
}

db_query('INSERT INTO blogs SET name = %s, owner = %s', $btitle, $usr->login);
$id = db_last_insert_id('blogs');
db_query('INSERT INTO inblog SET blogid = %d, name = %s, bname = %s', $id, $usr->login, $btitle);

redirect("work/newpost");
?>