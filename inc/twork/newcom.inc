<?php
if ($usr->rate()<$nc_rate) {
    j_err("У вас недостаточно рейтинга для этого действия!");
    jkill();
    redirect($dir.'error/not_allow');
}
if ($json != 1) {
    $lst = request::get_get('from');
    $lst=str_replace("*amp","&",$lst);
    $lst="/".str_replace("*qw","?",$lst);
}
$lst=null;
$text = request::get_post('text');
if (strlen($text) < 3) {
    if ($json == 1) {
        $out['err']="Вы не ввели комментарий!";
        die(json_encode($out));
    } else {
        redirect($lst);
    }
}

$lvl = request::get_get('lvl', 0, true);
$id = request::get_get('id');
if ($lvl) {
//    $sql_get="SELECT * FROM `comment` WHERE `id` = '".intval($id)."'   ";
//    $result=mysql_query($sql_get,$sql);
    $rw = db_fetch_assoc(db_query("SELECT `krnl`,`who` FROM `comment` WHERE `id` = %d",$id));
    $krnl=$rw['krnl'];
    $ceauth=$rw['who'];
} else {
    $krnl=intval($id);
    $ceauth="";
}

//$sql_get="SELECT * FROM `post` WHERE `id` = '".$krnl."'   ";
$raw = db_fetch_assoc(db_query("SELECT * FROM `post` WHERE `id` = %d ",$krnl));
if ($raw['id'] != $krnl || $id == "" || ($raw['blck']-$raw['blck']%100)/100==1) {
    redirect($lst);
}
$title=$raw['title'];
$pauth=$raw['auth'];
$pid=$raw['id'];
$listp=$raw['flw'];
$text=gtext($text);
$date=time();
db_query("INSERT INTO `comment` (`date` ,`text`,`who`, `cid` , `lvl` , `krnl`)
VALUES ( %s , %s , %s ,%d , %d , %d)",$date,$text,$usr->login,$id,$lvl,$krnl);
db_query("UPDATE `post` SET `last` =  %s WHERE `id` = %d",$date,$krnl);
//$result=mysql_query($sl,$sql);
//$sql_get="SELECT * FROM `comment` WHERE `cid` = '".intval($id)."' && `date`= '".$date."'   ";
//$result=mysql_query($sql_get,$sql);
//$rw = mysql_fetch_assoc($result);
$cm=new comment(db_fetch_assoc(db_query("SELECT * FROM `comment` WHERE `cid` = %d && `date`= %s ",$id,$date)));
$lst.='#cmnt'.$cm->id;
$text=code($text);
if ($ceauth!="" && $ceauth!=$usr->login) {
//    echo $ceauth;
//    $sql_get="SELECT * FROM `users` WHERE `name` = '".$ceauth."'";
//    $result=mysql_query($sql_get,$sql);
    $row = db_fetch_assoc(db_query("SELECT * FROM `users` WHERE `name` = %s",$ceauth));
    add_eye($pid,$ceauth);
    comment_to_lenta($ceauth, $cm->id,$date);
    if ($row['comre']==1) {
        $to = $row['mail'];

        $subject = "Ответ на ваш комментарий на " . $sl_name;

        $message = render_mail('comment_reply', array(
            'user' => $usr->login,
            'pid' => $pid,
            'lst' => $lst,
            'text' => $text,
            'title'=>$title
        ));
        $headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
        nullbyte_mail($to, $subject, $message, true, $headers);
        if (@count($notify_plugins)>0) {
            $notify[]=array('to'=>$row['jabber'],'msg'=>$message);
        }
    }
}
if (strcmp($usr->login,$pauth)!=0 && $lvl==0) {

    $row = db_fetch_assoc(db_query("SELECT * FROM `users` WHERE `name` = %s",$pauth));
    add_eye($pid,$pauth);
    comment_to_lenta($pauth, $cm->id,$date);
    //    $sql_get="DELETE FROM `eye` WHERE `pid`='".$pid."' && `who`='".$pauth."' LIMIT 1";
    //    $result=mysql_query($sql_get,$sql);
    //    $sql_get="INSERT INTO `eye` ( `who` ,`pid`) VALUES ('".$pauth."','".$pid."')";
    //    $result=mysql_query($sql_get,$sql);
    if ($row['postre']==1) {
        $to = $row['mail'];
        $subject = "Ответ на ваш пост на ".$sl_name;
        $message = render_mail('post_reply', array(
            'user' => $usr->login,
            'pid' => $pid,
            'lst' => $lst,
            'text' =>$text,
            'title'=>$title
        ));
        $headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
        nullbyte_mail($to, $subject, $message, true, $headers);
        if (@count($notify_plugins)>0) {
            $notify[]=array('to'=>$row['jabber'],'msg'=>$message);
        }
    }
}

if ($lvl==1) {flsnd($listp,$usr->login,$pid,$cm->id,$text,$title);}
if (@count($notify_plugins)>0) {
    foreach($notify_plugins as $plugin) {
        include('plugins/'.$plugin['name'].'/actions.php');
    }
}
db_query("DELETE FROM `eye` WHERE `pid`='' || `who`=''");
db_query("DELETE FROM `lenta` WHERE `uid`='' || `who`=''");
if ($json == 1) {
    $post11=$pid;
    $v_date=0;
    $out['id']=$pid;
    $out['cid']=intval($id);
    $out['txt']=post_render_comment(com_echo($cm,1),0);
    die(json_encode($out));
}
redirect($lst);
?>