<?php
//$sql_get="SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'   ";
//$result=mysql_query($sql_get,$sql);
$row=db_fetch_assoc(db_query("SELECT * FROM `comment` WHERE id = %d",request::get_get('id')));
if (request::get_post('text',0)!=0 || (($usr->login!=$row['who'] && $cedit==1 )&& $usr->lvl<$elvl) ) {
    redirect("post/".$row['krnl']."#cmnt".request::get_get('id'));
}
//$sql_get="UPDATE `comment` SET `text` = '".mysql_escape_string(gtext($_POST['text']))."'
//		 WHERE `comment`.`id` = '".$_GET['id']."'";
//
//$result=mysql_query($sql_get,$sql);
db_query("UPDATE `comment` SET `text` = %s WHERE `comment`.`id` =  %d",gtext(request::get_post('text')),request::get_get('id'));
redirect("post/".$row['krnl']."#cmnt".request::get_get('id'));
?>