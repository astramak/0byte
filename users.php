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
?>

<div id="main" class='vcard'>
	<?php
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
		echo "<h2>Пользователь с данным именем не существует!</h2>";
	} else {
		$cur = $_SERVER['REQUEST_URI'];
		$cur = str_replace("&","*amp",$cur);
		$cur = str_replace("?","*qw",$cur);
		$kl = db_result(db_query('SELECT COUNT(id) FROM post WHERE auth = %s ORDER BY id DESC', $alien->login));
		echo "<h2><span class='fn'>".$alien->login."</span>  <a href='work/pmnew/".$alien->login."'><img alt='ЛС' src='style/img/envelope.gif' /></a></h2>";
		if (strlen($alien->av)>2) {
			echo "<img class='photo' style='float:right' src='res.php?t=av&img=".$alien->av."' alt='' />";
		}
		$un="0";
		$unh="За";
		if ($alien->g_j()!=0) {
			if ($alien->juse==1) {
				$src="juick";
			} else {
				$src="twitter";
				$alien->jtext=substr($alien->jtext,strlen($alien->jname)+2);
			}
			echo "<span class='jst'>".$alien->jname."@".$src.": ".$alien->jtext."</span>";
		}
		if ($alien->lck==1) { echo "<h3>Пoльзователь заблокирован</h3>";
			$un=1; $unh="Раз";
		}
		if ($alien->hml==0) {$ml="<a href='mailto:".$alien->mail."' class='email'>".$alien->mail."</a>";} else {$ml="Скрыт";}
		$rate=$alien->rate();
		$rt="";
		if ($rate>0) {$rt="<span class='rp'>".$rate."</span>";}
		elseif ($rate<0) {$rt="<span class='rm'>".$rate."</span>";}
		else {$rt=0;}
		$jab="";
		if ($alien->jabber) {
			$jab="<tr><td>Jabber</td><td><a href='xmpp:".$alien->jabber."'>".$alien->jabber."</a></td><td>";
		}
		$city="";
		if ($alien->city) {
			$city="<tr><td>Город</td><td>".$alien->city."</td><td>";
		}
		$siteq="";
		if ($alien->site) {
			$siteq="<tr><td>Сайт</td><td><noindex><a href='".$alien->site."' rel='nofollow'>".$alien->site."</a></noindex></td></tr>";
		}
		$icq="";
		if ($alien->icq) {
			$icq="<tr><td>ICQ</td><td>".$alien->icq."</td></tr>";
		}
		$ab="";
		if (strlen($alien->about)>1) {
			$ab="<tr><td>О себе:</td><td><span class='note'>".$alien->about."</span></td></tr>";
		}
		$echlv="";
		if ($alien->lvl>=1) {
			$echlv="<tr><td>Уровень доступа</td><td>".$alien->lvl."</td></tr>";
		}
		echo " <table border='0'>
			".$echlv."
			<tr><td>E-mail</td><td>".$ml."</td></tr>".$icq.$jab.$siteq.$city."<tr><td>Рейтинг</td><td>
			<a class='ratep' href='twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur."'>+</a>
		<span id='ru".$alien->login."'>
			".$rt."
			</span>
			<a class='ratem' href='twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur."'>&ndash;</a></td></tr>
		".$ab;

		$result = db_query('SELECT * FROM inblog WHERE name = %s AND `out` = 0 ORDER BY id DESC', $alien->login);
		$inblis = array();
		while ($row = db_fetch_assoc($result)) {
			$inblis[] = "<a href='blog/".$row['blogid']."'>".$row['bname']."</a>";
		}
		if ($inblis) {
			echo "<tr><td>В блогах</td><td>" . implode(', ', $inblis) . "</td></tr>";
		}
		echo "<tr><td><a href='auth/".$alien->login."/'>Всего постов</a></td><td><a href='auth/".$alien->login."/'>$kl</a></td></tr>";
		$kl = db_result(db_query('SELECT COUNT(id) FROM comment WHERE who = %s', $alien->login));
		echo "<tr><td><a href='comment/".$alien->login."/'>Коментариев</a></td><td><a href='comment/".$alien->login."/'>$kl</a></td></tr>";
		$t=0;
		if ($alien->frnd) {
			$arr = explode(",",$alien->frnd);
			array_walk($arr, create_function('&$v,$k', '$v = trim($v);'));
			$friends = array();
			foreach ($arr as $f) {
				$friends[] = "<a href='user/".$f."'>".$f."</a>";
			}
			echo "<tr><td>Друзья</td><td>" . implode(', ', $friends) . "</td></tr>";
		}
		echo "</table><br />";
		if ($own_profile || (isset($_SESSION['login']) && $name == $_SESSION['login'])) {
			echo '<br /><a href="work/edituser">Редактировать личные данные</a>
			<a href="work/cpw">Сменить пароль</a>';
			$cpw = request::get_get('cpw');
			if ($cpw == 1) {
				echo "<br />Старый пароль введён неверно!";
			} elseif($cpw == 2) {
				echo "<br />Не все поля заполнены!";
			}
		} else {
			if ($loged == 1) {
				$is_friend = db_result(db_query('SELECT COUNT(id) FROM users WHERE name = %s AND (frnd LIKE %s OR frnd LIKE %s)', $usr->login, '%, ' . $alien->login . '%', '%' . $alien->login . ',%'));
				if (!$is_friend) {
					echo "<br/><a id='ifrn' href='twork.php?wt=friend&who=".$name."&cur=".$cur."'>Добавить в друзья</a>";
				} else {
					echo "<br /><a id='ofrn' href='twork.php?wt=friend&who=".$name."&cur=".$cur."'>Перестать дружить</a>";
				}
			}
		}

		if ($usr->lvl >= $blvl) {
			echo "<br /><br /><a href='twork.php?wt=ban&who=".$name."&cur=".$cur."&unb=".$un."'>".$unh."блокировать</a>";
		}
	}
	?>
</div>

<?php
include ("inc/foot.php");
?>