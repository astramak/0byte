<?php
//if (!isset($_GET['js'])) {
////	echo '<h3>Комментарий к:</h3>';
//
//} else {
//
//}
$sql_get = "SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row = mysql_fetch_assoc($result);
$lvl=$row['lvl']+1;
if (!isset($_GET['js'])) {
	$old=com_echo(new comment($row),1);
//	echo '<br />';

    }
	else {
        	echo "{";
		echo '"text" : "';
	}
    echo render_new_comment($old, $lvl, request::get_get("cur"), request::get_get("id"));
//<div id="mq" class="inpt"></div>
//<form method='post'
//	action='twork.php?wt=newcom&lvl=<?php echo($lvl."&id=".$_GET['id']."&from=".$_GET['cur']); ?\>'>
//<textarea name='text' rows='10' cols='80'></textarea><br />
//<input type='submit' value='Отправить' /></form>
//<script type="text/javascript"> mk('mq','new'); </script>

	if (isset($_GET['js'])) {
		echo '"
	"id" : "'.$_GET['id'].'"
}';
	}
	?>