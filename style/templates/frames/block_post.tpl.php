<h2>Блокировка поста</h2>
<form method="POST" action="twork.php?wt=bpost&id=<?php echo $id; ?>">
    <label><input type="checkbox" name="comment" <?php if ($comment) { ?>checked<?php } ?> />Запрет комментировать</label><br />
    <label><input type="checkbox" name="rate" <?php if ($rate) { ?>checked<?php } ?> />Запрет голосования</label><br />
    <label><input type="checkbox" name="block" <?php if ($block) { ?>checked<?php } ?> />Полная блокировка</label><br />
    <input type="submit" value="Изменить" /><?php if (@$json) {?><input type="button" onclick="a_cr()" value="Отмена"/><?php } ?>
</form>