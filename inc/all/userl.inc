<h2>Пользователи</h2>
<table id='users'>
	<tr>
		<td></td>
		<?php
		$frm=0;
		$inser="list/user/";
		if (isset($_GET['from'])) {
			$frm=intval($_GET['from']);
		}
		$order="name";
		$fst="<td class='mettm'><a href='list/user/namedesc'>&#8593; Ник</a> &#8595;</td>";
		$scn="<td class='mettm'><a href='list/user/ratedesc'>&#8593; Рейтинг</a> <a href='list/user/rate'>&#8595;</a></td>";
		if (isset($_GET['order'])) {
			if ($_GET['order']=='namedesc') {
				$order="name DESC";
				$fst="<td class='mettm'>&#8593; <a href='list/user/'>Ник &#8595;</a></td>";
				$inser.="namedesc/";
			} else if (strlen($_GET['order'])>2) {
				$fst="<td class='mettm'><a href='list/user/namedesc'>&#8593; Ник</a> <a href='list/user/'>&#8595;</a></td>";	
				if ($_GET['order']=='rate') {
					$order="(ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r) ";
					$scn="<td class='mettm'><a href='list/user/ratedesc'>&#8593; Рейтинг</a> &#8595;</td>";
					$inser.="rate/";
				} else if ($_GET['order']=='ratedesc') {
					$order="(ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r)  DESC";
					$scn="<td class='mettm'>&#8593; <a href='list/user/rate'>Рейтинг &#8595;</a></td>";
					$inser.="ratedesc/";
				}}
		}
		$sql_get="SELECT * FROM `users` ORDER BY ".$order." LIMIT ".$frm.",50";
		echo $fst.$scn."</tr>";
		$result=mysql_query($sql_get,$sql);
		while ($row = mysql_fetch_assoc($result)) {
			echo "<tr><td class='avl'>";
			if (strlen($row['av'])>=2) {
				echo "<img class='cauth' src='res.php?t=av&img=".$row['av']."' alt='' />";
			} else {
				echo '<img class="cnoauth" src="style/img/figure.gif" />';
			}
			echo "</td><td class='ulp'><a href='user/".$row['name']."'>".$row['name']."</a></td><td class='lrte'>";
			$otr=$row['brate']/$blog_r+$row['crate']/$com_r+$row['prate']/$post_r;
			$otr+=$row['ratep']-$row['ratem'];
			if ($otr==0) {
				echo 0;
			} else if ($otr>0) {
				echo "<span class='rp'>".$otr."</span>";
			} else {
				echo "<span class='rm'>".$otr."</span>";
			}
			echo "</td></tr>";
		}

		?>

</table>
<div id='list'><?php 
$count=50;
$sql_get="SELECT * FROM `users` ORDER BY ".$order;
$result=mysql_query($sql_get,$sql);
$kol=mysql_num_rows($result);

if ($frm>=$count) {
	echo "<a class='nomnm' id='prev' href='".$inser."from/".($frm-$count)."'>&#8592; </a>";
}
$numb=0;
$k=1;
while ($kol>0 && $numb<10) {
	if (($k-1-$frm/$count)<5 && ($k-1-$frm/$count)>-5) {
		if ($frm==($k-1)*$count) {
			echo "<span  class='nmn'>".$k."</span> ";
		} else {
			echo ("<a class='nmn' href='".$inser."from/".(($k-1)*$count)."'>$k</a> ");
		}
		$numb++;
	}
	$k++;
	$kol-=$count;
}
if ($frm<($k-2)*$count) {
	echo "<a class='nomnm' id='next' href='".$inser."from/".($frm+$count)."'> &#8594;</a>";
}
echo "<br />";
$wtch=0;
if ($frm>=5*$count) {
	echo "<a class='nomnm' href='".$inser."from/0"."'>&#8612; Начало</a>";
	$wtch=1;
}
if ($frm<($k-6)*$count) {
	if ($wtch==1) {echo "||";}
	echo "<a class='nomnm' href='".$inser."from/".($k-2)*$count."'>Конец &#8614; </a>";	
}
?></div>
