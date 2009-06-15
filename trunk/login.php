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
if (isset($_GET['js'])) {
	header("Content-Type: text/html; charset=utf-8");

}
include ("cfg.php");
if (!isset($_GET['cur']) || strlen($_GET['cur'])<3) {
	$lst=$site;
} else {
	$lst=$_GET['cur'];
	$lst=str_replace("*amp","&",$lst);
	$lst=str_replace("*qw","?",$lst);
}
if (isset($_POST['login']) && isset($_POST['pwd'])) {
	$usr->login=$_POST['login'];
	$usr->pwd=md5($_POST['pwd']);
	if ($usr->check()) {
		session_start();
		if ($zap=="on") {
			$dt = mktime(0,0,0,1,1,2010);
			setcookie('login', $_POST['login'], $dt);
			setcookie('pwd', base64_encode($_POST['pwd']), $dt);
		}
		$_SESSION['login']=$_POST['login'];
		$_SESSION['pwd']=base64_encode($_POST['pwd']);
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
	} else {
		$err=1;
	}
}
if (!isset($_GET['js'])) {
	include ("inc/head.php");
	include("inc/top.php");

	echo '<div id="login">';
	crl(0);
	echo '<div id="lgn">'; }
	if (isset($_GET['new']) && $eml_a==1) {
		echo "<b>Перед входом активируйте свою учётную запись, для этого проверьте свою электронную почту и пройдите по полученной ссылке!</b>";
	}
	?>
<form name="ta" method="post"
	action="login.php?cur=<?php echo $_GET['cur']; ?>">
<table border="0">
	<tr>
		<td>Логин:</td>
		<td><input type="text" name="login" /></td>
	</tr>
	<tr>
		<td>Пароль:</td>
		<td><input type="password" name="pwd" /></td>
	</tr>
	<tr>
		<td>Запомнить:</td>
		<td><input type="checkbox" name="zap" /></td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Войти" /> <?php  
		if (isset($_GET['js'])) {
			echo "<input type='button' onblur='onBlur(this)' onfocus='onFocus(this)' onClick='unlogin()' value='Вернуться' />";
		}
		?></td>
	</tr>
</table>
</form>
<a href='register'>Зарегистрироваться</a>
		<?php
		if (isset($_POST['login'])) {
			echo " <a href='looz/".gtext($_POST['login'])."'>Забыли пароль?</a>";
		}

		if (!isset($_GET['js'])) {
			echo '<br /></div>';
			crl(1);
			echo '</div>';
			include("inc/foot.php"); }
			?>