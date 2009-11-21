<h2>Удалить себя</h2>
<form action="twork.php?wt=delete_user" method="post">
    <label><input type="radio" name="type" value="light"/>Удалите меня</label><br />
    <label title="Yeah, I really love BDSM!!!!!!11"><input type="radio" name="type" value="bdsm"/>Удалите меня и мой контент</label>
    <br /><img src="cap/kap.php?rand=<?php echo rand(); ?>" alt="Это капча. Не увидив её, вы потеряете многое!" title="Это капча. Не увидив её, вы потеряете многое!" onclick="this.src='cap/kap.php?rand='+Math.random()" /><input type="text" name="kap" onkeyup="chka(this,'cap')" />
    <br /><input type="submit" value="Я готов" /> <?php if (@$json) { ?> <input type="button" onclick="a_cr();" value="Отмена" /> <?php } ?>
</form>