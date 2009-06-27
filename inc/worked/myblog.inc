
<?php
$sql_get="SELECT * FROM `blogs` WHERE owner = '".mysql_escape_string($_SESSION['login'])."'   ";
$result=mysql_query($sql_get,$sql);
//echo $sql_get;
while ( $row = mysql_fetch_assoc($result)) {
//	echo "<h3><a href='blog/".$row['id']."'>".$row['name']."</a></h3>";
	$av=0;
    if (strlen($row['av'])>0) {
//		echo "<img style='float:right' src='res.php?t=bl&img=".$row['av']."' alt='' />";
$av=1;
 }
//		echo "<h4 class='elt'>Участники:</h4><ul>";
		$sql_get="SELECT * FROM `inblog` WHERE blogid = '".intval($row['id'])."'   ";
		$resul=mysql_query($sql_get,$sql);
		if (!$result) {
			echo  mysql_error();
		}
		while ( $rw = mysql_fetch_assoc($resul)) {
            $users[]=$rw['name'];
//			echo "<li><a href='user/".$rw['name']."'>".$rw['name']."</a></li>";
		}
        $blogs[]=array('name'=>$row['name'],'id'=>$row['id'],'avatar'=>$av,'avatar_url'=>$row['av'],
        'users'=>$users,'ch_url'=>"twork.php?wt=editblog&bid=".$row['id'],'about'=>$row['about'],
    'av_ch_url'=>"twork.php?wt=bimg&bid=".$row['id']);
//		echo "</ul>";
//		echo "<h4 class='elt'>Описание</h4><form method='post'action='twork.php?wt=editblog&bid=".$row['id']."'>
//	 	<textarea name='text'>".$row['about']."</textarea><input type='submit' value='Отправить' />
//	 	</form>";
//		echo "<h4 class='elt'>Смена картинки:</h4>
//	 	<form method='post' enctype='multipart/form-data' action='twork.php?wt=bimg&bid=".$row['id']."'>
//<input type='file' name='img' />
//<input type='submit' value='Загрузить' />
//</form><a href='work/rmblog/".$row['id']."'>Удалить</a>";
}
echo render_myblog($blogs);
?>
