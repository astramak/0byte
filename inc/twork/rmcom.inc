<?php
$id = request::get_get('id');

$result = db_query('SELECT * FROM comment WHERE id = %d', $id);
$row = db_fetch_assoc($result);
if (!$row || $usr->lvl < $elvl) {
	redirect("post/" . $row['krnl'] . "#cmnt" . $id);
	die;
}
rmcom(new com($row));
redirect($site . "post/" . $row['krnl']);
?>