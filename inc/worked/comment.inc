<?php
if (!isset($_GET['js'])) {
	echo '<h3>Комментарий к:</h3>';

} else {
	echo "{";
}
$sql_get = "SELECT * FROM `comment` WHERE id = '".gint($_GET['id'])."'";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row = mysql_fetch_assoc($result);
$lvl=$row['lvl']+1;
if (!isset($_GET['js'])) {
	$cm=new com;
	$cm->make($row);
	com_echo($cm);
	echo '<br />'; }
	else {
		echo '"text" : "';
	}
	?>
<div id="mq" class="inpt"></div>
<form method='post'
	action='twork.php?wt=newcom&lvl=<?php echo($lvl."&id=".$_GET['id']."&from=".$_GET['cur']); ?>'>
<textarea name='text' rows='10' cols='80'></textarea><br />
<input type='submit' value='Отправить' /></form>
<script type="text/javascript"> mk('mq','new'); </script>
	<?php
	if (isset($_GET['js'])) {
		echo '"
	"id" : "'.$_GET['id'].'"
}';
	}
	?>