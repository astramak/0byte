<h2>Написание личного соообщения</h2>
<form name='pm' id='pm' method="post" action="twork.php?wt=pmnew">
<table>
	<tr>
		<td>Кому</td>
		<td><input type="text" name="to"
			value="<?php echo @$name; ?>" /></td>
	</tr>

	<tr>
		<td>Заголовок</td>
		<td><input type="text" name="title" /></td>
	</tr>
	<tr>
		<td>Текст</td>
		<td>
		<div id="rd" class='inpt'></div>
		<textarea onkeypress="do_key(this.form,'pm',event);"
			onkeydown="if('\v'=='v') {do_key(this.form,'pm',event);}" name="text"
			rows="15" cols="70"></textarea></td>
	</tr>
</table>
<input type="submit" value="Отправить!" /></form>