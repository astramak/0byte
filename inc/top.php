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

for ($i=$ma->menu_c-1;$i>=0;$i--) {
	$mk=$ma->mg($i);
	$mk->snew();
	$enu_arr[$i]['url']=$mk->url;
	$enu_arr[$i]['title']=$mk->name;
	$enu_arr[$i]['active']=$mk->cur;
	$enu_arr[$i]['new']=$mk->new;
    $enu_arr[$i]['show']=$mk->show;
	if ($i<$ma->menu_c-1 && $enu_arr[$i+1]['active']) $enu_arr[$i]['before_active']=1; else $enu_arr[$i]['before_active']=0;
}
for ($i=0;$i<$ma->menu_c;$i++) {
	$menu_arr[$i]=$enu_arr[$i];
}
echo render_menu($menu_arr,$ma->menu_c);

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
		$top_ar['allow_blog']=1;
	} else {
		$top_ar['allow_blog']=0;
	}
        if (request::get_get('wt')=='pmread') {
           $top_ar['not_readed'] = db_result(db_query('SELECT COUNT(id) FROM pm WHERE `to` = %s && `readed` = 0 && `dto` != 2 && `id` != %d', $usr->login,request::get_get('id')));
        } else {
            $top_ar['not_readed'] = db_result(db_query('SELECT COUNT(id) FROM pm WHERE `to` = %s && `readed` = 0 && `dto` != 2', $usr->login));
        }
	$top_ar['mail'] = db_result(db_query('SELECT COUNT(id) FROM pm WHERE `to` = %s AND dto != 2', $usr->login));
	$top_ar['user_rate'] = $usr->rate();
	$top_ar['login']=$usr->login;
} else {
	$top_ar['loged']=0;
}

echo render_bottom_of_top($top_ar);
?>

<table id="tbll">
	<tbody>
		<tr>
			<td id="it">