<h3>Изображение</h3>
<form onsubmit="imga(this,'<?php echo $fr; ?>','<?php echo $el; ?>'); return false;"><label>Адрес <input type='text' name='url' /></label>
    <label>Текст <input type='text' name='alt' /></label>
    <input type='submit' value='Создать' /><input type='button' onClick='a_cr()' value='Отмена' /></form>