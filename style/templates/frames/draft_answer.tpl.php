<h3>Черновик</h3>
<form id="new" name="new" method="post" action="<?php echo $url;?>">
    <input type='hidden' name='draft' value='1' />
    <table border="0" class="fullwidth">
        <tr>
            <td>Заголовок</td>
            <td><input type="text" name="title" class="post-title" value="<?php echo $title; ?>"/></td>
        </tr>
        <tr>
            <td>Блог</td>
            <td><select name="blog">
                    <?php foreach ($blogs as $blog) { ?>
                    <option value="<?php echo $blog['value'];?>" <?php echo $blog['active'];?>><?php echo $blog['text']; ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr><td>Ответы:
			<br /> <a id='adda' href='work/newpost/answ/<?php echo($len+1); ?>'>Добавить</a>
			<br /> <a id='rma'  href='work/newpost/answ/<?php echo($len-1); ?>'>Убрать</a>
			</td><td id='nw'>
            <?php for ($x=0;$x<$len-1;$x++) {?>
                            <label id='an<?php echo $x; ?>'><input type='text' id='fst'  name='an<?php echo $x+1; ?>' value="<?php echo base64_decode($answers[$x]); ?>" /><br /></label>
            <?php } ?>
        <input type='hidden' id='len' name='len' value='<?php echo $len-1; ?>' /></td></tr>
	<tr><td>Несколько ответов</td><td><input type='checkbox' name='mng' <?php echo $mng; ?>  /></td></tr>
        <tr><td>Только для друзей/собложников</td><td><input type="checkbox" name="lock" <?php echo $status; ?> /></td></tr>
        <tr><td>Тэги</td><td><input type="text" name="tag" class="post-tags" value="<?php echo $tag; ?>"/></td></tr>
        <tr><td><input type="submit" value="Запостить!" name='write' />
        <input type="submit" value="Сохранить!" name="draft"  /></td></tr>
    </table>
</form>
