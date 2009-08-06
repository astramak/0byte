<?php
    $id=request::get_get('id');
    if (db_result(db_query("SELECT `who`,`pid` FROM `favourite` WHERE `who` = %s && `pid` = %d",$usr->login,$id))) {
        db_query("DELETE FROM `favourite` WHERE `pid` = %d && `who` = %s LIMIT 1",$id,$usr->login);
    } else {
        db_query('INSERT INTO `favourite` SET `pid` = %d, `who` = %s ',$id,$usr->login);
    }
    redirect('post/'.$id.'/');
?>