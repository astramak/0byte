<?php
$who=request::get_get('who','');
if ($who!='') {

//    $sql_get="SELECT * FROM `users` WHERE name = '".$usr->login."' && ( frnd LIKE  '%, ".mysql_escape_string($_GET['who'])."%' || frnd LIKE  '%".mysql_escape_string($_GET['who']).",%' ) ORDER BY  id DESC ";
//    $result=mysql_query($sql_get,$sql);
//    if (!$result) {
//        echo  mysql_error();
//    }
//    $row = mysql_fetch_assoc($result);
    $row=db_fetch_assoc(db_query("SELECT * FROM `users` WHERE `name` = %s && ( `frnd` LIKE  '%".mysql_escape_string($who).",%'
|| `frnd` LIKE  '%, ".mysql_escape_string($who)."%' ) ORDER BY  id DESC ",$usr->login));
print_r($row);
    if ($row['name']!=$usr->login) {
        db_query("UPDATE `users` SET `frnd` = CONCAT(`frnd`,', ', %s)
	WHERE `users`.`name` = %s",$who,$usr->login);
        
    } else {
//        $sql_get="SELECT * FROM `users` WHERE name = '".$usr->login."'
//		ORDER BY  id DESC ";
//        $result=mysql_query($sql_get,$sql);
//        if (!$result) {
//            echo  mysql_error();
//        }
//        $row = mysql_fetch_assoc($result);
        $row=db_fetch_assoc(db_query("SELECT * FROM `users` WHERE name = %s ORDER BY  id DESC ",$usr->login));
        echo $row['frnd'];
       # $frnd=str_replace(", ".$who,"",$row['frnd']);
//        $sl="UPDATE `users` SET `frnd` = '".$frnd."'
//	WHERE `users`.`name` = '".$usr->login."'";
//        $result=mysql_query($sl,$sql);
        db_query("UPDATE `users` SET `frnd` = %s WHERE `users`.`name` = %s",$frnd,$usr->login);
    }
}
$lst=request::get_get('cur');
$lst=str_replace("*amp","&",$lst);
$lst=str_replace("*qw","?",$lst);
die;
redirect($lst);
?>
