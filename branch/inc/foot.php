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
$tpl->display("def.tpl");
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
<div class='usln'>
<div class='usrd'>Идея сайта <a href="http://welinux.ru/user/exelens">exelens</a>;
Движок 0byte, разработчик <a href="http://welinux.ru/user/nvbn">nvbn</a>;
Дизайн - <a href="http://astramak.jino.ru/">Astramak</a></div>
</div>
</div>
<script type="text/javascript">document.write("<a href='http://www.liveinternet.ru/click' target=_blank><img src='http://counter.yadro.ru/hit?t14.6;r" + escape(document.referrer) + ((typeof(screen)=="undefined")?"":";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?screen.colorDepth:screen.pixelDepth)) + ";u" + escape(document.URL) +";i" + escape("x"+document.title.substring(0,80)) + ";" + Math.random() +
"' border=0 width=88 height=31 alt='' title='LiveInternet: LiveInternet: показано число просмотров и"+" посетителей за 24 часа'><\/a>")</script>
<a href="http://feeds.feedburner.com/welinux"><img
	src="http://feeds.feedburner.com/~fc/welinux?bg=6699CC&amp;fg=FFFFFF&amp;anim=0"
	height="26" width="88" style="border: 0" alt="" /></a>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-994542-6");
pageTracker._trackPageview();
} catch(err) {}</script>
</body>
</html>
