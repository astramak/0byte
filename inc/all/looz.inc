<?php
if (isset($_GET['nick'])) {
	$alien=new user;
	function generate_password($number) {
		$arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',  
                 'm','n','o','p','r','s',  
                 't','u','v','x','y','z',  
                 'A','B','C','D','E','F',  
                 'G','H','I','J','K','L',  
                 'M','N','O','P','R','S',  
                 'T','U','V','X','Y','Z',  
                 '1','2','3','4','5','6',  
                 '7','8','9','0');  
		$pass = "";
		for($i = 0; $i < $number; $i++) {
			$index = rand(0, count($arr) - 1);
			$pass .= $arr[$index];
		}
		return $pass;
	}
	$psw=generate_password(8);
	if ($alien->looser(gtext($_GET['nick']))==1) {

		mail($alien->mail, "Восстановление пароля",
		 "Для продолжения восстановления пароля перейдите <a href='http://welinux.ru/all.php?wt=chpwd&user=".$alien->login."&id=".$alien->pwd
		."&ld=".md5($psw)."'>по этой ссылку</a> \n Ваш новый пароль - ".$psw
		, "Content-type: text/html; charset='UTF-8'\r\n" .
		'From: register'.$eml."\r\n" .
    'Reply-To: register'.$eml."\r\n" .
    'X-Mailer: PHP/' . phpversion());

		echo "<h2>Проверьте свою электронную почту!</h2>";
	}
}
?>