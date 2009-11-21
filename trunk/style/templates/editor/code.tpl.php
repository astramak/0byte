<h3>Код</h3>
<form onsubmit="return false;"><label>Язык для подсветки:</label> <br />
    <input type='text' onkeyup="if (changer(this.value,event,'code')==1) {codea(this.form,'<?php echo $fr; ?>','<?php echo $el; ?>'); }" id="codelang" autocomplete="off" name='code' tabindex='1' /><div id="codearea"></div><br />
<input type='button' onclick="codea(this.form,'<?php echo $fr; ?>','<?php echo $el; ?>');"   value='Создать' /><input type='button' onClick='a_cr()' value='Отмена' /></form>