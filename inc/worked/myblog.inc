<h2>Мои блоги</h2>
<?php
$sql_get="SELECT * FROM `blogs` WHERE owner = '".mysql_escape_string($_SESSION['login'])."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
while ( $row = mysql_fetch_assoc($result)) {
	echo "<h3><a href='blog/".$row['id']."'>".$row['name']."</a></h3>";
	if (strlen($row['av'])>0) {
		echo "<img style='float:right' src='res.php?t=bl&img=".$row['av']."' alt='' />"; }
		echo "<h4 class='elt'>Участники:</h4><ul>";
		$sql_get="SELECT * FROM `inblog` WHERE blogid = '".intval($row['id'])."'   ";
		$resul=mysql_query($sql_get,$sql);
		if (!$result) {
			echo  mysql_error();
		}
		while ( $rw = mysql_fetch_assoc($resul)) {
			echo "<li><a href='user/".$rw['name']."'>".$rw['name']."</a></li>";
		}
		echo "</ul>";
		echo "<h4 class='elt'>Описание</h4><form method='post'action='twork.php?wt=editblog&bid=".$row['id']."'>
	 	<textarea name='text'>".$row['about']."</textarea><input type='submit' value='Отправить' />
	 	</form>";
		echo "<h4 class='elt'>Смена картинки:</h4>
	 	<form method='post' enctype='multipart/form-data' action='twork.php?wt=bimg&bid=".$row['id']."'>
<input type='file' name='img' />
<input type='submit' value='Загрузить' />
</form><a href='work/rmblog/".$row['id']."'>Удалить</a>";
}
?>
