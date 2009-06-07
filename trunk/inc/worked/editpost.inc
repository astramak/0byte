<?php
$sql_get="SELECT * FROM `post` WHERE id = '".gint($_GET['post'])."'   ";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row = mysql_fetch_assoc($result);
if ($usr->login==$row['auth'] || $usr->lvl>$elvl) {
	$zz=$row['ftext'];
	if (strpos($row['text'],"[fcut]")) {
		$zz=$row['text'].$row['ftext'];
	}
	$h="";
	if ($row['lock']==1) {
		$h='checked="checked"';
	}
	echo '
		<h3>Редактирование сообщения</h3>';
	echo '<form id="new" name="new" method="post" action="twork.php?wt=editpost&post='.gint($_GET['post']).'">';
	if ($row['tp']==3) {
		echo '<b>В опросах запрещено изменять вопрос и ответы, для редактирования доступны только теги и доступ!</b>
			<br />
Блог<select name="blog">
		<option value="own">Персональный</option>';

		$sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."'  ";
		$resul=mysql_query($sql_get,$sql);
		if (!$resul) {
			echo  mysql_error();
		}
		while ($rw = mysql_fetch_assoc($resul)) {
			if ($rw['blogid']==$row['blogid']) {$fin=' selected ';} else {$fin="";}

			echo "<option value='".$rw['blogid']."' $fin >".$rw['bname']."</option>";
		}

		echo "</select> <br />
			Тэги ".'<input type="text" name="tag" style="width: 500px;" value="'.$row['tag'].'"/><br />';
	} else {
		echo '
		<form name="new" id="new" method="post" action="twork.php?wt=editpost&post='.$_GET['post'].'">
			<div id="prv"></div>
		<table border="0" >
		<tr><td>Заголовок</td><td><input type="text" name="title" value="'.utext($row['title']).'" /></td></tr>
		<tr><td>Блог</td><td><select name="blog">
		<option value="own">Персональный</option>';

		$sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."'  ";
		$resul=mysql_query($sql_get,$sql);
		if (!$resul) {
			echo  mysql_error();
		}
		while ($rw = mysql_fetch_assoc($resul)) {
			if ($rw['blogid']==$row['blogid']) {$fin=' selected ';} else {$fin="";}

			echo "<option value='".$rw['blogid']."' $fin >".$rw['bname']."</option>";
		}

		echo '</select> </td></tr>
		<tr><td id="otxt">Текст</td><td><div id="mq" class="inpt"></div>
		<textarea  onkeypress="do_key(this.form,\'new\',event);" onkeydown="if(\'\v\'==\'v\') {do_key(this.form,\'new\',event);}" name="text" rows="15" cols="70">'.utext($zz).'</textarea>
		</td></tr>
		<tr><td>Тэги</td><td><input type="text" name="tag" style="width: 500px;" value="'.$row['tag'].'"/>
		</td></tr>';
		if  ($row['tp']==2) {
			echo "<tr><td>Оригинал</td><td><input type='text' name='lnk' value='".$row['lnk']."' /></td></tr>";
		} else if ($row['tp']==1) {
			echo "<tr><td>Ссылка</td><td><input type='text' name='lnk' value='".$row['lnk']."' /></td></tr>";
		}
		echo '</table> '; }
		echo '<input type="checkbox" name="lock" '.$h.' /> Только для друзей/собложников<br />
		<input type="submit" value="Запостить!" />	
		</form>';
} else {
	echo "<h3>Это не ваш пост!</h3>";
}
?>
<script>mk('mq','new');
document.getElementById("otxt").innerHTML+="<br /><a href='javascript:prv()'>Предпросмотр</a>";
		document.getElementById("mq").innerHTML+="<a class='tdx' href='javascript:insert(\"[cut]\",\"\",\"new\",\"text\")'>cut</a>"+
		"<a class='tdx' href='javascript:insert(\"[fcut]\",\"\",\"new\",\"text\")'>fcut</a>";
		</script>
