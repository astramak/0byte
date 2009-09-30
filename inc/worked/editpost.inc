<?php
if (request::get_get('draft',0)) {
    $row=db_fetch_assoc(db_query('SELECT * FROM `draft` WHERE `id` = %d && `auth` = %s',request::get_get('post'),$usr->login));
    $row['blogid']=$row['blog'];
} else {
    $row=db_fetch_assoc(db_query('SELECT * FROM `post` WHERE id = %d',request::get_get('post')));
}
if ($usr->login==$row['auth'] || $usr->lvl>$elvl) {
    if (!request::get_get('draft',0)) {
        $zz=$row['ftext'];
        if (strpos($row['text'],"[fcut]")) {
            $zz=$row['text'].$row['ftext'];
        }
    } else {
        $zz=$row['text'];
    }
    $h=null;
    if ($row['lock']==1) {
        $h='checked="checked"';
    }
    $mng=null;
    if ($row['lnk']==1) {
        $mng='checked="checked"';
    }
    $sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."'  ";
    $resul=mysql_query($sql_get,$sql);
    if (!$resul) {
        echo  mysql_error();
    }
    $blogs[]=array('value'=>'own','text'=>'Персональный','active'=>null);
    while ($rw = mysql_fetch_assoc($resul)) {
        if ($rw['blogid']==$row['blogid']) {$fin='selected';} else {$fin="";}
        $blogs[]=array('value'=>$rw['blogid'],'text'=>$rw['bname'],'active'=>$fin);
    }
    $type=null;
    if ($row['tp']==3) {
        $type='answer';
    } else if  ($row['tp']==2) {
            $type='translate';
        } else  if ($row['tp']==1) {
                $type='link';
            }
    if ($row['tp']==3 && request::get_get('draft',0)) {
        $answers = explode(' ', $row['text']);
        trim_array($answers);
        echo render_template(TPL_FRAMES.'/draft_answer.tpl.php', array('url'=>"twork.php?wt=editpost&post=".intval(request::get_get('post')),
        'title'=>$row['title'],'blogs'=>$blogs,'len'=>count($answers),'answers'=>$answers,'tag'=>$row['tag'],'status'=>$h,'mng'=>$mng));
    } else echo render_edit_post(utext($row['title']), $blogs, "twork.php?wt=editpost&post=".intval(request::get_get('post')),
        $type, $row['tag'], $h, utext($zz), $row['lnk'],$draft=request::get_get('draft',0));

} else {
   redirect($dir.'error/not_allow');
}
$script->add('mk(\'mq\',\'new\');
		document.getElementById("otxt").innerHTML+="<br /><a href=\'javascript:prv()\'>Предпросмотр</a>";
		document.getElementById("mq").innerHTML+="<a class=\'tdx\' href=\'javascript:insert(\"[cut]\",\"\",\"new\",\"text\")\'>cut</a>"+
		"<a class=\'tdx\' href=\'javascript:insert(\"[fcut]\",\"\",\"new\",\"text\")\'>fcut</a>";');
?>
