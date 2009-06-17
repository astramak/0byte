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


<div id="main" class='vcard'><?php
if (isset($_GET['name']) && strlen($_GET['name'])>=1 ) {
	$name=$_GET['name'];
} else if (strlen($_SESSION['login'])>=1) {
	$name=$_SESSION['login'];
} else {
	$name="'";
}
$alien=new user;
if ($alien->find($name)==0) {
	echo "<h2>Пользователь с данным именем не существует!</h2>";
} else {
	$cur=$_SERVER['REQUEST_URI'];
	$cur=str_replace("&","*amp",$cur);
	$cur=str_replace("?","*qw",$cur);
	$sql_get="SELECT * FROM `post` WHERE auth = '".$alien->login."' ORDER BY  id DESC ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$kl=mysql_num_rows($result);
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
	if ($alien->hml==0)  {$ml="<a href='mailto:".$alien->mail."' class='email'>".$alien->mail."</a>";} else {$ml="Скрыт";}
	$rate=$alien->rate();
	$rt="";
	if ($rate>0) {$rt="<span class='rp'>".$rate."</span>";}
	else if ($rate<0) {$rt="<span class='rm'>".$rate."</span>";} else {$rt=0;}
	$jab="";
	if (strlen($alien->jabber)>1) {
		$jab="<tr><td>Jabber</td><td><a href='xmpp:".$alien->jabber."'>".$alien->jabber."</a></td><td>";
	}
	$city="";
	if (strlen($alien->city)>1) {
		$city="<tr><td>Город</td><td>".$alien->city."</td><td>";
	}
	$siteq="";
	if (strlen($alien->site)>1) {
		$siteq="<tr><td>Сайт</td><td><noindex><a href='".$alien->site."' rel='nofollow'>".$alien->site."</a></noindex></td></tr>";
	}
	$icq="";
	if (strlen($alien->icq)>1) {
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
	$sql_get="SELECT * FROM `inblog` WHERE  `name` = '".$alien->login."' &&  `out` = 0 ORDER BY  id DESC ";

	$result=mysql_query($sql_get,$sql);
	$numm=mysql_num_rows($result);
	$inblis="";
	while ($row = mysql_fetch_assoc($result)) {
		$inblis.= "<a href='blog/".$row['blogid']."'>".$row['bname']."</a>";
		if ($numm>1) { $inblis.=", ";}
		$numm--;
	}
	if (strlen($inblis)>=1) {
		echo "<tr><td>В блогах</td><td>".$inblis."</td></tr>";
	}
	echo "<tr><td><a href='auth/".$alien->login."/'>Всего постов</a></td><td><a href='auth/".$alien->login."/'>$kl</a></td></tr>";
	$sql_get="SELECT * FROM `comment` WHERE who = '".$alien->login."' ORDER BY  id DESC ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$kl=mysql_num_rows($result);
	echo "<tr><td><a href='comment/".$alien->login."/'>Коментариев</a></td><td><a href='comment/".$alien->login."/'>$kl</a></td></tr>";
	$t=0;
	$arr=split(",",$alien->frnd);
	$q=sizeof($arr);
	for ($z=1;$z<$q;$z++) {

		if ($t==0) {
			$t=1;
			$f=trim($arr[$z]);
			$res="<a href='user/".$f."'>".$f."</a>";
		} else {
			$f=trim($arr[$z]);
			$res.=", <a href='user/".$f."'>".$f."</a>";
		}
			
	}
	if (isset($res) && strlen($res)>=1) {
		echo "<tr><td>Друзья</td><td>$res</td></tr>";
	}
	echo "</table><br />";
	if (!isset($_GET['name']) || $_GET['name']==$_SESSION['login'] || strlen($_GET['name'])<=1) {

		echo '<br /><a href="work/edituser">Редактировать личные данные</a>  
			<a href="work/cpw">Сменить пароль</a>';
		if (isset($_GET['cpw'])) {
			if ($_GET['cpw']==1) {
				echo "<br />Старый пароль введён неверно!";
			} else {
				echo "<br />Не все поля заполнены!";
			}
		}
	} else {
		if ($loged==1) {
			$sql_get="SELECT * FROM `users` WHERE name = '".$usr->login."' && (frnd LIKE  '%, ".$alien->login."%' || frnd LIKE  '%".$alien->login.",%' ) ORDER BY  id DESC ";
			$result=mysql_query($sql_get,$sql);
			if (!$result) {
				echo  mysql_error();
			}
			$row = mysql_fetch_assoc($result);

			if ($row['name']!=$usr->login) {
				echo "<br/><a id='ifrn' href='twork.php?wt=friend&who=".$name."&cur=".$cur."'>Добавить в друзья</a>";
			} else {
				echo "<br /><a id='ofrn' href='twork.php?wt=friend&who=".$name."&cur=".$cur."'>Перестать дружить</a>";
			}
		}

	}

	if ($usr->lvl>=$blvl) {
		echo "<br /><br /><a href='twork.php?wt=ban&who=".$name."&cur=".$cur."&unb=".$un."'>".$unh."блокировать</a>";
	}
}
?></div>



<?php
include ("inc/foot.php");
?>