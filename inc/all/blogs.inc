
<?php
$frm=0;
$inser="list/blog/";
if (request::get_get('from',0)) {
    $frm=intval($_GET['from']);
}	$order="name";
$fst="<a href='list/blog/namedesc'>&#8593; Название</a> &#8595;";
$scn="<a href='list/blog/ratedesc'>&#8593; Рейтинг</a> <a href='list/blog/rate'>&#8595;</a>";
if (request::get_get('order',0)) {
    if ($_GET['order']=='namedesc') {
        $order="name DESC";
        $fst="&#8593; <a href='list/blog/'>Название &#8595;</a>";
        $inser.="namedesc/";
    } else if (strlen(request::get_get('order'))>2) {
            $fst="<a href='list/blog/namedesc'>&#8593; Название</a> <a href='list/blog/'>&#8595;</a>";
            if (request::get_get('order')=='rate') {
                $order="ratep - ratem";
                $scn="<a href='list/blog/ratedesc'>&#8593; Рейтинг</a> &#8595;";
                $inser.="rate/";
            } else if (request::get_get('order')=='ratedesc') {
                    $order="ratep - ratem DESC";
                    $scn="&#8593; <a href='list/blog/rate'>Рейтинг &#8595;</a>";
                    $inser.="ratedesc/";
        }}
}


$result=db_query("SELECT * FROM `blogs` ORDER BY ".$order." LIMIT %d,50",$frm);
while ($row = db_fetch_assoc($result)) {
    if (strlen($row['av'])>=2) {
        $av="<img class='cauth' src='res.php?t=bl&img=".$row['av']."' alt='' />";
    } else {
        $av=null;
    }
    $row['av']=$av;
    $row['rate']=$row['ratep']-$row['ratem'];

    $elem[]=$row;
}
echo render_template(TPL_LISTS.'/blog.tpl.php', array('elements'=>$elem,'fst'=>$fst,'scn'=>$scn,'edit'=>@$usr->lvl>=$elvl));
echo render_paginator($inser, 50, db_result(db_query("SELECT COUNT(`id`) FROM  `blogs`")), $frm);
?>