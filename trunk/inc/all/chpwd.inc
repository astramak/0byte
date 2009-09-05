<?php
if (request::get_get('user') && request::get_get('ld')) {
    $row=db_fetch_assoc(db_query('SELECT * FROM `restore` WHERE `user` = %s && `code` = %s',request::get_get('user'),request::get_get('ld')));
    if ($row['user']==request::get_get('user')) {
        db_query('UPDATE `users` SET `pwd` = %s WHERE `name` = %s LIMIT 1',md5($db_salt.$row['pwd']),$row['user']);
        db_query('DELETE FROM `restore` WHERE `id` = %d',$row['id']);
    }
    echo "<h2>Теперь вы можете войти со своим новым паролем</h2>";
}
?>