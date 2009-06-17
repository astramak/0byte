<h3>Создание <?php
    $tp=request::get_get("tp",0,0);
//if ($tp==0)
if (strncmp($tp,'lnk',3)==0) {
	echo "поста-ссылки";
	$tp=1;
} else if (strncmp($tp,'tr',2)==0) {
	echo "перевода";
	$tp=2;
} else if (strncmp($tp,'answ',4)==0) {
	echo "опроса";
	$tp=3;
}  else {
	echo "сообщения";
	$tp=0;
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
<table border="0" class="fullwidth">
	<tr>
		<td>Заголовок</td>
		<td><input type="text" name="title" class="post-title" /></td>
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
	<?php if ($tp<=2) {
		echo "<tr><td id='otxt'>Текст</td><td>
		<div id='mq' class='inpt'></div>
		<textarea onkeypress='do_key(this.form,\"new\",event);' onkeydown='if(\"\v\"==\"v\") {do_key(this.form,\"new\",event);}' name='text' rows='15' cols='70' class='post-body'></textarea>
		
		</td></tr>";
	}  else {
        if (request::get_get("len",0)>2) {
			$len=request::get_get("len",0);
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
	if  ($tp==2) {
		echo "<tr><td>Оригинал</td><td><input type='text' name='org' /></td></tr>";
	} else if ($tp==3) {
		echo "<tr><td>Ссылка</td><td><input type='text' name='lnk' /></td></tr>";
	}
	?>
	<tr>
		<td>Тэги</td>
		<td><input type="text" name="tag" class="post-tags" /></td>
	</tr>
</table>
<input type="checkbox" name="lock" /> Только для друзей/собложников<br />
<input type="submit" value="Запостить!" /></form>
<script type="text/javascript">mk('mq','new');
		document.getElementById("otxt").innerHTML+="<br /><a href='javascript:prv()'>Предпросмотр</a>";
		document.getElementById("mq").innerHTML+="<a class='tdx' href='javascript:insert(\"[cut]\",\"\",\"new\",\"text\")'>cut</a>"+
		"<a class='tdx' href='javascript:insert(\"[fcut]\",\"\",\"new\",\"text\")'>fcut</a>";
		</script>
