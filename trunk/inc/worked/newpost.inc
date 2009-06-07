<h3>Создание <?php if (!isset($_GET['tp'])) {
	echo "сообщения";
	$tp=0;
} else if ($_GET['tp']=='lnk') {
	echo "поста-ссылки";
	$tp=1;
} else if ($_GET['tp']=='tr') {
	echo "перевода";
	$tp=2;
} else if ($_GET['tp']=='answ') {
	echo "опроса";
	$tp=3;
}

?></h3>
<a href="work/newpost"> Сообщение </a>
|
<a href="work/newpost/tr"> Перевод </a>
|
<a href="work/newpost/lnk"> Сообщение-ссылка </a>
|
<a href="work/newpost/answ"> Опрос </a>
<form name="new" id='new' method="post"
	action="twork.php?wt=newpost&tp=<?php echo $tp; ?>">
<div id='prv'></div>
<table border="0">
	<tr>
		<td>Заголовок</td>
		<td><input type="text" name="title" /></td>
	</tr>
	<tr>
		<td>Блог</td>
		<td><select name="blog">
			<option value="own">Персональный</option>
			<?php
			$sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."'  ";
			$result=mysql_query($sql_get,$sql);
			if (!$result) {
				echo  mysql_error();
			}
			while ($row = mysql_fetch_assoc($result)) {
				echo "<option value='".$row['blogid']."'>".$row['bname']."</option>";
			}
			?>
		</select></td>
	</tr>
	<?php if (!isset($_GET['tp']) || $_GET['tp']=='tr' || $_GET['tp']=='lnk') {
		echo "<tr><td id='otxt'>Текст</td><td>
		<div id='mq' class='inpt'></div>
		<textarea onkeypress='do_key(this.form,\"new\",event);' onkeydown='if(\"\v\"==\"v\") {do_key(this.form,\"new\",event);}' name='text' rows='15' cols='70'></textarea>
		
		</td></tr>";
	}  else {
		if (isset($_GET['len']) && $_GET['len']>2) {
			$len=$_GET['len'];
		} else {$len=2;}
		echo "<tr><td>Ответы:
			<br /> <a id='adda' href='work/newpost/answ/".($len+1)."'>Добавить</a>
			<br /> <a id='rma'  href='work/newpost/answ/".($len-1)."'>Убрать</a>
			</td><td id='nw'>";
			
		for ($x=1;$x<=$len;$x++) {
			echo "<label id='an".$x."'><input type='text' id='fst'  name='an".$x."' /><br /></label>";
		}
		echo "<input type='hidden' id='len' name='len' value='".$len."' /></td></tr>
			<tr><td>Несколько ответов</td><td><input type='checkbox' name='mng'  /></td></tr>";
	}
	if  ($_GET['tp']=='tr') {
		echo "<tr><td>Оригинал</td><td><input type='text' name='org' /></td></tr>";
	} else if ($_GET['tp']=='lnk') {
		echo "<tr><td>Ссылка</td><td><input type='text' name='lnk' /></td></tr>";
	}
	?>
	<tr>
		<td>Тэги</td>
		<td><input type="text" name="tag" style="width: 500px;" /></td>
	</tr>
</table>
<input type="checkbox" name="lock" /> Только для друзей/собложников<br />
<input type="submit" value="Запостить!" /></form>
<script>mk('mq','new');
		document.getElementById("otxt").innerHTML+="<br /><a href='javascript:prv()'>Предпросмотр</a>";
		document.getElementById("mq").innerHTML+="<a class='tdx' href='javascript:insert(\"[cut]\",\"\",\"new\",\"text\")'>cut</a>"+
		"<a class='tdx' href='javascript:insert(\"[fcut]\",\"\",\"new\",\"text\")'>fcut</a>";
		</script>
