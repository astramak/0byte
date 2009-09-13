<span class="title">Создание <?php echo $type; ?></span><br>
<?php if (!@$post) { ?><a href="work/newpost">Сообщение</a> <?php } if (!@$translate) { if (!@$post) { ?> |<?php } ?> <a href="work/newpost/tr">Перевод</a> <?php } if (!@$link) { ?>| <a href="work/newpost/lnk">Ссылка</a> <?php } if (!@$answer) { ?>| <a href="work/newpost/answ">Опрос</a><?php } ?><br>
<form name="new" id='new' method="post"
	action="twork.php?wt=newpost&tp=<?php echo $tp; ?>">
<div id='prv'></div><br><br>
<nobr>
		<select name="blog">
		<?php foreach ($blogs as $blog) { ?>
        <option value="<?php echo $blog['value'];?>"><?php echo $blog['text']; ?></option>
        <?php } ?>
        </select> <input type="text" name="title" class="post-title" tabindex="1"/>
</nobr>



    <?php if(@!$answer) {?>

		<div id='mq' class='inpt'></div>
		<textarea onkeypress='do_key(this.form,"new",event);' onkeydown='if("\v"=="v") {do_key(this.form,"new",event);}' name='text' rows='15' cols='70' class='post-body' tabindex="2"></textarea>

        <?php } else {?>

<br><br>Варианты можно <a id='adda' href='work/newpost/answ/<?php echo($len+1); ?>'>добавлять</a> и <a id='rma'  href='work/newpost/answ/<?php echo($len-1); ?>'>удалять</a><br><br>

			<div id='nw'>
            <?php for ($x=1;$x<=$len;$x++) {?>
                <label id='an<?php echo $x; ?>'><input type='text' id='fst'  name='an<?php echo $x; ?>' /><br /></label>
            <?php } ?>
        <input type='hidden' id='len' name='len' value='<?php echo $len ?>' /></div>
	<br>
	<input type='checkbox' name='mng' id="mng" /><label for="mng">Разрешить выбирать несколько вариантов</label>
	<br>
        <?php }
    if (@$translate) { ?>
        <input type='text' name='org' class="post-tags" tabindex="3" /><span class="grey"> - <b>оригинал</b></span><br/>
    <?php } else if (@$link) {?>
<input type='text' name='lnk' class="post-tags" tabindex="3"/><span class="grey" > - <b>ссылка</b></span><br/>
    <?php } ?>



<input type="text" name="tag" class="post-tags" tabindex="4" /><span class="grey"> - теги</span><br/><br/>

<input type="checkbox" name="lock" id="lock" tabindex="5"/> <label for="lock">Показать только друзьям и участникам блога</label><br/><br/>
<input type="submit" class="tag_w6" value="Опубликовать" tabindex="6" />
 
  
<button type="submit" name="draft" tabindex="7">
<img src="/style/n_img/draft.png" style="vertical-align: middle"> Сохранить
</button>
<!-- nvbn, разбери эту какашку, я не помню как верно, если честно =)) -->

<input style="display:none;" id="view" onClick="javascript:prv()" type="button" value="Предпросмотр" tabindex="8"/></form>