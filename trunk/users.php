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
include("cfg.php");
include ("inc/head.php");
include("inc/top.php");

$own_profile = false;
if (strlen(request::get_get('name'))) {
	$name = request::get_get('name');
	$own_profile = (isset($_SESSION['login']) && strlen($_SESSION['login']) && $_SESSION['login'] == $name);
} elseif (isset($_SESSION['login']) && strlen($_SESSION['login'])) {
	$name = $_SESSION['login'];
	$own_profile = true;
} else {
	$name = "";
}
$alien = new user();
if (!$alien->find($name)) {
	redirect($dir.'error/not_found');
} else {
	$cur = $_SERVER['REQUEST_URI'];
	$cur = str_replace("&","*amp",$cur);
	$cur = str_replace("?","*qw",$cur);
	$avatar=0;
	$avatar_url=null;
	$post_count = db_result(db_query('SELECT COUNT(id) FROM post WHERE auth = %s ORDER BY id DESC', $alien->login));
	if (strlen($alien->av)>2) {
		$avatar=1;
		$avatar_url="res.php?t=av&img=".$alien->av;
	}
	$un="0";
	$use_micro=0;
	if ($alien->g_j()!=0) {
		$use_micro=1;
		if ($alien->juse==1) {
			$src="juick";
		} else {
			$src="twitter";
			$alien->jtext=substr($alien->jtext,strlen($alien->jname)+2);
		}
		$micro_name=$alien->jname."@".$src;
		$micro_url="http://".$src.".com/".$alien->jname;
	}

	$jabber['set']=0;
	$city['set']=0;
	$site['set']=0;
	$icq['set']=0;
	$about['set']=0;
	$lvl['set']=0;
	if ($alien->jabber) {
		$jabber['set']=1;
		$jabber['text']=$alien->jabber;
	}
	if ($alien->city) {
		$city['set']=1;
		$city['text']=$alien->city;
	}
	if ($alien->site) {
		$usite['set']=1;
		$usite['text']=$alien->site;
	}
	if ($alien->icq) {
		$icq['set']=1;
		$icq['text']=$alien->icq;
	}
	if (strlen($alien->about)>1) {
		$about['set']=1;
		$about['text']=$alien->about;
	}
	if ($alien->lvl>=1) {
		$lvl['set']=1;
		$lvl['text']=$alien->lvl;
	}
	$result = db_query('SELECT * FROM inblog WHERE name = %s AND `out` = 0 ORDER BY id DESC', $alien->login);
	while ($row = db_fetch_assoc($result)) {
		$blogs[]=array('id'=>$row['blogid'],'name'=>$row['bname']);
	}
	$comment_count = db_result(db_query('SELECT COUNT(id) FROM comment WHERE who = %s', $alien->login));
	$t=0;
	if ($alien->frnd) {
		$friends = explode(",",$alien->frnd);
		trim_array($friends);
	}
	if ($own_profile) {
		$cpw = request::get_get('cpw');
		if ($cpw == 1) {
			echo render_error("Старый пароль введён неверно!");
		} elseif($cpw == 2) {
			echo render_error("Не все поля заполнены!");
		}
	} else {
		if ($loged == 1) {
			$is_friend = db_result(db_query('SELECT COUNT(id) FROM users WHERE name = %s AND (frnd LIKE %s OR frnd LIKE %s)', $usr->login, '%, ' . $alien->login . '%', '%' . $alien->login . ',%'));
		}
	}
	$allow_block=0;
	if ($usr->lvl >= $blvl) {
		$allow_block=1;
	}
	if ($alien->check_lock()) {
		$block_url="twork.php?wt=ban&who=".$name."&cur=".$cur."&unb=1";
	} else {
		$block_url="work/block/user/".$name;
	}
	echo render_template(TPL_FRAMES.'/user.tpl.php', array('name'=>$alien->login,
	'avatar'=>$avatar,'avatar_url'=>$avatar_url,'use_micro'=>$use_micro,
	'blocked'=>$alien->lck,'lvl'=>$alien->lvl,'hide_mail'=>$alien->hml,
	'mail'=>$alien->mail,'icq'=>$icq,'jabber'=>$jabber,'usite'=>$usite,'city'=>$city,
	'rate'=>$alien->rate(),'ratep_url'=>"twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur,
	'ratem_url'=>"twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur,
	'about'=>$about,'blogs'=>$blogs,'friends'=>@$friends,'is_friend'=>@$is_friend,'friend_url'=>"twork.php?wt=friend&who=".$name."&cur=".$cur,
	'post_count'=>$post_count,'comment_count'=>$comment_count,'allow_block'=>$allow_block,'block_url'=>$block_url,
	'owner'=>$own_profile,'micro_name'=>@$micro_name,'micro_url'=>@$micro_url,'micro_status'=>$alien->jtext,'block_cause'=>$alien->block_cause));
}

include ("inc/foot.php");
?>