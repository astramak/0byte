<?php
// $sql_get = 'SELECT * FROM `post` WHERE  `blck` = 0 && `auth` != "'.$usr->login.'"
ini_set('display_errors', 1);
// && '.get_special().' ORDER BY `id` DESC';
db_query("SET OPTION SQL_BIG_SELECTS=1");
//`comment`.`date` > '".(time()-7*24*60*60)."' &&
$result=db_query("SELECT * FROM
(SELECT `comment`.`date`, `eye`.`who` as `eye_who`, `comment`.`who` as `comment_who`, `comment`.`krnl`, `eye`.`pid`, `eye`.`id` FROM `eye`,`comment` WHERE `comment`.`date` > '".(time()-30*24*60*60)."' && `eye`.`who`= %s && `comment`.`who`!= %s
 && `comment`.`krnl`= `eye`.`pid` ORDER BY  `eye`.`id` DESC)   as `comments`
, (SELECT `post`.`date`,`post`.`blck`,`post`.`auth`,`post`.`blogid`, `post`.`id` as `postid` FROM `post` WHERE `post`.`date` > '".(time()-30*24*60*60)."' && `post`.`blck` = 0 && `post`.`auth` != %s &&  ".get_special()." ORDER BY `post`.`id` DESC ) AS `posts` LIMIT 10
",$usr->login,$usr->login,$usr->login);
db_query("SET OPTION SQL_BIG_SELECTS=0");
$com=new comment();
while ($row=db_fetch_assoc($result)) {
    if (strlen($row['comment_who'])>=1) {
        $com->make($row);
        echo com_echo($com, 0, 0);
    }
}
echo db_error();
?>
