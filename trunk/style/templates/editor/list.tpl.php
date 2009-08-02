<h3>Список</h3><form id='list' onsubmit="li_a(this,'<?php echo $fr; ?>','<?php echo $el; ?>'); return false;">
    <label><input type='radio' value='ul' name='lst' onClick="sli='ul';" checked />Ненумерованный</label>
    <label><input type='radio' value='ol' name='lst' onClick="sli='ol';" />Нумерованный</label><br />
    <input type='hidden' name='nm' value='1' />
    <label id='n1'><input type='text' id='na1' /><br /></label>
    <input type='button' id='ad' onClick='nadd(this.form)' value='Добавить' />
    <input type='button' id='rm' onClick='nrm(this.form)' value='Удалить' />
    <input type='submit' value='Создать' />
    <input type='button' onClick='a_cr()' value='Отмена' /></form>