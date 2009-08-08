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
if (strlen(request::get_get('name')) >= 1) {
    $name = request::get_get('name');
} elseif (isset($_SESSION['login']) && strlen($_SESSION['login'])) {
    $name = $_SESSION['login'];
    $own_profile = true;
} else {
    $name = "";
}
$alien = new user();
if (!$alien->find($name)) {
    echo render_error("Пользователь с данным именем не существует!");
} else {
    $cur = $_SERVER['REQUEST_URI'];
    $cur = str_replace("&","*amp",$cur);
    $cur = str_replace("?","*qw",$cur);
    $avatar=0;
    $avatar_url=null;
    $post_count = db_result(db_query('SELECT COUNT(id) FROM post WHERE auth = %s ORDER BY id DESC', $alien->login));
    //		echo "<h2><span class='fn'>".$alien->login."</span>  <a href='work/pmnew/".$alien->login."'><img alt='ЛС' src='style/img/envelope.gif' /></a></h2>";
    if (strlen($alien->av)>2) {
    //			echo "<img class='photo' style='float:right' src='res.php?t=av&img=".$alien->av."' alt='' />";
        $avatar=1;
        $avatar_url="res.php?t=av&img=".$alien->av;
    }
    $un="0";
    //		$unh="За";
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
    //			echo "<span class='jst'>".$alien->jname."@".$src.": ".$alien->jtext."</span>";
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
    //			$jab="<tr><td>Jabber</td><td><a href='xmpp:".$alien->jabber."'>".$alien->jabber."</a></td><td>";
    }
    //		$city="";
    if ($alien->city) {
        $city['set']=1;
        $city['text']=$alien->city;
    //			$city="<tr><td>Город</td><td>".$alien->city."</td><td>";
    }
    //		$siteq="";
    if ($alien->site) {
        $usite['set']=1;
        $usite['text']=$alien->site;
    //			$siteq="<tr><td>Сайт</td><td><noindex><a href='".$alien->site."' rel='nofollow'>".$alien->site."</a></noindex></td></tr>";
    }
    if ($alien->icq) {
        $icq['set']=1;
        $icq['text']=$alien->icq;
    //			$icq="<tr><td>ICQ</td><td>".$alien->icq."</td></tr>";
    }
    //		$ab="";
    if (strlen($alien->about)>1) {
        $about['set']=1;
        $about['text']=$alien->about;
    //			$ab="<tr><td>О себе:</td><td><span class='note'>".$alien->about."</span></td></tr>";
    }
    //		$echlv="";
    if ($alien->lvl>=1) {
        $lvl['set']=1;
        $lvl['text']=$alien->lvl;
    //			$echlv="<tr><td>Уровень доступа</td><td>".$alien->lvl."</td></tr>";
    }
    //		echo " <table border='0'>
    //			".$echlv."
    //			<tr><td>E-mail</td><td>".$ml."</td></tr>".$icq.$jab.$siteq.$city."<tr><td>Рейтинг</td><td>
    //			<a class='ratep' href='twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur."'>+</a>
    //		<span id='ru".$alien->login."'>
    //			".$rt."
    //			</span>
    //			<a class='ratem' href='twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur."'>&ndash;</a></td></tr>
    //		".$ab;

    $result = db_query('SELECT * FROM inblog WHERE name = %s AND `out` = 0 ORDER BY id DESC', $alien->login);
    //		$inblis = array();
    while ($row = db_fetch_assoc($result)) {
        $blogs[]=array('id'=>$row['blogid'],'name'=>$row['bname']);
    //			$inblis[] = "<a href='blog/".$row['blogid']."'>".$row['bname']."</a>";
    }
    //		if ($inblis) {
    //			echo "<tr><td>В блогах</td><td>" . implode(', ', $inblis) . "</td></tr>";
    //		}
    //		echo "<tr><td><a href='auth/".$alien->login."/'>Всего постов</a></td><td><a href='auth/".$alien->login."/'>$kl</a></td></tr>";
    $comment_count = db_result(db_query('SELECT COUNT(id) FROM comment WHERE who = %s', $alien->login));
    //		echo "<tr><td><a href='comment/".$alien->login."/'>Коментариев</a></td><td><a href='comment/".$alien->login."/'>$kl</a></td></tr>";
    $t=0;
    if ($alien->frnd) {
        $friends = explode(",",$alien->frnd);
        trim_array($friends);
    //			$friends = array();
    //			foreach ($arr as $f) {
    //				$friends[] = "<a href='user/".$f."'>".$f."</a>";
    //			}
    //			echo "<tr><td>Друзья</td><td>" . implode(', ', $friends) . "</td></tr>";
    }
    //		echo "</table><br /
    if ($own_profile) {
    //			echo '<br /><a href="work/edituser">Редактировать личные данные</a>
    //			<a href="work/cpw">Сменить пароль</a>';
        $cpw = request::get_get('cpw');
        if ($cpw == 1) {
            echo render_error("Старый пароль введён неверно!");
        } elseif($cpw == 2) {
            echo render_error("Не все поля заполнены!");
        }
    } else {
        if ($loged == 1) {
            $is_friend = db_result(db_query('SELECT COUNT(id) FROM users WHERE name = %s AND (frnd LIKE %s OR frnd LIKE %s)', $usr->login, '%, ' . $alien->login . '%', '%' . $alien->login . ',%'));
        //				if (!$is_friend) {
        //					echo "<br/><a id='ifrn' href='twork.php?wt=friend&who=".$name."&cur=".$cur."'>Добавить в друзья</a>";
        //				} else {
        //					echo "<br /><a id='ofrn' href='twork.php?wt=friend&who=".$name."&cur=".$cur."'>Перестать дружить</a>";
        //				}
        }
    }
    $allow_block=0;
    if ($usr->lvl >= $blvl) {
        $allow_block=1;
    //			echo "<br /><br /><a href='twork.php?wt=ban&who=".$name."&cur=".$cur."&unb=".$un."'>".$unh."блокировать</a>";
    }
    //                "twork.php?wt=ban&who=".$name."&cur=".$cur."&unb=".$un
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
    'about'=>$about,'blogs'=>$blogs,'friends'=>@$friends,'is_friend'=>$is_friend,'friend_url'=>"twork.php?wt=friend&who=".$name."&cur=".$cur,
    'post_count'=>$post_count,'comment_count'=>$comment_count,'allow_block'=>$allow_block,'block_url'=>$block_url,
    'owner'=>$own_profile));
}

include ("inc/foot.php");
?>