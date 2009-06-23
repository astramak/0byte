<?php
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
	if ($row['auth'] == $usr->login) {
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
			cmpl($id, $row['ratep'] - $row['ratem'] + $rr);
		}
		jkill();
		redirect($lst);
	}
}
?>