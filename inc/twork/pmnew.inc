<?php
$to = htmlspecialchars(request::get_post('to'));
$title = gtext(request::get_post('title'));
$text = gtext(request::get_post('text'));

if (!isset ($text{2}) || !isset($to{2})) {
    redirect('work/pmls');
}
if (!isset($title{2})) {
    $title='no-title';
}
$alien=new user();
if (!$alien->find($to,'mail, pmre',1) || $alien->login == $usr->login) {
    redirect('work/pmls');
}

//$result=db_query("SELECT * FROM `users` WHERE `name` = '".mysql_escape_string($to)."' ORDER BY  id DESC  ");
//$row = mysql_fetch_assoc($result);
//if (strlen($row['name'])<1) {
//    redirect('work/pmls');
//}
if (request::get_get('lock') == "on" ) {
    $lock=1;
} else {
    $lock=0;
}

$time=time();

$result=db_query("INSERT INTO `pm` (`date` ,`title`,`auth`, `text` ,`to` )
VALUES ( %s , %s ,%s , %s, %s )",$time, $title, $usr->login, $text, $to);

if ($usr->pmr == 1) {
    $to = $usr->mail;
    $subject = "Личное сообщение на ".$s_name;
    $message = render_mail('new_pm', array(
        'user' => $usr->login,
        'pm_id' =>db_last_insert_id('pm'),
    ));
    $headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
    nullbyte_mail($to, $subject, $message, true, $headers);
}
redirect('work/pmls/out');
?>