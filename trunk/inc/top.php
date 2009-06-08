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
?>
<div id="top">
<div id="h1">
<h1><a href="<?php echo $site; ?>"><?php echo $ls_name; ?></a></h1>
<div id="banner"></div>
</div>
<div class="mf"><?php
$mk=new mel;
$l=0;
for ($i=$ma->menu_c-1;$i>0;$i--) {
	$mk=new mel; $mk=$ma->mg($i); $mk->snew();
	$cur=" class='menuel' ";
	if ($l==1) {
		$l=0;
		$cur=" class='lmenuel' ";
	} else if ($mk->chcur()==1) {
		$cur=" class='amenuel' ";
		$l=1;
	}
	$stc[$i]='<div '.$cur.'><a';
	$stc[$i].='  href="'.$mk->url.'">'.$mk->name.'<span class="add">'.$mk->new.'</span></a></div>';
}

$mk=$ma->mg(0); $mk->snew();
$cur=" class='menuel' ";
if ($l==1) {
	$cur=" class='lmenuel' ";
} else if ($mk->chcur()==1) {
	$cur=" class='amenuel' ";
}
echo "<div ".$cur."><a href='".$mk->url."'><img src='style/img/tv.gif' alt='' />".$mk->name."<span class='add'>".$mk->new."</span></a></div>";

for ($i=1;$i<$ma->menu_c;$i++) {
	echo $stc[$i];
}
?>
<div class="usln">
<div class="usrd"><?php
$cur=$_SERVER['REQUEST_URI'];
$cur=str_replace("&","*amp",$cur);
$cur=str_replace("?","*qw",$cur);
if (strpos($_SERVER['REQUEST_URI'],"?")!=0) {
	$un=$_SERVER['REQUEST_URI']."&un=1";
} else {
	$un=$_SERVER['REQUEST_URI']."?un=1";
}
if ($loged==1) {
	if ($usr->rate()>=$nb_rate) {
		$new="<a href='work/newblog'>блог</a>. <a href='work/myblog'>Мои блоги</a>";
	}
	echo "<a class='you' href='user/'>";
	$sql_get="SELECT * FROM `pm` WHERE `to` = '".$usr->login."' && `readed` = 0  && `dto` != 2  ";

	$result=mysql_query($sql_get,$sql);
	$aid=mysql_num_rows($result);
	if ($aid>0) {
		$kml="mail";
	} else {
		$kml="envelope";
	}
	$row = mysql_fetch_assoc($result);
	if ($row['readed']!=1) { $id=0; }
	$sql_get="SELECT * FROM `pm` WHERE `to` = '".$usr->login."' && `dto` != 2  ";
	$result=mysql_query($sql_get,$sql);
	$ida=mysql_num_rows($result);
	if ($usr->rate()>0) {
		$rtt="(<span class='rp'>".$usr->rate()."</span>)";
	} else if ($usr->rate()<0) {
		$rtt="(<span class='rm'>".$usr->rate()."</span>)";
	}
	$la=", у вас <img src='style/img/".$kml.".gif' alt='' /> <a href='work/pmls'>$aid / $ida ЛС</a>";
	echo $_SESSION['login']."</a> ".$rtt." ".$la.". <a href='work/newpost'>Новый пост</a> / $new</div>
							<div id='inout'><img src='style/img/figure.gif' alt='' />
							<form id='out' method='post' action='http://".$_SERVER['HTTP_HOST'].$dir."'><input type='hidden' name='un' value='1' /> <input id='outb' type='submit' value='Выйти' /></form></div>";
} else  {
	echo "<a href='register'>Зарегистрироваться</a></div><div id='inout'><a id='lgin' href='login/$cur'>Войти</a></div>";
}


echo '</div></div>	</div>';

?>




<table id="tbll">
	<tbody>
		<tr>
			<td>