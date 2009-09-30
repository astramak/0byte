<?php
$id = request::get_get('id');

if ($usr->lvl >= $elvl ) {


tags_remove_list(db_result(db_query('SELECT tag FROM post WHERE id = %d', $id)));
db_query('DELETE FROM post WHERE id = %d', $id);
$result = db_query('SELECT id FROM comment WHERE krnl = %d', $id);
while ($row = db_fetch_object($result)) {
    rmcom($row);
}

redirect($site);
} else {
    redirect($dir.'error/not_allow');
}
?>