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
	$pwd = md5($pwd);
	$icq = request::get_post('icq');
	$jabber = request::get_post('jabber');
	$site = request::get_post('site');
	$about = request::get_post('about');

	$name_exists = db_num_rows(db_query('SELECT id FROM users WHERE LOWER(name) = LOWER(%s)', $name));
	$mail_exists = db_num_rows(db_query('SELECT id FROM users WHERE LOWER(mail) = LOWER(%s)', $mail));
	if (!($name_exists && $mail_exists)) {
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

		if (request::get_post('kap') == $res) {
			db_query('INSERT INTO users SET name = %s, mail = %s, icq = %s, jabber = %s, site = %s, lvl = %d, pwd = %s, about = %s, activ = %d, timezone = %d',
			$name, $mail, $icq, $jabber, $site, 0, $pwd, $about, ($eml_a ? 0 : 1),$server_time);

			if ($eml_a==1) {
				$to = $mail;
				$subject = "Регистрация на ".$s_name;
				$message = render_mail('register', array(
					'id' => db_last_insert_id('users'),
					'name' => $name,
				));
				$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
				nullbyte_mail($to, $subject, $message, true, $headers);
			}
			redirect('login/new');
		} else {
			$err=3;
		}
		session_destroy();
	} else {
		$err=1;
	}

} else {
	if (request::get_get('reg')) {
		$err=2;
	}
}

include("inc/head.php");
include 'inc/top.php';

$register_arr=array("reg_login" => $name, "reg_mail" => $mail,
	"reg_icq" => $icq, "reg_jabber" => $jabber, "reg_site" => $site,
	"reg_about" => $about, "error" => $err, "email_register" => $eml_a);

echo render_register_page($register_arr);

include("inc/foot.php");
?>