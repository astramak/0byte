<?php
if ($type=='user') {
    ?><h3>Причина блокировки пользователя</h3>
    <form action="<?php echo $url; ?>" method="post">
        <label> <textarea name="cause"></textarea></label><br />
        <label>Срок (секунд)<input type="text" name="end" /> </label>
        <label> <input type="submit" value="Блокировать" /></label>
       <?php if (@$js) { ?> <input type="button" value="Отмена" onClick="a_cr()" /> <?php } ?>
    </form><?php
}
?>
