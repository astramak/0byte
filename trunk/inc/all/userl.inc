<?php
$frm=intval(request::get_get('from',0));
$inser="list/user/";

$ins=null;
$sql_ins=null;
if (request::get_get('city',0)) {
	$ins="city/".gtext(request::get_get('city',0)).'/';
	$sql_ins='AND `city`="'.gtext(request::get_get('city',0)).'" ';
	$inser.=$ins;
} else if (request::get_get('banned') && $loged && @$usr->lvl>$blvl) {
    $ins="banned/";
	$sql_ins='AND `lck`!=0 ';
	$inser.=$ins;
}

$order="name";
$fst="<a href='list/user/".$ins."namedesc'>&#8593; Ник</a> &#8595;";
$scn="<a href='list/user/".$ins."ratedesc'>&#8593; Рейтинг</a> <a href='list/user/".$ins."rate'>&#8595;</a>";

if (request::get_get('order',0)) {
	if (request::get_get('order')=='namedesc') {
		$order="name DESC";
		$fst="&#8593; <a href='list/user/".$ins."'>Ник &#8595;</a>";
		$inser.="namedesc/";
	} elseif (strlen(request::get_get('order'))>2) {
		$fst="<a href='list/user/".$ins."namedesc'>&#8593; Ник</a> <a href='list/user/".$ins."'>&#8595;</a>";
		if (request::get_get('order')=='rate') {
			$order="(ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r) ";
			$scn="<a href='list/user/".$ins."ratedesc'>&#8593; Рейтинг</a> &#8595;";
			$inser.="rate/";
		} elseif (request::get_get('order')=='ratedesc') {
			$order="(ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r)  DESC";
			$scn="&#8593; <a href='list/user/".$ins."rate'>Рейтинг &#8595;</a>";
			$inser.="ratedesc/";
		}
	}
}

$per_page = 50;
$sql = "SELECT * FROM users WHERE 1 = 1 " . $sql_ins;
$count_total = db_result(db_query(str_replace('SELECT * FROM', 'SELECT COUNT(id) FROM', $sql)));
$result = db_query($sql . " ORDER BY " . $order . " LIMIT %d,%d", $frm, $per_page);
while ($row = db_fetch_assoc($result)) {
	if (strlen($row['av'])>=2) {
		$av= "<img class='cauth' src='res.php?t=av&img=".$row['av']."' alt='' />";
	} else {
		$av= '<img class="cnoauth" src="style/img/figure.gif" />';
	}
	$otr=$row['brate']/$blog_r+$row['crate']/$com_r+$row['prate']/$post_r;
	$otr+=$row['ratep']-$row['ratem'];
	$row['av']=$av;
	$row['rate']=$otr;
	$elem[]=$row;
}

echo render_template(TPL_LISTS.'/user.tpl.php', array('elements'=>$elem,'fst'=>$fst,'scn'=>$scn,'city'=>request::get_get('city',0)));
if ($count_total > $per_page) {
	echo render_paginator($inser, $per_page, $count_total, $frm);
}
?>