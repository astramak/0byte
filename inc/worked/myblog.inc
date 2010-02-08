
<?php
$single=request::get_get('single',0);
if ($single && $usr->lvl>=$elvl) {
    $result=db_query("SELECT * FROM `blogs` WHERE `id` = %d",request::get_get('id'));
} else if (!$single) {
        $result=db_query( "SELECT * FROM `blogs` WHERE owner = %s && ".blog::make_special_blogs('id','!='),$usr->login);
    }
if (db_num_rows($result)) {
    while ( $row = db_fetch_assoc($result)) {
        $av=0;
        if (strlen($row['av'])>0) {
            $av=1;
        }
        $resul=db_query("SELECT * FROM `inblog` WHERE blogid = %d",$row['id']);
        while ( $rw = db_fetch_assoc($resul)) {
            $users[]=$rw['name'];
        }
        $blogs[]=array('name'=>$row['name'],'id'=>$row['id'],'avatar'=>$av,'avatar_url'=>$row['av'],
            'users'=>$users,'ch_url'=>"twork.php?wt=editblog&bid=".$row['id'],'about'=>$row['about'],
            'av_ch_url'=>"twork.php?wt=bimg&bid=".$row['id']);
    }

    echo render_myblog($blogs,$single);
} else {
    echo render_error("У вас нет блогов!");
}
?>
