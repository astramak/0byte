<?php
$frm=intval(request::get_get('from',0));
$inser="list/city/";
$ins=null;
$sql_ins=null;
$order="`city`";
$fst="<a href='list/city/".$ins."namedesc'>&#8593; Название</a> &#8595;";
$scn="<a href='list/city/".$ins."countdesc'>&#8593; Жителей</a> <a href='list/city/".$ins."count'>&#8595;</a>";

if (request::get_get('order',0)) {
    if (request::get_get('order')=='namedesc') {
        $order="`city` DESC";
        $fst="&#8593; <a href='list/city/".$ins."'>Название &#8595;</a>";
        $inser.="namedesc/";
    } elseif (strlen(request::get_get('order'))>2) {
        $fst="<a href='list/city/".$ins."namedesc'>&#8593; Название</a> <a href='list/city/".$ins."'>&#8595;</a>";
        if (request::get_get('order')=='count') {
            $order="`cnt` ";
            $scn="<a href='list/city/".$ins."countdesc'>&#8593; Жителей</a> &#8595;";
            $inser.="rate/";
        } elseif (request::get_get('order')=='countdesc') {
            $order="`cnt`  DESC";
            $scn="&#8593; <a href='list/city/".$ins."count'>Жителей &#8595;</a>";
            $inser.="countdesc/";
        }
    }
}
$result=db_query('SELECT `city` as `name`, COUNT(`city`) as `cnt` FROM `users` GROUP BY `city` ORDER BY '.$order);
$array=null;
while ($row=db_fetch_assoc($result)) {
    if ($row['name']) {
        $array[]=$row;
    }
}
echo render_template(TPL_LISTS.'/city.tpl.php', array('elements'=>$array,'fst'=>$fst,'scn'=>$scn));
$per_page=50;
if (db_num_rows($result) > $per_page) {
	echo render_paginator($inser, $per_page, $count_total, $frm);
}
?>
