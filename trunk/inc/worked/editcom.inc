<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License.
 *
 *  0byte is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  See <http://www.gnu.org/licenses/>.
 *
 */
//<h3>Редактирование комментария</h3>

$sql_get = "SELECT * FROM `comment` WHERE id = '".intval($_GET['id'])."'";
$result=mysql_query($sql_get,$sql);
if (!$result) {
	echo  mysql_error();
}
$row = mysql_fetch_assoc($result);
$lvl=$row['lvl']+1;

$cm=new comment($row);
echo render_edit_comment($id,utext($cm->text));

//<div id="mq" class="inpt"></div>
//<form method='post' name='new'
//	action='twork.php?wt=editcom&id=<?php echo($_GET['id']); ?\>'><textarea
//	onkeypress="do_key(this.form,'new',event);"
//	onkeydown="if('\v'=='v') {do_key(this.form,'new',event);}" name='text'
//	rows='10' cols='80'><?php echo utext($cm->text); ?\></textarea><br />
//<input type='submit' value='Редактировать' /></form>
//<script type="text/javascript"> mk('mq','new'); </script>
?>
