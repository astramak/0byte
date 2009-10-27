<?php
// $sql_get = 'SELECT * FROM `post` WHERE  `blck` = 0 && `auth` != "'.$usr->login.'"
ini_set('display_errors', 1);
// && '.get_special().' ORDER BY `id` DESC';
db_query("SET OPTION SQL_BIG_SELECTS=1");
//`comment`.`date` > '".(time()-7*24*60*60)."' &&
$result=db_query("SELECT * FROM
(SELECT `comment`.`text`,`comment`.`date`, `eye`.`who` as `eye_who`, `comment`.`who` as `comment_who`, `comment`.`krnl`, `eye`.`pid`, `eye`.`id` FROM `eye`,`comment` WHERE `comment`.`date` > '".(time()-300*24*60*60)."' && `eye`.`who`= %s && `comment`.`who`!= `eye`.`who`
 && `comment`.`krnl`= `eye`.`pid` ORDER BY  `comment`.`date` DESC)   as `comments`
, (SELECT * FROM `post` WHERE `post`.`date` > '".(time()-300*24*60*60)."' && `post`.`blck` = 0 && `post`.`auth` != %s &&  ".get_special()." ORDER BY `post`.`id` DESC ) AS `posts` ORDER BY (`posts`.`date`+`comments`.`date`) DESC LIMIT 10
",$usr->login,$usr->login);
db_query("SET OPTION SQL_BIG_SELECTS=0");
$com=new comment();
while ($row=db_fetch_assoc($result)) {
    if (strlen($row['ftext'])<=2) {
        echo $row['comment_who'];
        $com->make($row);
        echo com_echo($com, 0, 0);
    } else {
        echo post_echo($row,$row['tp'] );
    }
    $row=null;
}
echo db_error();
?>
