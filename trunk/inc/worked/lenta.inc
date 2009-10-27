<?php
// $sql_get = 'SELECT * FROM `post` WHERE  `blck` = 0 && `auth` != "'.$usr->login.'"
ini_set('display_errors', 1);
// && '.get_special().' ORDER BY `id` DESC';
  $result=db_query("SELECT * FROM `eye`,`comment` WHERE `eye`.`who`= %s && `comment`.`who`= %s
 && `comment`.`krnl`= `eye`.`pid` ORDER BY  `eye`.`id` DESC LIMIT 10",$usr->login,$usr->login);
while ($row=db_fetch_assoc($result)) {
    print_r($row);
}
?>
