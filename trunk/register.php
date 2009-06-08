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
$reg=1;
	include("cfg.php");
	if (isset($_POST['login']) && isset($_POST['pwd']) && isset($_POST['pwd2']) && $_POST['pwd']==$_POST['pwd2'] && isset($_POST['mail']) && isset ($_POST['kap'])
	&& strlen($_POST['mail'])>5 && strlen($_POST['pwd'])>3
	&& chud($_POST['login']) && chud($_POST['pwd']) && chud($_POST['kap']) && chml($_POST['mail'])
	) {
		$name=gtext($_POST['login']); $pwd=md5($_POST['pwd']); $mail=gtext($_POST['mail']); $icq=gtext($_POST['icq']);
		$jabber=gtext($_POST['jabber']); $site=gtext($_POST['site']);
		$about=gtext($_POST['about']);
		$sql_get="SELECT * FROM `users` WHERE LOWER(name) = LOWER('".$name."')   ";
			$result=mysql_query($sql_get,$sql);
			if (!$result) {
				echo  mysql_error();
			}
		$row = mysql_fetch_assoc($result);
			$sql_get="SELECT * FROM `users` WHERE LOWER(mail) = LOWER('".$_POST['mail']."')   ";
			$result=mysql_query($sql_get,$sql);
			if (!$result) {
				echo  mysql_error();
			}
		$rw = mysql_fetch_assoc($result);
		if (strtolower($row['name'])!=strtolower($name) && strtolower($rw['mail'])!=strtolower($_POST['mail'])) {
	//<kap>
	session_start();
	$a=md5(session_id());
	$a1=ord($a[2]);
	$a2=ord($a[4]);
	$zn=ord($a[6]);
	while ($a1>15) {$a1=$a1-10; }
	while ($a2>15) {$a2=$a2-10; }
	if ($zn%2==0) { $res=$a1+$a2;} else 	if ($zn%3==0) { $res=$a1*$a2; }
	else { $res=$a1-$a2; }

	if ($_POST['kap']==$res) {
		
		if ($eml_a==1) {
		 $e_s=0;
		} else {$e_s=1;}
		
		$sl="INSERT INTO `$sql_db`.`users` (`name`, `mail`, `icq`, `jabber`, `site`, `lvl`, `pwd` ,`about`, `activ`) 
		VALUES ( '$name', '$mail', '$icq', '$jabber', '$site', '', '$pwd', '$about', '$e_s')";
		$result=mysql_query($sl,$sql);		
		
		if ($eml_a==1) {
			
				$sql_get="SELECT * FROM `users` WHERE name = '".$name."'   ";
			$result=mysql_query($sql_get,$sql);
			if (!$result) {
				echo  mysql_error();
			}
		$row = mysql_fetch_assoc($result);
			
		mail($mail, "Регистрация на ".$s_name,
		 "Для продолжения регистрации перейдите <a href='http://welinux.ru/active.php?id=".$row['id']."&name=".$name."'>по этой ссылке</a>"
		, "Content-type: text/html; charset='UTF-8'\r\n" .
		'From: register'.$eml."\r\n" .
    'Reply-To: register'.$eml."\r\n" .
    'X-Mailer: PHP/' . phpversion());
		}
		
		header("Request-URI: login/new");
		header("Content-Location: login/new");
		header("Location: login/new"); 	
	} else {
		$err=3;
	}
			session_destroy();		
		} else {
			
			$err=1;
		}

	} else {
		if (isset($_GET['reg'])) {
			$err=2;	
		}
	}
	include("inc/head.php");
include 'inc/top.php';
 ?>


<div id="golog">
<h3>Регистрация</h3>
<?php
if ($err==1) {
	echo_err('Пользователь с таки именем уже существует!');
} else if ($err==3) {
	echo_err("Капча введена не правильно, вы бот?");
} else if ($err==2) {
	echo_err("Не все поля заполнены, либо вы используюте спец. символы!");
}
?>
<p>Поля, помеченные <b>*</b> обязательны для заполнения!</p>
<form name="reg" method="post" action="register.php?reg" id="reg">
<table border="0">
<tr><td>Логин</td><td><input type="text" name="login" onkeyup="chka(this,'login')" value='<?php if (isset($_POST['login'])) {echo $_POST['login'];} ?>' /></td><td><b id='clogin'>*</b></td></tr>
<tr><td>Пароль</td><td><input type="password" name="pwd" onkeyup="chkpwd(this.form)"  /></td><td><b id='pwd'>*</b></td></tr>
<tr><td>Повтор</td><td><input type="password" name="pwd2" onkeyup="chkpwd(this.form)" /></td><td><b id='pwd2'>*</b></td></tr>
<tr><td>E-mail</td><td><input type="text" name="mail" onkeyup="chka(this,'mail')" value='<?php if (isset($_POST['mail'])) {echo $_POST['mail'];} ?>' /></td><td><b id='cmail'>*</b></td></tr>
<tr><td>icq</td><td><input type="text" name="icq" value='<?php if (isset($_POST['icq'])) {echo $_POST['icq'];} ?>' /></td></tr>
<tr><td>jabber</td><td><input type="text" name="jabber" value='<?php if (isset($_POST['jabber'])) {echo $_POST['jabber'];} ?>' /></td></tr>
<tr><td>Сайт</td><td><input type="text" name="site" value='<?php if (isset($_POST['site'])) {echo $_POST['site'];} ?>' /></td></tr>
<tr><td>О себе</td><td><textarea name="about" rows="5" cols="30"><?php if (isset($_POST['about'])) {echo $_POST['about'];} ?></textarea></td></tr>
<tr><td><img src="cap/kap.php?rand=<?php echo rand(); ?>" alt="капча" onClick="this.src='cap/kap.php?rand='+Math.random()" alt="" /></td><td><input type="text" name="kap" onkeyup="chka(this,'cap')" /></td><td><b id='ccap'>*</b></td></tr>
<tr><td></td><td><input type="submit" value="Регистрироваться!" /></td></tr>
</table>
</form><br />
После регистрации на вашу электронную почту придёт письмо для подтверждения регистрации. 
</div>
<?php
	include("inc/foot.php");
?>