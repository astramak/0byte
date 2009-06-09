<h3>Редактирование комментария</h3>
<?php
$sql_get = "SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row = mysql_fetch_assoc($result);
$lvl=$row['lvl']+1;

$cm=new com;
$cm->make($row);

?>
<div id="mq" class="inpt"></div>
<form method='post' name='new'
	action='twork.php?wt=editcom&id=<?php echo($_GET['id']); ?>'><textarea
	onkeypress="do_key(this.form,'new',event);"
	onkeydown="if('\v'=='v') {do_key(this.form,'new',event);}" name='text'
	rows='10' cols='80'><?php echo utext($cm->text); ?></textarea><br />
<input type='submit' value='Редактировать' /></form>
<script type="text/javascript"> mk('mq','new'); </script>
