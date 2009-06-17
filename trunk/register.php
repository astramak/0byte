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
$err=0;
include("cfg.php");

$name = request::get_post('login');
$pwd = request::get_post('pwd');
$pwd2 = request::get_post('pwd2');
$mail = request::get_post('mail');
$kap = request::get_post('kap');

if ($name && $pwd && $pwd2 && $pwd == $pwd2 && $mail && $kap
	&& strlen($mail) > 5 && strlen($pwd) > 3
	&& chud($name) && chud($pwd) && chud($pwd) && chml($mail)
) {
	$name = gtext($name);
	$pwd = md5($pwd);
	$mail = gtext($mail);
	$icq = gtext(request::get_post('icq'));
	$jabber = gtext(request::get_post('jabber'));
	$site = gtext(request::get_post('site'));
	$about = gtext(request::get_post('about'));

	$sql_get="SELECT * FROM `users` WHERE LOWER(name) = LOWER('".$name."')   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	$sql_get="SELECT * FROM `users` WHERE LOWER(mail) = LOWER('".$mail."')   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$rw = mysql_fetch_assoc($result);
	if (strtolower($row['name'])!=strtolower($name) && strtolower($rw['mail'])!=strtolower($mail)) {
		session_start();
		$a=md5(session_id());
		$a1=ord($a[2]);
		$a2=ord($a[4]);
		$zn=ord($a[6]);
		while ($a1>15) {$a1=$a1-10; }
		while ($a2>15) {$a2=$a2-10; }
		if ($zn%2==0) {
			$res=$a1+$a2;
		} elseif ($zn%3==0) {
			$res=$a1*$a2;
		} else {
			$res=$a1-$a2;
		}

		if ($_POST['kap']==$res) {
			if ($eml_a==1) {
				$e_s=0;
			} else {
				$e_s=1;
			}

			$sl="INSERT INTO `users` (`name`, `mail`, `icq`, `jabber`, `site`, `lvl`, `pwd` ,`about`, `activ`)
		VALUES ( '$name', '$mail', '$icq', '$jabber', '$site', '', '$pwd', '$about', '$e_s')";
			$result=mysql_query($sl,$sql);

			if ($eml_a==1) {
				$sql_get="SELECT * FROM `users` WHERE name = '".$name."'   ";
				$result=mysql_query($sql_get,$sql);
				if (!$result) {
					echo  mysql_error();
				}
				$row = mysql_fetch_assoc($result);

				$to = $mail;
				$subject = "Регистрация на ".$s_name;
				$message = render_mail('register', array(
					'id' => $row['id'],
					'name' => $name,
				));
				$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
				nullbyte_mail($to, $subject, $message, true, $headers);
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



//<div id="golog">
//	<h3>Регистрация</h3>

//	if ($err==1) {
//		echo_err('Пользователь с таки именем уже существует!');
//	} elseif ($err==3) {
//		echo_err("Капча введена не правильно, вы бот?");
//	} elseif ($err==2) {
//		echo_err("Не все поля заполнены, либо вы используюте спец. символы!");
//	}
//
//	<p>Поля, помеченные <span class="required">*</span> обязательны для заполнения!</p>
//	<form method="post" action="register.php?reg" id="reg">
//		<table border="0">
//			<tr>
//				<td>Логин <div class="required" id='clogin'>*</div></td>
//				<td><input type="text" name="login" onkeyup="chka(this,'login')" value='<?php echo request::get_post('login') ' /></td>
//			</tr>
//			<tr>
//				<td>Пароль <div class="required" id='pwd'>*</div></td>
//				<td><input type="password" name="pwd" onkeyup="chkpwd(this.form)"  /></td>
//			</tr>
//			<tr>
//				<td>Повтор <div class="required" id='pwd2'>*</div></td>
//				<td><input type="password" name="pwd2" onkeyup="chkpwd(this.form)" /></td>
//			</tr>
//			<tr>
//				<td>E-mail <div class="required" id='cmail'>*</div></td>
//				<td><input type="text" name="mail" onkeyup="chka(this,'mail')" value='<?php echo request::get_post('mail') ' /></td>
//			</tr>
//			<tr>
//				<td>ICQ</td>
//				<td><input type="text" name="icq" value='<?php echo request::get_post('icq') ' /></td>
//			</tr>
//			<tr>
//				<td>Jabber</td>
//				<td><input type="text" name="jabber" value='<?php echo request::get_post('jabber') ' /></td>
//			</tr>
//			<tr>
//				<td>Сайт</td>
//				<td><input type="text" name="site" value='<?php echo request::get_post('site') ' /></td>
//			</tr>
//			<tr>
//				<td>О себе</td>
//				<td><textarea name="about" rows="5" cols="30"><?php echo request::get_post('about') </textarea></td>
//			</tr>
//			<tr>
//				<td>
//					<img src="cap/kap.php?rand=<?php echo rand(); " alt="капча" onclick="this.src='cap/kap.php?rand='+Math.random()" />
//					<div class="required" id='ccap'>*</div>
//				</td>
//				<td><input type="text" name="kap" onkeyup="chka(this,'cap')" /></td>
//			</tr>
//			<tr>
//				<td>&nbsp;</td>
//				<td><input type="submit" value="Регистрироваться!" /></td>
//			</tr>
//		</table>
//	</form>

    $register_arr=array("reg_login"=>request::get_post('login'),"reg_mail"=>request::get_post('mail'),
"reg_icq"=>request::get_post('icq'),"reg_jabber"=>request::get_post('jabber'),"reg_site"=>request::get_post('site'),
    "reg_about"=>request::get_post('about'),"error"=>$err,"email_register"=>$eml_a);
    echo render_register_page($register_arr);
//	if ($eml_a):
//
//	<br />
//	После регистрации на вашу электронную почту придёт письмо для подтверждения регистрации.
//
//	endif;
//
//</div>
//
include("inc/foot.php");
?>