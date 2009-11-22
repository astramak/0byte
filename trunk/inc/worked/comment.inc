<?php
if ($usr->rate()>=$nc_rate) {
    $sql_get = "SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'";
    $result=mysql_query($sql_get,$sql);
    if (!$result) {
        echo  mysql_error();
    }
    $row = mysql_fetch_assoc($result);
    $lvl=$row['lvl']+1;
    if (!isset($_GET['js'])) {
        $old=post_render_comment(com_echo(new comment($row),1));
    }
    else {
        echo "{";
        echo '"text" : "';
    }
    echo render_new_comment($old, $lvl, request::get_get("cur"), request::get_get("id"));
    if (isset($_GET['js'])) {
        echo '"
	"id" : "'.$_GET['id'].'"
}';
    }
} else {
    redirect($dir.'error/not_allow');
}
?>