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
?><div rel="noindex" class='rtblb'>
<table class="rtbl">
	<tbody>
		<tr id='af' class='sd'>
			<td class='lsd'>
			<ul id='alist'>
			<?php
			$sql_get="SELECT * FROM `post` WHERE `blck`='0' ORDER BY  id DESC LIMIT 16";
			$result=mysql_query($sql_get,$sql);
			if (!$result) {
				echo  mysql_error();
			}
			$e=0;
			while ($row = mysql_fetch_assoc($result)) {
				$tarr[$e]=$row;
				$tarr[$e]['type']=0;
				$e++;
			}
			$sql_get="SELECT *,`post`.`id` as `pid`,`post`.`date` as `pate` FROM `post`,`comment` WHERE `post`.`id`=`comment`.`krnl` && `post`.`blck`='0' ORDER BY  `comment`.`id` DESC LIMIT 16";
			$result=mysql_query($sql_get,$sql);
			while ($row = mysql_fetch_assoc($result)) {
				$tarr[$e]=$row;
				$tarr[$e]['type']=1;
				$e++;
			}
			$siz = count($tarr)-1;
			for ($i = $siz; $i>=0; $i--) {
				for ($j = 0; $j<=($i-1); $j++)
				if ($tarr[$j]['date']>$tarr[$j+1]['date']) {
					$k = $tarr[$j];
					$tarr[$j] = $tarr[$j+1];
					$tarr[$j+1] = $k;
				}
			}
			for ($i=($e-1); $i>=16;$i--) {
				if ($tarr[$i]['type']==0) {
					if ($tarr[$i]['blog']=="own") {
						$fs="<a href='user/".$tarr[$i]['auth']."/'>".$tarr[$i]['auth']."</a>";
					} else {
						$fs="<a href='user/".$tarr[$i]['auth']."/'>".$tarr[$i]['auth']."</a>";
					}
					$rate=$tarr[$i]['ratep']-$tarr[$i]['ratem'];
					$rt="";
					if ($rate>0) {$rt="<span class='scb'>(<span class='rp'>".$rate."</span>)</span>";}
					else if ($rate<0) {$rt="<span class='scb'>(<span class='rm'>".$rate."</span>)</span>";}
					echo "<li class='pelis'>".$fs." &#8212; &laquo;<a href='post/".$tarr[$i]['id']."/'>".$tarr[$i]['title']."</a>&raquo; ".$rt."</li>";
				} else {
					$rate=$tarr[$i]['ratep']-$tarr[$i]['ratem'];
					$rt="";
					if ($tarr[$i]['blog']=="own") {
						$fs=$tarr[$i]['auth'];
					} else {
						$fs=$tarr[$i]['blog'];
					}
					if ($rate>0) {$rt="<span class='scb'>(<span class='rp'>".$rate."</span>)</span>";}
					else if ($rate<0) {$rt="<span class='scb'>(<span class='rm'>".$rate."</span>)</span>";}
					echo "<li class='celis'><a href='user/".$tarr[$i]['who']."/'>".$tarr[$i]['who']."</a> &#8212; &laquo;<a href='post/".$tarr[$i]['pid']."/#cmnt".$tarr[$i]['id']."'>".$fs." / ".$tarr[$i]['title']."</a>&raquo; ".$rt."</li>";
				}
			}
			?>
			</ul>
			</td>

			<td class='rsdno' id='ped'><a class="bbls"
				href='javascript:g_plist("post")'><img src="style/img/document.gif"
				alt="Посты" /></a> <a class="bbls" href='javascript:g_plist("com")'><img
				src="style/img/speech_bubble.gif" alt="Комментарии" /></a> <?php if ($loged) {echo '<a class="bbls" href='."'javascript:g_plist".'("eye")'."'><img src=".'"style/n_img/eye.gif" alt="Изменения" /></a>'; } ?>
			</td>
		</tr>
		<tr id='pf' class='sd'>
			<td class='lsd'><span class='ttl'>Последние посты</span>
			<ul id='plist'>
			</ul>
			</td>
			<td class='rsdno'><a class="bbls"
				style="background: #B6B6B6;" href='javascript:hplist()'><img
				src="style/img/document.gif" alt="Посты" /></a> <a class="bbls"
				href='javascript:g_plist("com")'><img
				src="style/img/speech_bubble.gif" alt="Комментарии" /></a> <?php if ($loged) {echo '<a class="bbls" href='."'javascript:g_plist".'("eye")'."'><img src=".'"style/n_img/eye.gif" alt="Изменения" /></a>'; } ?>
			</td>
		</tr>
		<tr id='cf' class='sd'>
			<td class='lsd'><span class='ttl'>Последние комментарии</span>
			<ul id='clist'>
			</ul>
			</td>
			<td class='rsdno'><a class="bbls"
				href='javascript:g_plist("post")'><img src="style/img/document.gif"
				alt="Посты" /></a> <a class="bbls" style="background: #B6B6B6;"
				href='javascript:hplist()'><img src="style/img/speech_bubble.gif"
				alt="Комментарии" /></a> <?php if ($loged) {echo '<a class="bbls" href='."'javascript:g_plist".'("eye")'."'><img src=".'"style/n_img/eye.gif" alt="Изменения" /></a>'; } ?>
			</td>
		</tr>

		<tr id='ef' class='sd'>
			<td class='lsd'><span class='ttl'>Изменения</span>
			<ul id='eblist'>
			</ul>
			</td>
			<td class='rsdno'><a class="bbls"
				href='javascript:g_plist("post")'><img src="style/img/document.gif"
				alt="Посты" /></a> <a class="bbls" href='javascript:g_plist("com")'><img
				src="style/img/speech_bubble.gif" alt="Комментарии" /></a> <a
				class="bbls" style="background: #B6B6B6;" href='javascript:hplist()'><img
				src="style/n_img/eye.gif" alt="Изменения" /></a></td>
		</tr>

	</tbody>
</table>
</div>
			<?php echo '<form id="fuck" method="get" action="'.$site.'">';?>
<div class='rtblb'>
<table class="rtbl">
	<tr class='sd'>
		<td class='lsd'><input id="fnd" type="text" name="fnd" /></td>
		<td class='rsd'><input type='image' src="style/img/mag_glass.gif" /></td>
	</tr>
</table>
</div>
</form>


			<?php
			echo "<script type='text/javascript'>
var pd=document.getElementById('ped').innerHTML;
var cd=document.getElementById('ced').innerHTML;
</script>" ;
			ob_start();
			if (!$tops = readCache('tops.cache', 30)) {
				echo "<div class='rtblb'><div id='tags'>";
				$sql_get="SELECT * FROM `tags` WHERE num > 0 ORDER BY  num DESC LIMIT 40";
				$result=mysql_query($sql_get,$sql);
				if (!$result) {
					echo  mysql_error();
				}
				$id=mysql_num_rows($result);
				$g=1;
				for ($i=1;$i<=$id;$i++) {
					$size[$i]=28/$g;
					$g=$g+0.1;
				}
				$i=1;
				$num=-5;
				while ($row = mysql_fetch_assoc($result)) {
					if ($num==$row['num']) {
						$size[$i]=$size[$i-1];
					}
					$num=$row['num'];
					$rws[$i]=$row;
					$rws[$i]['size']=$size[$i];
					$i++;
				}
				for ($i=1;$i<=$id;$i++) {
					for ($q=$i;$q<=$id;$q++) {
						if ($rws[$q]['name']<$rws[$i]['name']) {
							$fl=$rws[$q];
							$rws[$q]=$rws[$i];
							$rws[$i]=$fl;
						}
					}
				}
				for ($i=1;$i<=$id;$i++) {
					echo "<a style='font-size: ".$rws[$i]['size']."px;' href='tag/".$rws[$i]['name']."' rel='tag'>".$rws[$i]['name']."</a>  ";
				}


				echo "</div></div>";

				echo "<div class='rtblb'><table  class='rtbl'><tbody>
<tr id ='bltop' class='sd'>
<td class='lsd'>
<span class='ttl'>Top блогов (<a href='list/blog/'>все</a>)</span>
<ul id='blist'>";
				$sql_get=" SELECT * FROM `blogs` ORDER BY ratep - ratem DESC LIMIT 10 ";
				$result=mysql_query($sql_get,$sql);
				if (!$result) {
					echo  mysql_error();
				}
				while ($row = mysql_fetch_assoc($result)) {
					$rate=$row['ratep']-$row['ratem'];
					$rt="";
					$sql_get=" SELECT * FROM `post` WHERE blogid = ".$row['id']." && blck = 0";
					$res=mysql_query($sql_get,$sql);
					$count=mysql_num_rows($res);
					if ($count>0) {
						if ($rate>0) {$rt="<span class='scb'>(<span class='rp'>".$rate."</span>)</span>";}
						else if ($rate<0) {$rt="<span class='scb'>(<span class='rm'>".$rate."</span>)</span>";}
						echo "<li><a href='blog/".$row['id']."'>".$row['name']."</a> ".$rt."</li>";
					}
				}
				echo "</ul>
</td><td class='rsdno'>

<div id='shall'><a class='bbls'  href='javascript:g_plist(\"top_user\")'><img src='style/img/figure.gif' alt='Топ пользователей' /></a>
<a class='bbls' href='javascript:g_plist(\"top_blog\")'><img src='style/img/documents.gif' alt='Топ блогов' /></a></div>
<div id='shblog'><a class='bbls'  href='javascript:g_plist(\"top_user\")'><img src='style/img/figure.gif' alt='Топ пользователей' /></a>
<a class='bbls' style='background:#B6B6B6;' href='javascript:hgptop()'><img src='style/img/documents.gif' alt='Топ блогов' /></a></div>


</td></tr>
<tr id ='ustop' class='sd'>
<td class='lsd'>
<span class='ttl'>Top пользователей (<a href='list/user/'>все</a>)</span>
<ul class='ulist' id='ulister'>";
				$sql_get=" SELECT * FROM `users` WHERE `lvl`='0' ORDER BY (ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r) DESC LIMIT 10 ";
				$result=mysql_query($sql_get,$sql);
				if (!$result) {
					echo  mysql_error();
				}
				$alien=new user;
				while ($row = mysql_fetch_assoc($result)) {
					$rt="";
					$rate=$row['ratep']-$row['ratem']+$row['prate']/$post_r+$row['crate']/$com_r+$row['brate']/$blog_r;
					if ($rate>0) {$rt="<span class='scb'>(<span class='rp'>".$rate."</span>)</span>";}
					else if ($rate<0) {$rt="<span class='scb'>(<span class='rm'>".$rate."</span>)</span>";}
					echo "<li><a href='user/".$row['name']."'>".$row['name']."</a> ".$rt."</li>";
				}
				$tops = ob_get_contents();
				writeCache($tops,'tops.cache');
			}
			ob_end_clean();
			echo $tops;
			echo "</ul></td><td class='rsdno'>

<div id='shuser'><a style='background:#B6B6B6;' class='bbls'  href='javascript:hgptop()'><img src='style/img/figure.gif' alt='Топ пользователей' /></a>
<a class='bbls' href='javascript:g_plist(\"top_blog\")'><img src='style/img/documents.gif' alt='Топ блогов' /></a></div>

</td></tr></tbody></table></div><div class='rtblb'><div class='tagsa'>";
			$sql_get="SELECT * FROM `users` WHERE `online` >= '".(time()-300)."'  ORDER BY `online` DESC";
			$result=mysql_query($sql_get,$sql);
			$onl=mysql_num_rows($result);
			if ($onl>1 || ($onl>0 && $loged!=1)) {
				echo "В сети: ";
				$sql_get="SELECT * FROM `users` WHERE `online` >= '".(time()-300)."'  ORDER BY `online` DESC LIMIT 20";
				$result=mysql_query($sql_get,$sql);
				$fst=1;
				while ($row = mysql_fetch_assoc($result)) {
					if ($fst!=1) {echo ", ";} else {$fst=0;}
					echo "<a href='user/".$row['name']."'>".$row['name']."</a>";
				}
				echo "<br /><br />";
			}
			echo "Новенькие: ";
			$sql_get="SELECT * FROM `users` ORDER BY  id DESC LIMIT 5";
			$result=mysql_query($sql_get,$sql);
			$fst=1;
			while ($row = mysql_fetch_assoc($result)) {
				if ($fst!=1) {echo ", ";} else {$fst=0;}
				echo "<a href='user/".$row['name']."'>".$row['name']."</a>";
			}

			echo "</div></div>";
			?>
<script type="text/javascript">var ulist=document.getElementById("ulister").innerHTML;
var blist=document.getElementById("blist").innerHTML;
<?php 
$e=0;
if (isset($_SESSION['tp1'])) {
	if ($_SESSION['tp1']=='pst') {
		echo "g_plist('post'";
		$e=1;
	} else if ($_SESSION['tp1']=='com') {
		echo "g_plist('com'";
		$e=1;
	} else if ($_SESSION['tp1']=='eye') {
		echo "g_plist('eye'";
		$e=1;
	}
	
}
if (isset($_SESSION['tp2'])) {
	if ($_SESSION['tp2']=='us') {
		if ($e==1) {
			echo ",1,'top_user');";
			$e=2;
		} else {
			echo "g_plist('top_user');";
		}
	} else if ($_SESSION['tp2']=='bl') {
		if ($e==1) {
			echo ",1,'top_blog');";
			$e=2;
		} else {
			echo "g_plist('top_blog');";
		}
	}
}
if ($e==1) {echo ");";}
?>
</script>
