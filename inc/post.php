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
$inser='';
if (isset($_GET['pg'])) {
	$inser.=$_GET['pg']."/";
}
if (isset($_GET['blog'])) {
	$inser.="blog/".$_GET['blog']."/";
}
$blck="&& blck = '0'";
if ($usr->lvl>=$rlvl) {
	$blck="";
}
//$blck.=" && draft = 0";
if (isset($_GET['count'])) {
	$count=$_GET['count'];
} else {
	$count=10;
}
$favourite=request::get_get('favourite',0);
$pg=request::get_get('pg','');
//if (isset($_GET['frm'])) {
//	$frm=$_GET['frm'];
//} else {
//	$frm=0;
//}
$draft=request::get_get('draft',0);
$frm=request::get_get("frm",0,0);
if (sizeof($_GET)==0 || ($frm>0 && strlen($pg)<2) ) {
	$sql_get="SELECT * FROM `post` WHERE ratep-ratem >= $to_main $blck ORDER BY  id DESC ";
}
else if ($loged) {
    if ($draft) {
        $inser.='draft/';
        $sql_get="SELECT * FROM `draft` WHERE auth = '".$usr->login."' ORDER BY  id DESC ";
        echo render_template(TPL_POST_LIST.'/draft.tpl.php', null);
    } else if ($favourite){
        $inser.='favourite/';
        $sql_get="SELECT * FROM `favourite`,`post` WHERE `favourite`.`pid`=`post`.`id` && `favourite`.`who` = '".$usr->login."' ORDER BY  `post`.`id` DESC";
        echo render_template(TPL_POST_LIST.'/favourite.tpl.php', null);
    }
} else
	if (isset($_GET['tag'])) {
		$sql_get="SELECT * FROM `post` WHERE tag LIKE '%".gtext($_GET['tag']).",%' || LOWER(tag) = LOWER('".gtext($_GET['tag'])."')
			|| tag = '".gtext($_GET['tag'])."' || tag LIKE '%,".gtext($_GET['tag'])."%'  $blck ORDER BY  id DESC";
		$inser.="tag/".gtext($_GET['tag'])."/";
		echo render_template(TPL_POST_LIST.'/tag.tpl.php', array('text'=>gtext(request::get_get('tag'))));
	} else if (isset($_GET['pg']) && $_GET['pg']=='pers') {
		$sql_get="SELECT * FROM `post` WHERE blog = 'own' $blck ORDER BY  id DESC ";
	} else {
		if (isset($_GET['auth'])) {
			$sql_get="SELECT * FROM `post` WHERE auth = '".mysql_escape_string($_GET['auth'])."' $blck ORDER BY  id DESC ";
			$inser.="auth/".$_GET['auth']."/";
			$au=1;
		} else if (isset($_GET['blog'])) {
			$sql_get="SELECT * FROM `post` WHERE blogid = '".intval($_GET['blog'])."' $blck ORDER BY  id DESC ";
			$bl=1;
		} else {
			$sql_get="SELECT * FROM `post` WHERE blog != 'own' $blck ORDER BY  id DESC ";
		}
	}
if (isset($_GET['fnd'])) {
	$fnd=trim(str_replace(" ", "%", $_GET['fnd']));
	$sql_get="SELECT * FROM `post` WHERE ( title LIKE '%".mysql_escape_string($fnd)."%' || text LIKE '%".mysql_escape_string($fnd)."%' || ftext LIKE '%".mysql_escape_string($fnd)."%' || tag LIKE '%".mysql_escape_string($fnd)."%' )  $blck ORDER BY  id DESC";
	echo render_template(TPL_POST_LIST.'/find.tpl.php', array("text"=>$fnd));
}
if (isset($_GET['pg']) && $_GET['pg']=='lenta') {
//lenta start
	if ($loged==1) {
		$sql_get="SELECT * FROM `post` WHERE ";
		$sl="SELECT * FROM `inblog` WHERE  `name` = '".$usr->login."' &&  `out` = 0 ORDER BY  id DESC ";
		$rt=mysql_query($sl,$sql);
		$rwo = mysql_fetch_assoc($rt);
		$sql_get.="`blogid` = '".$rwo['blogid']."'";
		while ($rwo = mysql_fetch_assoc($rt)) {
			$sql_get.=" || `blogid` = '".$rwo['blogid']."'";
		}
		$sl="SELECT * FROM `users` WHERE  `name` = '".$usr->login."'";
		$rt=mysql_query($sl,$sql);
		$rwo = mysql_fetch_assoc($rt);
		$arr=split(",",$rwo['frnd']);
		$q=sizeof($arr);
		for ($z=1;$z<$q;$z++) {
			$f=trim($arr[$z]);
			$sql_get.=" || `auth` = '".$f."'";
		}
		$sql_get.=" ORDER BY  id DESC";
	}
//lenta end
}
$result=mysql_query($sql_get,$sql);
$i=0; $k=0;
$cur=$_SERVER['REQUEST_URI'];
$cur=str_replace("&","*amp",$cur);
$cur=str_replace("?","*qw",$cur);
$kol=mysql_num_rows($result);
$result=mysql_query($sql_get." LIMIT ".$frm." , ".$count,$sql);

if ($kol<1 && !isset($_GET['blog'])) {
	if (isset($_GET['fnd'])) {
		echo render_error("Ничего не найдено!");
//	} else if (isset($_GET['blog'])) {
//			$sql_get="SELECT * FROM `blogs` WHERE id = '".intval($_GET['blog'])."' ";
//			$resul=mysql_query($sql_get,$sql);
//			$rowa = mysql_fetch_assoc($resul);
//			$blg=new blog;
//			$blg->make($rowa);
//			$sql_get="SELECT * FROM `inblog` WHERE blogid = '".intval($_GET['blog'])."' && name =
//			'".$usr->login."'";
//			$res=mysql_query($sql_get,$sql);
//			$ro = mysql_fetch_assoc($res);
////			$k="";
//                        $avatar=0;
//                        $avatar_url=null;
//			if (strlen($blg->av)>0) {
////				$k="<img style='float:left' src='res.php?t=bl&img=".$blg->av."' alt='' />";
//                                $avatar=1;
//                                $avatar_url="res.php?t=bl&img=".$blg->av;
//                        }
////			$in="<a id='ibl' href='twork.php?wt=mergeblog&amp;id=".$blg->id."'>Вступить!</a>";
//			$in_blog=1;
////                        $inblog_url="twork.php?wt=mergeblog&amp;id=".$blg->id;
//                        if ($ro['name']==$usr->login && $ro['out']==0 ) {
////				$in="<a id='obl' href='twork.php?wt=mergeblog&amp;id=".$blg->id."'>Выйти!</a>";
//                                $in_blog=0;
//                        }
//                        $owner=0;
//			if ($blg->owner==$usr->login || $loged==0) {
////				$in="";
//                                $owner=1;
//			}
//                        echo render_template(TPL_POST_LIST.'/blog.tpl.php', array('avatar'=>$avatar,
//                            'avatar_url'=>$avatar_url,'name'=>$blg->name,'about'=>$blg->about,
//                        'in_blog'=>$in_blog,'inblog_url'=>"twork.php?wt=mergeblog&amp;id=".$blg->id,
//                    'owner'=>$owner,'rate'=>$blg->rate(),'ratep_url'=>"twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=p&amp;from=".$cur,
//                'ratem_url'=>"twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=m&amp;from=".$cur));
////			$rate=$blg->rate();
////			$rt="";
////			if ($rate>0) {$rt="<span class='rp'>".$rate."</span>";}
////			else if ($rate<0) {$rt="<span class='rm'>".$rate."</span>";}
////				else {$rt=0;}
////
////			echo "<div id='btop'>$k<div class='bbnm'><span class='bnm'>".$blg->name."</span><br />".$blg->about."</div><span class='rate'>
////				$in	<noindex><a class='ratep' rel='nofollow' href='twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=p&amp;from=".$cur."'>+</a></noindex>
////			<span id='rb".$blg->id."'>".$rt."</span>
////			<noindex><a class='ratem'  rel='nofollow'
////			href='twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=m&amp;from=".$cur."'>&ndash;</a></noindex></span></div>";
//			echo "<h2>Блог пуст!</h2>";
		} else {
			echo render_error("Страница не существует");
		}
} else {
	if (isset($bl) && $bl==1) {
			$sql_get="SELECT * FROM `blogs` WHERE id = '".intval($_GET['blog'])."' ";
			$resul=mysql_query($sql_get,$sql);
			$rowa = mysql_fetch_assoc($resul);
			$blg=new blog;
			$blg->make($rowa);
			$sql_get="SELECT * FROM `inblog` WHERE blogid = '".intval($_GET['blog'])."' && name =
			'".$usr->login."'";
			$res=mysql_query($sql_get,$sql);
			$ro = mysql_fetch_assoc($res);
//			$k="";
                        $avatar=0;
                        $avatar_url=null;
			if (strlen($blg->av)>0) {
//				$k="<img style='float:left' src='res.php?t=bl&img=".$blg->av."' alt='' />";
                                $avatar=1;
                                $avatar_url="res.php?t=bl&img=".$blg->av;
                        }
//			$in="<a id='ibl' href='twork.php?wt=mergeblog&amp;id=".$blg->id."'>Вступить!</a>";
			$in_blog=1;
//                        $inblog_url="twork.php?wt=mergeblog&amp;id=".$blg->id;
                        if ($ro['name']==$usr->login && $ro['out']==0 ) {
//				$in="<a id='obl' href='twork.php?wt=mergeblog&amp;id=".$blg->id."'>Выйти!</a>";
                                $in_blog=0;
                        }
                        $owner=1;
			if ($blg->owner==$usr->login || $loged==0) {
//				$in="";
                                $owner=0;
			}
                        echo render_template(TPL_POST_LIST.'/blog.tpl.php', array('avatar'=>$avatar,
                            'avatar_url'=>$avatar_url,'name'=>$blg->name,'about'=>$blg->about,
                        'in_blog'=>$in_blog,'inblog_url'=>"twork.php?wt=mergeblog&amp;id=".$blg->id,
                    'owner'=>$owner,'rate'=>$blg->rate(),'ratep_url'=>"twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=p&amp;from=".$cur,
                'ratem_url'=>"twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=m&amp;from=".$cur));
//			$rate=$blg->rate();
//			$rt="";
//			if ($rate>0) {$rt="<span class='rp'>".$rate."</span>";}
//			else if ($rate<0) {$rt="<span class='rm'>".$rate."</span>";}
//				else {$rt=0;}
//
//			echo "<div id='btop'>$k<div class='bbnm'><span class='bnm'>".$blg->name."</span><br />".$blg->about."</div><span class='rate'>
//				$in	<noindex><a class='ratep' rel='nofollow' href='twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=p&amp;from=".$cur."'>+</a></noindex>
//			<span id='rb".$blg->id."'>".$rt."</span>
//			<noindex><a class='ratem'  rel='nofollow'
//			href='twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=m&amp;from=".$cur."'>&ndash;</a></noindex></span></div>";
			if ($kol<1) {
                            echo render_error("Блог пуст!");
                        }
	} else {
		if (isset($au) && $au==1) {
			$alien=new user;
			$alien->find(request::get_get('auth'));
//			$ssa="";
                        $avatar=0;
                        $avatar_url=null;
			if (strlen($alien->av)>2) {
                            $avatar=1;
                            $avatar_url="res.php?t=av&img=".$alien->av;
//				$ssa= "<img  src='res.php?t=av&img=".$alien->av."' style='float:left;' alt='".$alien->login."' />";
			}
                        echo render_template(TPL_POST_LIST.'/user.tpl.php', array('avatar'=>$avatar,
                            'avatar_url'=>$avatar_url,'name'=>$alien->login,'rate'=>$alien->rate(),
                        'ratep_url'=>"twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur,
                    'ratem_url'=>"twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur));
//			$rate=$alien->rate();
//			if ($rate>0) {$rt="<span class='rp'>".$rate."</span>";}
//			else if ($rate<0) {$rt="<span class='rm'>".$rate."</span>";} else {$rt=0;}
//			echo "<div id='btop'>$ssa<span class='bnm'><a href='user/".$alien->login."/'>".$alien->login."</a></span><span class='rate'>
//				$in	<noindex><a rel='nofollow' class='ratep' href='twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur."'>+</a></noindex>
//			<span id='ru".$alien->login."'>
//			".$rt."</span><noindex><a rel='nofollow' class='ratem' href='twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur."'>&ndash;</a></noindex></span></div>";
		}
	}
	while ($row = mysql_fetch_assoc($result)) {
		if (chkin($row)==1 || isset($_GET['tag']) || isset($_GET['blog']) || isset($_GET['auth'])) {

			if (isset($_GET['hl']) && $_GET['hl']==$row['id']) {
				echo "<a id='hl'></a>";
			}
			$posts[$k]=post_echo($row,0,$draft);
//			$rate=$posts[$k]->rate();		$rt="";
//			if ($rate>0) {$rt="<span class='rp'>".$rate."</span>";}
//			else if ($rate<0) {$rt="<span class='rm'>".$rate."</span>";} else {$rt=0;}
			if ($posts[$k]->tp==1 || ($posts[$k]->tp!=3 && $posts[$k]->havecut()==1)) {
//				$full="<a class='full' href='post/".$posts[$k]->id."/'>Полностью...</a>";
                            $full=1;
                        } else {
                            $full=0;
//				$full="";
			}
                        echo render_template(TPL_POST_LIST.'/bottom.tpl.php', array('show_full'=>$full,
                            'id'=>$posts[$k]->id,'comments'=>klist($posts[$k]->id),
                        'ratep_url'=>"twork.php?wt=ratepost&amp;id=".$posts[$k]->id."&amp;rate=p&amp;from=".$cur,
                    'ratem_url'=>"twork.php?wt=ratepost&amp;id=".$posts[$k]->id."&amp;rate=m&amp;from=".$cur,
                'rate'=>$posts[$k]->rate(),'draft'=>$draft));
//			echo "<div class='bottom'>".$full."<span class='rate'>".klist($posts[$k]->id);
//			echo "<noindex><a class='ratep' rel='nofollow' href='twork.php?wt=ratepost&amp;id=".$posts[$k]->id."&amp;rate=p&amp;from=".$cur."'>+</a>
//            </noindex><span id='rp".$posts[$k]->id."'>".$rt."</span><noindex><a rel='nofollow'
// class='ratem' href='twork.php?wt=ratepost&amp;id=".$posts[$k]->id."&amp;rate=m&amp;from=".$cur."'>&ndash;</a></noindex>";
//			echo "</span></div>";
			$k++; }
	}
}

//echo "<div id='list'>";
$fnd=request::get_get('fnd',null);

//if (isset($_GET['fnd'])) {
//	$fnd="/".$_GET['fnd'];
//}
echo render_paginator($inser, $count, $kol, $frm, $fnd);
//$prev=0;
//$prev_url=null;
//if ($frm>=$count) {
////	echo "<a class='nomnm' id='prev' href='".$inser."from/".($frm-$count).$fnd."'>&#8592; </a>";
//    $prev=1;
//    $prev_url=$inser."from/".($frm-$count).$fnd;
//}
//$numb=0;
//while ($kol>0 && $numb<10) {
//	if (($k-1-$frm/$count)<5 && ($k-1-$frm/$count)>-5) {
//		if ($frm==($k-1)*$count) {
////			echo "<span class='nmn'>$k</span> ";
//                        $current=1;
//		} else {
////			echo ("<a class='nmn' href='".$inser."from/".(($k-1)*$count).$fnd."'>$k</a> ");
//                        $current=0;
//		}
//                $numb++;
//                $pages[]=array('current'=>$current,'number'=>$numb,'url'=>$inser."from/".(($k-1)*$count).$fnd);
//
//
//	}
//	$k++;
//	$kol-=$count;
//}
//$next=0;
//$next_url=null;
//if ($frm<($k-2)*$count) {
////	echo "<a class='nomnm' id='next' href='".$inser."from/".($frm+$count).$fnd."'> &#8594;</a>";
//    $next=1;
//    $next_url=$inser."from/".($frm+$count).$fnd;
//}
////echo "<br />";
//$wtch=0;
//$show_first=0;
//$first_url=null;
//if ($frm>=5*$count) {
////	echo "<a class='nomnm' href='".$inser."from/0".$fnd."'>&#8612; Начало</a>";
//        $show_first=1;
//        $first_url=$inser."from/0".$fnd;
////	$wtch=1;
//}
//$show_last=0;
//$last_url=null;
//if ($frm<($k-6)*$count) {
////	if ($wtch==1) {echo "||";}
//	$show_last=1;
//        $last_url=$inser."from/".($k-2)*$count.$fnd;
////        echo "<a class='nomnm' href='".$inser."from/".($k-2)*$count.$fnd."'>Конец &#8614; </a>";
//}
//echo render_template(TPL_FRAMES.'/pagenator.tpl.php',array('prev'=>$prev,'prev_url'=>$prev_url,
//    'next'=>$next,'next_url'=>$next_url,'pages'=>$pages,'show_first'=>$show_first,'first_url'=>$first_url,
//'show_last'=>$show_last,'last_url'=>$last_url));
//echo "</div>";
?>