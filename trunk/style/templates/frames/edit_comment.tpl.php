<h3>Редактирование комментария</h3>
<div id="mq" class="inpt"></div>
<form method='post' name='new'
	action='twork.php?wt=editcom&id=<?php echo($id); ?>'><textarea
	onkeypress="do_key(this.form,'new',event);"
	onkeydown="if('\v'=='v') {do_key(this.form,'new',event);}" name='text'
	rows='10' cols='80'><?php echo $text; ?></textarea><br />
<input type='submit' value='Редактировать' /></form>
<script type="text/javascript"> mk('mq','new'); </script>
