<h3><?php if ($draft) { ?>Черновик<?php } else { ?>Редактирование сообщения<?php } ?></h3>
<form id="new" name="new" method="post" action="<?php echo $url;?>">
<?php if (@$answer) { ?>
    <b>В опросах запрещено изменять вопрос и ответы, для редактирования доступны только теги и доступ!</b>
			<br />
<?php } ?>
<?php if (@!$answer) { ?>
	<div id="prv"></div>
		<table border="0" class="fullwidth">
		<tr><td>Заголовок</td><td><input type="text" name="title" class="post-title" value="<?php echo $title; ?>" /></td></tr>
		<tr><td>Блог</td><td>
<?php } ?>
<select name="blog">
		<?php foreach ($blogs as $blog) { ?>
        <option value="<?php echo $blog['value'];?>" <?php echo $blog['active'];?>><?php echo $blog['text']; ?></option>
        <?php } ?>
    </select>
<?php if (@!$answer) {?>
    </td></tr>
		<tr><td id="otxt">Текст</td><td><div id="mq" class="inpt"></div>
		<textarea class="post-body" onkeypress="do_key(this.form,'new',event);" onkeydown="if('\v'=='\v') {do_key(this.form,'new',event);}" name="text" rows="15" cols="70"><?php echo $text; ?></textarea>
		</td></tr>
        <tr><td>Тэги</td><td>
<?php } ?>
<input type="text" name="tag" class="post-tags" value="<?php echo $tags; ?>"/>
<?php if (@!$answer) { ?>
    </td></tr>
    <?php if (@$translate) { ?>
<tr><td>Оригинал</td><td><input type='text' name='lnk' value='<?php echo $lnk; ?>' /></td></tr>
    <?php }  else if (@$link) {?>
    <tr><td>Ссылка</td><td><input type='text' name='lnk' value='<?php echo $lnk; ?>' /></td></tr>
    <?php } ?>
</table>
<?php }
if ($draft) {
    ?><input type='hidden' name='draft' value='1' /><?php
}
?>
<input type="checkbox" name="lock" <?php echo $status; ?> /> Только для друзей/собложников<br />
		<input type="submit" value="Запостить!" <?php if ($draft) {?> name='write'<?php } ?> />
                <input type="submit" value="Сохранить<?php if (!$draft) {?> как черновик<?php } ?>!" <?php if (!$draft) {?> name='to_draft'<?php } ?>  />
		</form>