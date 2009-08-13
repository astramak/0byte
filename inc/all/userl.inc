
<?php
$frm=0;
$inser="list/user/";
if (request::get_get('from',0)) {
    $frm=intval($_GET['from']);
}
$order="name";
$fst="<a href='list/user/namedesc'>&#8593; Ник</a> &#8595;";
$scn="<a href='list/user/ratedesc'>&#8593; Рейтинг</a> <a href='list/user/rate'>&#8595;</a>";
if (request::get_get('order',0)) {
    if ($_GET['order']=='namedesc') {
        $order="name DESC";
        $fst="&#8593; <a href='list/user/'>Ник &#8595;</a>";
        $inser.="namedesc/";
    } else if (strlen(request::get_get('order'))>2) {
            $fst="<a href='list/user/namedesc'>&#8593; Ник</a> <a href='list/user/'>&#8595;</a>";
            if (request::get_get('order')=='rate') {
                $order="(ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r) ";
                $scn="<a href='list/user/ratedesc'>&#8593; Рейтинг</a> &#8595;";
                $inser.="rate/";
            } else if (request::get_get('order')=='ratedesc') {
                    $order="(ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r)  DESC";
                    $scn="&#8593; <a href='list/user/rate'>Рейтинг &#8595;</a>";
                    $inser.="ratedesc/";
        }}
}
//		$sql_get="SELECT * FROM `users` ORDER BY ".$order." LIMIT ".$frm.",50";
//		echo $fst.$scn."</tr>";
$result=db_query("SELECT * FROM `users` ORDER BY ".$order." LIMIT %d,50",$frm);
while ($row = db_fetch_assoc($result)) {
//			echo "<tr><td class='avl'>";
    if (strlen($row['av'])>=2) {
        $av= "<img class='cauth' src='res.php?t=av&img=".$row['av']."' alt='' />";
    } else {
        $av= '<img class="cnoauth" src="style/img/figure.gif" />';
    }
    //			echo "</td><td class='ulp'><a href='user/".$row['name']."'>".$row['name']."</a></td><td class='lrte'>";
    $otr=$row['brate']/$blog_r+$row['crate']/$com_r+$row['prate']/$post_r;
    $otr+=$row['ratep']-$row['ratem'];
    //			if ($otr==0) {
    //				echo 0;
    //			} else if ($otr>0) {
    //				echo "<span class='rp'>".$otr."</span>";
    //			} else {
    //				echo "<span class='rm'>".$otr."</span>";
    //			}
    //			echo "</td></tr>";
    $row['av']=$av;
    $row['rate']=$otr;
    $elem[]=$row;
}


echo render_template(TPL_LISTS.'/user.tpl.php', array('elements'=>$elem,'fst'=>$fst,'scn'=>$scn));
echo render_paginator($inser, 50, db_result(db_query("SELECT COUNT(`id`) FROM  `users`")), $frm);
?>