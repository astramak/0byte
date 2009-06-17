<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it andor modify
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
include ("cfg.php");
$reg=1;
$js=request::get_get("js",0);
if ($js) {
	header("Content-Type: text/html; charset=utf-8");

}
$cur=request::get_get("cur");
if (strlen($cur)<3) {
	$lst=$site;
} else {
	$lst=$cur;
	$lst=str_replace("*amp","&",$lst);
	$lst=str_replace("*qw","?",$lst);
}
if (strlen(request::get_post('login'))>2 && strlen(request::get_post('pwd'))>2) {
	$usr->login=request::get_post('login');
	$usr->pwd=md5(request::get_post('pwd'));
	if ($usr->check()) {
		session_start();
		if ($zap=="on") {
			$dt = mktime(0,0,0,1,1,2010);
			setcookie('login', request::get_post('login'), $dt);
			setcookie('pwd', base64_encode(request::get_post('pwd')), $dt);
		}
		$_SESSION['login']=request::get_post('login');
		$_SESSION['pwd']=base64_encode(request::get_post('pwd'));
		header("Request-URI: $lst");
		header("Content-Location: $lst");
		header("Location: $lst");
	} else {
		$err=1;
	}
}
if (!$js) {
	include ("inc/head.php");
	include("inc/top.php");
}
//	echo '<div id="login">';
//	crl(0);
//	echo '<div id="lgn">'; }
//if (request::get_get('new') && $eml_a==1) {
//		echo "<b>Перед входом активируйте свою учётную запись, для этого проверьте свою электронную почту и пройдите по полученной ссылке!</b>";
//	}
	
//<form name="ta" method="post"
//	action="login.php?cur=<?php echo $_GET['cur']; ?\>">
//<table border="0">
//	<tr>
//		<td>Логин:</td>
//		<td><input type="text" name="login" /></td>
//	</tr>
//	<tr>
//		<td>Пароль:</td>
//		<td><input type="password" name="pwd" /></td>
//	</tr>
//	<tr>
//		<td>Запомнить:</td>
//		<td><input type="checkbox" name="zap" /></td>
//	</tr>
//	<tr>
//		<td></td>
//		<td><input type="submit" value="Войти" /> <?php
//		if (isset($_GET['js'])) {
//			echo "<input type='button' onblur='onBlur(this)' onfocus='onFocus(this)' onClick='unlogin()' value='Вернуться' />";
//		}
//		?\></td>
//	</tr>
//</table>
//</form>
//<a href='register'>Зарегистрироваться</a>
//
//
if (request::get_get("new") && $eml_a) {$new=1;} else {$new=0;}
echo render_login(request::get_post("login", 0), $cur, $js,$new);
		if (!$js) {
//			echo '<br /></div>';
//			crl(1);
//			echo '</div>';
			include("inc/foot.php"); }
			?>