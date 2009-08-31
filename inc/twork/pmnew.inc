<?php
$to = request::get_post('to');
$title = request::get_post('title');
$text = request::get_post('text');

if (!isset($title{2}) || !isset ($text{2}) || !isset($to{2})) {
    redirect('work/pmls');
}

$alien=new user();
if (!$alien->find($to) || $alien->login == $usr->login) {
    redirect('work/pmls');
}

$sql_get="SELECT * FROM `users` WHERE `name` = '".mysql_escape_string($to)."' ORDER BY  id DESC  ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
    echo  mysql_error();
}

$row = mysql_fetch_assoc($result);
if (strlen($row['name'])<1) {
    redirect('work/pmls');
}
if (request::get_get('lock') == "on" ) {
    $lock=1;
} else {
    $lock=0;
}

$time=time();
$sl="INSERT INTO `pm` (`date` ,`title`,`auth`, `text` ,`to` )
VALUES ( '".$time."', '".mysql_escape_string(gtext($title))."' ,
'".$usr->login."' ,'".mysql_escape_string(gtext($text))."'
,'$to' )";
$result=mysql_query($sl,$sql);

$sl="SELECT * FROM `pm` WHERE `date` = '".$time."'";
$result=mysql_query($sl,$sql);
$rw = mysql_fetch_assoc($result);

if ($row['pmre'] == 1) {
    $to = $row['mail'];
    $subject = "Личное сообщение на ".$s_name;
    $message = render_mail('new_pm', array(
        'user' => $usr->login,
        'pm_id' =>$rw['id'],
    ));
    $headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
    nullbyte_mail($to, $subject, $message, true, $headers);
}
redirect('work/pmls/1');
?>