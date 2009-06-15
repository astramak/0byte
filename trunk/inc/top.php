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

//ini_set('display_errors', 1);
echo render_top(); //пусть пока результат шаблонизатора просто выводится
$ma=new mn();
$ma=cmenu($ma);
$act=0;

for ($i=$ma->menu_c-1;$i>=0;$i--){
	$mk=$ma->mg($i);
	$mk->snew();
	$enu_arr[$i]['url']=$mk->url;
	$enu_arr[$i]['title']=$mk->name;
	$enu_arr[$i]['active']=$mk->chcur();
	$enu_arr[$i]['new']=$mk->new;
	if ($i<$ma->menu_c-1 && $enu_arr[$i+1]['active']) $enu_arr[$i]['before_active']=1; else $enu_arr[$i]['before_active']=0;
}
for ($i=0;$i<$ma->menu_c;$i++) {
	$menu_arr[$i]=$enu_arr[$i];
//	print_r($enu_arr[$i]);
}
echo render_menu($menu_arr,$ma->menu_c);
//for ($i=$ma->menu_c-1;$i>0;$i--) {
//	$mk=new mel; $mk=$ma->mg($i); $mk->snew();
//	$cur=" class='menuel' ";
//	if ($l==1) {
//		$l=0;
//		$cur=" class='lmenuel' ";
//	} else if ($mk->chcur()==1) {
//		$cur=" class='amenuel' ";
//		$l=1;
//	}
//	$stc[$i]='<div '.$cur.'><a';
//	$stc[$i].='  href="'.$mk->url.'">'.$mk->name.'<span class="add">'.$mk->new.'</span></a></div>';
//}
//
//$mk=$ma->mg(0); $mk->snew();
//$cur=" class='menuel' ";
//if ($l==1) {
//	$cur=" class='lmenuel' ";
//} else if ($mk->chcur()==1) {
//	$cur=" class='amenuel' ";
//}
//echo "<div ".$cur."><a href='".$mk->url."'><img src='style/img/tv.gif' alt='' />".$mk->name."<span class='add'>".$mk->new."</span></a></div>";
//
//for ($i=1;$i<$ma->menu_c;$i++) {
//	echo $stc[$i];
//}

//<div class="usln">
//<div class="usrd">
$cur=$_SERVER['REQUEST_URI'];
$cur=str_replace("&","*amp",$cur);
$cur=str_replace("?","*qw",$cur);
if (strpos($_SERVER['REQUEST_URI'],"?")!=0) {
	$un=$_SERVER['REQUEST_URI']."&un=1";
} else {
	$un=$_SERVER['REQUEST_URI']."?un=1";
}
$top_ar['current_url']=$cur;
if ($loged==1) {
	$top_ar['loged']=1;
	if ($usr->rate()>=$nb_rate || $usr->lvl>5) {
//		$new="<a href='work/newblog'>блог</a>. <a href='work/myblog'>Мои блоги</a>";
		$top_ar['blog_allow']=1;
	} else {$top_ar['blog_allow']=0;}
//	echo "<a class='you' href='user/'>";
	$sql_get="SELECT * FROM `pm` WHERE `to` = '".$usr->login."' && `readed` = 0  && `dto` != 2  ";

	$result=mysql_query($sql_get,$sql);
	$aid=mysql_num_rows($result);
//	if ($aid>0) {
//		$kml="mail";
//	} else {
//		$kml="envelope";
//	}
	$top_ar['not_readed']=$aid;
	$row = mysql_fetch_assoc($result);
	if ($row['readed']!=1) { $id=0; }
	$sql_get="SELECT * FROM `pm` WHERE `to` = '".$usr->login."' && `dto` != 2  ";
	$result=mysql_query($sql_get,$sql);
	$ida=mysql_num_rows($result);
//	if ($usr->rate()>0) {
//		$rtt="(<span class='rp'>".$usr->rate()."</span>)";
//	} else if ($usr->rate()<0) {
//		$rtt="(<span class='rm'>".$usr->rate()."</span>)";
//	}
	$top_ar['user_rate']=$usr->rate;
	$top_ar['mail']=$ida;
//	$la=", у вас <img src='style/img/".$kml.".gif' alt='' /> <a href='work/pmls'>$aid / $ida ЛС</a>";
//	echo $_SESSION['login']."</a> ".$rtt." ".$la.". <a href='work/newpost'>Новый пост</a> / $new</div>
//							<div id='inout'><img src='style/img/figure.gif' alt='' />
//							<form id='out' method='post' action='".$site."'><input type='hidden' name='un' value='1' /> <input id='outb' type='submit' value='Выйти' /></form></div>";
	$top_ar['login']=$usr->login;
} else  {
//	echo "<a href='register'>Зарегистрироваться</a></div><div id='inout'><a id='lgin' href='login/$cur'>Войти</a></div>";
	$top_ar['loged']=0;
}

	echo	render_bottom_of_top($top_ar);
//echo '</div></div>	</div>';

?>




<table id="tbll">
	<tbody>
		<tr>
			<td>