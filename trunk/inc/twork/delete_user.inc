<?php
$a=md5(session_id());
session_destroy();
$a1=ord($a[2]);
$a2=ord($a[4]);
$zn=ord($a[6]);
while ($a1>15) {$a1=$a1-10; }
while ($a2>15) {$a2=$a2-10; }
if ($zn%2==0) {
    $res=$a1+$a2;
} elseif ($zn%3==0) {
    $res=$a1*$a2;
} else {
    $res=$a1-$a2;
}
if (request::get_post('kap') == $res) {
    db_query('UPDATE `users` SET `lck` = %d WHERE `name` = %s', request::get_post('type')=='bdsm'?3:2, $usr->login);
    redirect($dir);
} else {
    redirect($dir.'work/delete_user/error');
}

?>
