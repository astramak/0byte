<?php
 $sql_get = 'SELECT * FROM `post` WHERE  `blck` = 0 && `auth` != "'.$usr->login.'"
 && '.get_special().' ORDER BY `id` DESC';
  $result=db_query(" SELECT * FROM `eye`,`post` WHERE `eye`.`pid`=`post`.`id` && `eye`.`who`='".$usr->login."' ORDER BY  `eye`.`id` DESC LIMIT ".$limit);
?>
