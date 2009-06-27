<?php
$lst = request::get_get('from');
$lst = str_replace("*amp","&",$lst);
$lst = str_replace("*qw","?",$lst);

$id = request::get_get('id');

if (db_result(db_query('SELECT COUNT(id) FROM brate WHERE who = %s AND pid = %d', $usr->login, $id))) {
	j_err("Повторное голосование запрещено!");
	jkill();
	redirect($lst);
} else {
	$result = db_query('SELECT * FROM blogs WHERE id = %d', $id);
	$row = db_fetch_assoc($result);
	if ($row['owner'] == $usr->login) {
		j_err("Нельзя голосовать за свой блог!");
		jkill();
		redirect($lst);
	} else {
		if (request::get_get('rate') == 'p') {
			db_query('UPDATE blogs SET ratep = ratep + 1 WHERE id = %d', $id);
			db_query('UPDATE users SET brate = brate + 1 WHERE name = %s', $row['owner']);
			$rr = 1;
		} else {
			db_query('UPDATE blogs SET ratem = ratem + 1 WHERE id = %d', $id);
			db_query('UPDATE users SET brate = brate - 1 WHERE name = %s', $row['owner']);
			$rr = -1;
		}
		$sql_get="SELECT * FROM `urate`";
		db_query('INSERT INTO brate SET who = %s, pid = %d', $usr->login, $id);
		if ($json == 1) {
			cmpl($id, $row['ratep'] - $row['ratem'] + $rr);
		}
		jkill();
		redirect($lst);
	}
}
?>