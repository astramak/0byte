<h3>Создание <?php echo $type; ?></h3>
<?php if (!@$post) { ?><a href="work/newpost">Сообщение</a> <?php } if (!@$translate) { if (!@$post) { ?> |<?php } ?> <a href="work/newpost/tr">Перевод</a> <?php } if (!@$link) { ?>| <a href="work/newpost/lnk">Ссылка</a> <?php } if (!@$answer) { ?>| <a href="work/newpost/answ">Опрос</a><?php } ?><br>
<form name="new" id='new' method="post"
	action="twork.php?wt=newpost&tp=<?php echo $tp; ?>">
<div id='prv'></div><br><br>
<table border="0" class="fullwidth">
	<tr>
		<select name="blog">
		<?php foreach ($blogs as $blog) { ?>
        <option value="<?php echo $blog['value'];?>"><?php echo $blog['text']; ?></option>
        <?php } ?>
    </select> — <input type="text" name="title" class="post-title" />
	
	<tr>
		<td>
    <?php if(@!$answer) {?>
    <tr><td id='otxt'>Текст</td><td>
		<div id='mq' class='inpt'></div>
		<textarea onkeypress='do_key(this.form,"new",event);' onkeydown='if("\v"=="v") {do_key(this.form,"new",event);}' name='text' rows='15' cols='70' class='post-body'></textarea>
		</td></tr>
        <?php } else {?>
<tr><td>Ответы:
			<br /> <a id='adda' href='work/newpost/answ/<?php echo($len+1); ?>'>Добавить</a>
			<br /> <a id='rma'  href='work/newpost/answ/<?php echo($len-1); ?>'>Убрать</a>
			</td><td id='nw'>
            <?php for ($x=1;$x<=$len;$x++) {?>
                <label id='an<?php echo $x; ?>'><input type='text' id='fst'  name='an<?php echo $x; ?>' /><br /></label>
            <?php } ?>
        <input type='hidden' id='len' name='len' value='<?php echo $len ?>' /></td></tr>
			<tr><td>Несколько ответов</td><td><input type='checkbox' name='mng'  /></td></tr>
        <?php }
    if (@$translate) { ?>
        <tr><td>Оригинал</td><td><input type='text' name='org' /></td></tr>
    <?php } else if (@$link) {?>
<tr><td>Ссылка</td><td><input type='text' name='lnk' /></td></tr>
    <?php } ?>
<tr>
		<td>Тэги</td>
		<td><input type="text" name="tag" class="post-tags" /></td>
	</tr>
</table>
<input type="checkbox" name="lock" /> Только для друзей / участников блога<br />
<input type="submit" class="tag_w6" value="Опубликовать" />
<input type="submit" value="Сохранить" name="draft" /><input style="display:none;" id="view" onClick="javascript:prv()" type="button" value="Предпросмотр" /></form>