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
?>
</td>
<td id="tb5"><?php include("inc/right.php"); ?></td>
</tr>
</tbody>
</table>
<script type="text/javascript">
<?php
$cur=$_SERVER['REQUEST_URI'];
	$cur=str_replace("&","*amp",$cur);
	$cur=str_replace("?","*qw",$cur);
	echo "var cur = '$cur';";
echo "var loged=".$loged.";";
?>
strt();
</script>
<div class='mf' id='btmf'>
<div class='amenuel'><a href="<?php echo $site; ?>"><?php echo $sl_name; ?></a></div>
<div class='menuel'><a href="all/ar">Правила.</a> <a href="all/act">Цели
и задачи.</a> <a href="all/help">Справка.</a></div>
</div>
</div>
</body>
</html>
