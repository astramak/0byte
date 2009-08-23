<?php
if ($usr->rate()>=$np_rate) {
    $tp=request::get_get("tp",0,0);
    //if ($tp==0)
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

    $sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."'  ";
    $result=mysql_query($sql_get,$sql);
    if (!$result) {
        echo  mysql_error();
    }
    $blogs[]=array('value'=>'own','text'=>'Персональный');
    while ($row = mysql_fetch_assoc($result)) {
        $blogs[]=array('value'=>$row['blogid'],'text'=>$row['bname']);
    //				echo "<option value='".$row['blogid']."'>".$row['bname']."</option>";
    }
    echo render_new_post($type, $type_, $tp, $blogs, $len);
    if ($tp!=3) $script->add('mk(\'mq\',\'new\');
		document.getElementById("mq").innerHTML+="<a class=\'tdx\' href=\'javascript:insert(\"[cut]\",\"\",\"new\",\"text\")\'>cut</a>"+
		"<a class=\'tdx\' href=\'javascript:insert(\"[fcut]\",\"\",\"new\",\"text\")\'>fcut</a>";');
} else {
    redirect($dir.'error/not_allow');
}
		?>