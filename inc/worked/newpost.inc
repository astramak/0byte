<?php
if ($usr->rate()>=$np_rate) {
    $tp=request::get_get("tp",0,0);
    if (strncmp($tp,'lnk',3)==0) {
        $type="поста-ссылки";
        $type_="link";
        $tp=1;
    } else if (strncmp($tp,'tr',2)==0) {
            $type="перевода";
            $type_='translate';
            $tp=2;
        } else if (strncmp($tp,'answ',4)==0) {
                $type="опроса";
                $type_="answer";
                $tp=3;
            }  else {
                $type="сообщения";
                $type_='post';
                $tp=0;
            }
    if (request::get_get("len",0)>2) {
        $len=request::get_get("len",0);
    } else {$len=2;}

//    $sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."'  ";
//    $result=mysql_query($sql_get,$sql);
//    if (!$result) {
//        echo  mysql_error();
//    }
    $result=db_query('SELECT `name` as `text`, `id` as `value` FROM `blogs` WHERE '.blog::make_special_blogs('id','=',' || '));
//    echo 'SELECT `name`, `id` FROM `blogs` WHERE '.blog::make_special_blogs();
//    echo db_error();
    while ($row = db_fetch_assoc($result)) {
      $blogs[]=$row;
    }
    $blogs[]=0;
    $result=db_query("SELECT `blogid` as `value`, `bname` as `text` FROM `inblog` WHERE `bname` != '' && `name` = %s &&".blog::make_special_blogs('blogid','!='),$usr->login);
    $blogs[]=array('value'=>'own','text'=>'Персональный');
    $blogs[]=0;
    while ($row = db_fetch_assoc($result)) {
        $blogs[]=$row;
    }
    $text=render_new_post($type, $type_, $tp, $blogs, $len);
    if (!@$json) {
        echo $text;
    }
    $js='mk(\'mq\',\'new\');
		document.getElementById("mq").innerHTML+="<a class=\'tdx\' href=\'javascript:insert(\"[cut]\",\"\",\"new\",\"text\")\'>cut</a>"+
		"<a class=\'tdx\' href=\'javascript:insert(\"[fcut]\",\"\",\"new\",\"text\")\'>fcut</a>";';
    if ($tp!=3 && !@$json) $script->add($js); else if ($tp==3) $js=null;

} else {
    if (!@$json) {
        redirect($dir.'error/not_allow');
    }
}
?>