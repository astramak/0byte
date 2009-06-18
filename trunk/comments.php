<?php
include ("cfg.php");
include ("inc/head.php");
include("inc/top.php");
?>

<div id="main">
	<?php
	$who = request::get_get('who');
	if (!$who) {
		echo "<h2>Пользователь с таким именем не найден!</h2>";
	} else {
		$alien=new user;
		$alien->find($who);
		$ssa = "<img class='cnoauth' src='style/img/figure.gif' />";
		if (strlen($alien->av)>2) {
			$big_img="<img src='res.php?t=av&img=".$alien->av."' style='float:left;' alt='".$alien->login."' />";
			$ssa = "<img class='cauth' src='res.php?t=av&img=".$alien->av."' style='float:left;' alt='".$alien->login."' />";
		}
		if ($alien->rate()>0) {
			$rtp="<span class='rp'>".$alien->rate()."</span>";
		} elseif ($alien->rate()<0) {
			$rtp="<span class='rm'>".$alien->rate()."</span>";
		}  else {
			$rtp=$alien->rate();
		}
		echo "<div id='btop'>".$big_img."<span class='bnm'><a href='user/".$alien->login."'>".$alien->login."</a></span><span class='rate'>
			".$in."     <a class='ratep' href='twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur."'>+</a>
                ".$rtp."<a class='ratem' href='twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur."'>&ndash;</a></span></div>";

		$result = db_query('SELECT * FROM comment WHERE who = %s ORDER BY id DESC', $who);
		if (!db_num_rows($result)) {
			echo "<span id='nocom'>Коментариев нет</span>";
		} else {
			$com=new com();
			while($row = db_fetch_assoc($result)) {
				$com->make($row);

				$post = db_fetch_assoc(db_query('SELECT * FROM post WHERE id = %d', $row['krnl']));
				if ($post['blogid']) {
					$us="<a href='blog/".$post['blogid']."'>".$post['blog']."</a>  &#8212;  ";
				} else {
					$us="<a href='auth/".$post['auth']."'>".$post['auth']."</a>  &#8212;  ";
				}
				$date = date('d.m.y H:i',$com->date);
				$text = code($com->text);
				if ($com->rate() > 0) {
					$rate="<span class='rp'>".$com->rate()."</span>";
				} elseif ($com->rate() < 0) {
					$rate="<span class='rm'>".$com->rate()."</span>";
				}  else {
					$rate=$com->rate();
				}
				echo "
<div class='ctop'>".$ssa."
	<span class='date'>".$date."</span>
	<span class='cauth'>&nbsp;".$us."<a href='post/".$post['id']."#cmnt".$row['id']."'>".$post['title']."</a></span>
	<span class='crate rateonly'>".$rate."</span>
</div>
<div class='ctext'>".$text."</div>
";
			}
		}
	}
	?>
</div>

<?php
include("inc/foot.php");
?>