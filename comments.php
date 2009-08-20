<?php
include ("cfg.php");
include ("inc/head.php");
include("inc/top.php");

	$who = request::get_get('who');
	if (!$who) {
		
	} else {
		$alien=new user;
		$alien->find($who);
//		$ssa = "<img class='cnoauth' src='style/img/figure.gif' />";
//		$big_img = '';
$avatar=0;
$name=$alien->login;
$avatar_url=null;
$count=20;
		if (strlen($alien->av)> 2 ) {
                        $avatar=1;
                        $avatar_url="res.php?t=av&img=".$alien->av;
//                        $big_img = "<img src='res.php?t=av&img=".$alien->av."' style='float:left;' alt='".$alien->login."' />";
//			$ssa = "<img class='cauth' src='res.php?t=av&img=".$alien->av."' style='float:left;' alt='".$alien->login."' />";
		}
                $rate=$alien->rate();
//		if ($alien->rate() > 0) {
//			$rtp="<span class='rp'>".$alien->rate()."</span>";
//		} elseif ($alien->rate() < 0) {
//			$rtp = "<span class='rm'>".$alien->rate()."</span>";
//		}  else {
//			$rtp = $alien->rate();
//		}
//		echo "<div id='btop'>".$big_img."<span class='bnm'><a href='user/".$alien->login."'>".$alien->login."</a></span><span class='rate'>
//				<a class='ratep' href='twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur."'>+</a>
//				".$rtp."<a class='ratem' href='twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur."'>&ndash;</a></span></div>";
$frm=request::get_get('frm',0);
                $all_count=db_result(db_query('SELECT COUNT(id) FROM comment WHERE who = %s ORDER BY id DESC',$who));
		$result = db_query('SELECT * FROM comment WHERE who = %s ORDER BY id DESC LIMIT %d, %d', $who,$frm,$count);
                if (!$all_count) {
    
//			echo "<span id='nocom'>Коментариев нет</span>";
 echo render_template(TPL_FRAMES.'/comment_list.tpl.php',array(
                        'avatar'=>$avatar,'avatar_url'=>$avatar_url,'name'=>$name,'rate'=>$rate,'yes'=>0));
		} else {
			while($row = db_fetch_assoc($result)) {
				$com = new comment($row);
				
				$post = db_fetch_assoc(db_query('SELECT * FROM post WHERE id = %d', $row['krnl']));
				if ($post['blogid']) {
                                    $blog=$post['blog'];
                                    $blog_url='blog/'.$post['blogid'];
//					$us="<a href='blog/".$post['blogid']."'>".$post['blog']."</a>  &#8212;  ";
				} else {
                                  $blog=$post['auth'];
                                    $blog_url='user/'.$post['auth'];
//					$us="<a href='auth/".$post['auth']."'>".$post['auth']."</a>  &#8212;  ";
				}
//				$date = date('d.m.y H:i',$com->date);
//				$text = code($com->text);

//				if ($com->rate() > 0) {
//					$rate="<span class='rp'>".$com->rate()."</span>";
//				} elseif ($com->rate() < 0) {
//					$rate="<span class='rm'>".$com->rate()."</span>";
//				}  else {
//					$rate=$com->rate();
//				}
//				echo "
//<div class='ctop'>".$ssa."
//	<span class='date'>".$date."</span>
//	<span class='cauth'>&nbsp;".$us."<a href='post/".$post['id']."#cmnt".$row['id']."'>".$post['title']."</a></span>
//	<span class='crate rateonly'>".$rate."</span>
//</div>
//<div class='ctext'>".$text."</div>
//";
$comments[]=array('blog'=>$blog,'blog_url'=>$blog_url,'date'=>date('d.m.y H:i',$com->date),'text'=>code($com->text),
"rate"=>$com->rate(),'post_title'=>$post['title']);
			}
                        echo render_template(TPL_FRAMES.'/comment_list.tpl.php',array('comments'=>$comments,
                        'avatar'=>$avatar,'avatar_url'=>$avatar_url,'name'=>$name,'rate'=>$rate,'yes'=>1));
		}
                
	}
echo render_paginator('comment/'.$alien->login.'/', $count,$all_count, $frm);
include("inc/foot.php");
?>