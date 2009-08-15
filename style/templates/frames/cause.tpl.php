<?php
if ($type=='user') {
    ?><h3>Причина блокировки пользователя</h3>
    <form action="<?php echo $url; ?>" method="post">
        <table><tr><td>Причина</td><td>
        <textarea cols="30" name="cause"></textarea></td></tr>
        <tr><td>Дней</td><td><input type="text" name="day" value="0"/> </td></tr>
        <tr><td>Часов</td><td><input type="text" name="hour" value="0"/></td></tr>
        <tr><td>Минут</td><input type="text" name="minut" value="0"/></td></tr></table>
        <input type="submit" value="Блокировать" /> <input type="submit" name="end" value="Блокировать на всегда" /></label>
       <?php if (@$js) { ?> <input type="button" value="Отмена" onClick="a_cr()" /> <?php } ?>
    </form><?php
}
?>
