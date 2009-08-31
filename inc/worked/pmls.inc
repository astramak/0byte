<?php
echo render_template(TPL_PM."/top.tpl.php", array('id'=>intval(request::get_get('id')),'login'=>$usr->login));
if (isset($_GET['tp'])) {
    $e="auth";
    $ae="to";
    $in="`dto` != 1";
} else {
    $e="to";
    $ae="auth";
    $in="`dto` != 2";
}
$sql_get="SELECT * FROM `pm` WHERE `$e` = '".$usr->login."' && $in   ORDER BY  id DESC  ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
    echo  mysql_error();
}
if ($id=mysql_num_rows($result)==0) {
    $num=0;
    $pm=null;
} else {
    $num=1;
    $alien=new user;
    while($row = mysql_fetch_assoc($result)) {
        $alien->find($row[$ae]);
        $av=0;
        $av_url=null;
        if (strlen($alien->av)>2) {
            $av_url="res.php?t=av&img=".$alien->av;
            $av=1;
        }
        $cls="";
        $klr="";
        if ($e=="to" && $row['readed']==0) {
            $cls="class='unr'";
        } else {
            $klr=" href='twork.php?wt=pmdel&id=".$row['id']."&cur=".$cur."'";
        }
        $pm[]=array('class'=>$cls,'killer'=>$klr,'id'=>$row['id'],'avatar'=>$av,'av_url'=>$av_url,
            'usr'=>$row[$ae],'title'=>$row['title']);
    }
}
echo render_template(TPL_PM."/list.tpl.php", array('pms'=>$pm,'num'=>$num));
?>