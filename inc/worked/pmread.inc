<?php
//echo $usr->login."</h2><a href='work/pmls'>Входящие</a>  <a href='work/pmls/out'>Исходящие</a> <a href='work/pmnew'>Написать</a><br />";
$sql_get="SELECT * FROM `pm` WHERE `id` = '".intval(request::get_get('id'))."' && (`to` = '".mysql_escape_string($usr->login)."' || `auth` = '".mysql_escape_string($usr->login)."') ORDER BY  id DESC  ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}

$row = mysql_fetch_assoc($result);
if ($row['id']==$_GET['id']) {
    echo render_template(TPL_PM."/top.tpl.php", array('id'=>intval(request::get_get('id')),'login'=>$usr->login));
	pm_echo($row);
//	echo "<a href='work/pmnew/".$row['auth']."'>Ответить</a>";

	$sql_get="UPDATE `pm` SET `readed` = '1' WHERE `id` = '".intval($_GET['id'])."'";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
}
?>
