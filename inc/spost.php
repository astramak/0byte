<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License.
 *
 *  0byte is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  See <http://www.gnu.org/licenses/>.
 *
 */
$last_com_id=0;
$jstocom="var com_arr=new Array();";
$num_com=0;
$sql_get="SELECT * FROM `post` WHERE id = '".gint($_GET['post'])."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$cur=$_SERVER['REQUEST_URI'];
$cur=str_replace("&","*amp",$cur);
$cur=str_replace("?","*qw",$cur);
$row = mysql_fetch_assoc($result);
if ($row['blck']==1 && $usr->lvl<$blvl) {
	echo "<h2>У вас недостаточно прав для просмотра данной страницы!</h2>";
} else if ($row['id']!=gint($_GET['post'])) {
	echo "<h2>Пост не существует</h2>";
} else {
	//spy
	if ($loged==1) {
		$sql_get="SELECT * FROM `hist` WHERE `pid` = '".gint($_GET['post'])."' && `who`='".$usr->login."'  ";
		$result=mysql_query($sql_get,$sql);
		$rw = mysql_fetch_assoc($result);
		$v_date=$rw['date'];
		$v_id=$rw['id'];
	}
	///spy
	$post=post_echo($row,1);
	$ed='';
	$unb="За";
	if ($row['blck']==1) {
		$unb="Раз";
	}
	$bls="";
	if ($usr->lvl>=$rlvl) {
		$bls="(<a  href='twork.php?wt=bpost&id=".gint($_GET['post'])."&unb=".$row['blck']."'>".$unb."блокировать</a>) (<a href='work/rmpost/".gint($_GET['post'])."'>Удалить</a>) ";
	}
	if ($usr->login==$row['auth'] || $usr->lvl>=$elvl) {
		$ed='(<a  href="work/editpost/'.gint($_GET['post']).'">Править</a>) '.$bls;
	}
	if ($usr->login!=$row['auth'] && $loged==1) {
		if (strpos($post->flw,$usr->login)===false) {
			$ed.=" (<a id='sled' href='twork.php?wt=flw&id=".gint($_GET['post'])."'>Отслеживать</a>)";
		} else {
			$ed.=" (<a id='sled' href='twork.php?wt=flw&id=".gint($_GET['post'])."&un=1'>Перестать отслеживать</a>)";
		}
	}
	$rt="";$rate=$post->rate();
	if ($rate>0) {$rt="<span class='rp'>".$rate."</span>";}
	else if ($rate<0) {$rt="<span class='rm'>".$rate."</span>";} else {$rt=0;}
	echo "<div class='bottom'>$ed<span class='rate'><a class='ratep' href='twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=p&amp;from=".$cur."'>+</a><span id='rp".$post->id."'>".$rt."</span><a class='ratem' href='twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=m&amp;from=".$cur."'>&ndash;</a></span></div>";
	echo "<div class='tags'>";




	if (strlen($row['tag'])>1) {
		$arr=split(",",$row['tag']);
		$q=sizeof($arr);
		for ($z=0;$z<$q;$z++) {

			$sql_get="SELECT * FROM `tags` WHERE name = '".trim($arr[$z]) ."'   ";
			$result=mysql_query($sql_get,$sql);
			if (!$result) {
				echo  mysql_error();
			}
			$rw = mysql_fetch_assoc($result);
			echo "<a href='tag/".$rw['name']."' rel='tag'>".$arr[$z]."</a>   ";
		}

	}

	echo "</div>";




	$sql_get="SELECT * FROM `comment` WHERE cid = '".gint($_GET['post'])."' && lvl='0'  ORDER BY  id   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	echo "<a id='cm'></a><div id='cmn'>";
	if ($id=mysql_num_rows($result)==0) {
		echo "<span id='nocom'>Коментариев нет</span>";
	} else {
		$com=new com;
		while($row = mysql_fetch_assoc($result)) {
			$com->make($row);
			com_echo($com);
		}
	}
	echo "</div>";
	if ($loged==1) {
		echo "	<div class='cprv' id='cprv-1'></div>	<div class='inpt' id='mkt'>
		 </div>
		<form onsubmit='s_c(this,\"$post->id\"); klcprv(-1); return false;' class='inpt' id='com' name='com' method='post' action='twork.php?wt=newcom&amp;id=".$post->id."&amp;from=".$cur."'>

		<textarea onkeypress='if (ce(event)) {s_c(this.form,\"$post->id\"); klcprv(-1);} do_key(this.form,\"com\",event);' 
onkeydown='if(\"\v\"==\"v\") {do_key(this.form,\"com\",event); }' name='text'  rows='10' cols='80'></textarea><br />
<input type='submit' value='Отправить' /><input type='button' id='prwb-1' onClick='prw_com(this.form.text.value,-1)' value='Предпросмотр' />
</form><script>document.getElementById('prwb-1').style.display='inline'; mk('mkt','com');</script>";
	}
}

//spy
if ($loged==1) {
	if ($v_id==0) {
		$sql_get="INSERT INTO `hist` (`pid`, `who`, `date`) VALUES (".gint($_GET['post']).",'".$usr->login."','".time()."')";
		$result=mysql_query($sql_get,$sql);
	} else {
		$sql_get="UPDATE `hist` SET `date` = '".time()."' WHERE `hist`.`id` =".$v_id." LIMIT 1";
		$result=mysql_query($sql_get,$sql);
	}
}
///spy
if ($num_com==0) {$nam="&#8212;";} else {$nam=$num_com;}
echo "<div id='ebaa'><img onClick='upd_com()' src='style/n_img/refr.gif' /><br /><a href='javascript:upd_ls()' id='ln_doe'>".$nam."</a></div>";
echo "<script> var last_com_id=".$last_com_id."; var post_id_com=".gint($_GET['post'])."; ".$jstocom." var num_com=".$num_com."</script>";
?>

