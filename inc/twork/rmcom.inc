<?php
$id = request::get_get('id');

$result = db_query('SELECT * FROM comment WHERE id = %d', $id);
$row = db_fetch_assoc($result);
if (!$row || $usr->lvl < $elvl) {
	$lst = "post/".$row['krnl']."#cmnt".$_GET['id'];
	header("Request-URI: $lst");
	header("Content-Location: $lst");
	header("Location: $lst");
	die;
}
rmcom(new com($row));
$lst = $site . "post/" . $row['krnl'];
header("Request-URI: $lst");
header("Content-Location: $lst");
header("Location: $lst");
?>