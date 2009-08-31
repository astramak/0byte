<?php
if (request::get_get('tp')) {
    $result = db_query('SELECT * FROM pm WHERE auth = %s AND dto != 1 ORDER BY id DESC');
} else {
    $result = db_query('SELECT * FROM pm WHERE to = %s AND dto != 2 ORDER BY id DESC');
}

while($row = db_fetch_assoc($result)) {
    pm_ls($row);
}
?>