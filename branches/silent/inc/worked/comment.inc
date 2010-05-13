<?php
if ($usr->rate()>=$nc_rate) {
//    $sql_get = "SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'";
//    $result=mysql_query($sql_get,$sql);
//    if (!$result) {
//        echo  mysql_error();
//    }
//    $row = mysql_fetch_assoc($result);
    $row=db_fetch_assoc(db_query("SELECT * FROM `comment` WHERE id = %d",request::get_get('id')));
    $lvl=$row['lvl']+1;
    if (request::get_get('js',0)==0) {
        $old=post_render_comment(com_echo(new comment($row),1));
    }
    else {
        echo "{";
        echo '"text" : "';
    }
    echo render_new_comment($old, $lvl, request::get_get("cur"), request::get_get("id"));
    if (request::get_get('js',0)!=0) {
        echo '"
	"id" : "'.request::get_get("id").'"
}';
    }
} else {
    redirect($dir.'error/not_allow');
}
?>