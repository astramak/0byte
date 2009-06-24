<?php
if ($usr->login == $row['auth']) {
	redirect($site . 'post/' . $row['id']);
}

$id = request::get_get('id');

$flw = db_result(db_query('SELECT flw FROM post WHERE id = %d', $id));
if (request::get_get('un')) {
	$lst = flrm($flw, $usr->login);
	$lnk = "";
	$txt = "Отслеживать";
} else {
	$lst = fladd($flw, $usr->login);
	$lnk = "&un=1";
	$txt = "Перестать отслеживать";
}

db_query('UPDATE post SET flw = %s WHERE id = %d', $id);
if ($json) {
	echo '{
	"lnk" : "javascript: x_r(\'twork.php?wt=flw&id='.$id.$lnk.'&json=1\',\'f\')" ,
	"txt" : "'.$txt.'"
	}';
}
jkill();
redirect($site . 'post/' . $id);
?>