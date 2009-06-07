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
class com {
	var $id;
	var $auth;
	var $date;
	var $text;
	var $ratem;
	var $ratep;
	var $lvl;
	var $cid;
	function make($a) {
		$this->id=$a['id'];
		$this->auth=$a['who'];
		$this->date=$a['date'];
		$this->text=$a['text'];
		$this->ratem=$a['ratem'];
		$this->ratep=$a['ratep'];
		$this->lvl=$a['lvl'];
		$this->cid=$a['cid'];
	}
	function rate() {
		return ($this->ratep-$this->ratem);
	}
}
function klist($a) {
	global $sql,$loged,$usr;
	$sql_get="SELECT * FROM `comment` WHERE krnl = '".$a."'   ";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$re= "<a class='klist' href='post/".$a."/#cm'><img src='style/img/speech_bubble.gif' alt='Коментариев: ' />";
	$id=mysql_num_rows($result);
	if ($loged==1) {
		$sql_get="SELECT * FROM `hist` WHERE `pid` = '".$a."' && `who`='".$usr->login."'  ";
		$result=mysql_query($sql_get,$sql);
		$rw = mysql_fetch_assoc($result);
		$v_date=$rw['date'];
		$sql_get="SELECT * FROM `comment` WHERE `krnl` = '".$a."' && `date` >= '".$v_date."' && `who`!='".$usr->login."'";
		$result=mysql_query($sql_get,$sql);
		$nid=mysql_num_rows($result);
		if ($nid>0) {
			$re.="<span class='rp'>".$nid."</span> / ";
		}
	}
	if ($id==0) {
		$re.="нет";
	} else {
		$re.=$id;
	}
	$re.="</a>";
	return $re;
}
function rmcom($com) {
	global $sql;
	$sql_get="DELETE FROM `comment` WHERE `comment`.`id` = ".$com->id;
	$result=mysql_query($sql_get,$sql);
	$sql_get="SELECT * FROM `comment` WHERE cid = '".$com->id."' && lvl='".($com->lvl+1)."'  ORDER BY  id   ";
	$result=mysql_query($sql_get,$sql);
	if ($id=mysql_num_rows($result)==0) {} else {
		$cm=new com;
		while($row = mysql_fetch_assoc($result)) {
			$cm->make($row);
			rmcom($cm);
		}
	}
}
function com_echo($com,$noecho) {
	global $sql,$usr,$loged,$elvl,$post11,$v_date,$jstocom,$num_com,$cur,$last_com_id;
	$ech= "<dl class='lvl2'><dt id='cmnt".$com->id."' >";
	if ($last_com_id<$com->id) {
		$last_com_id=$com->id;
	}
	$cur=$cur;
	if (isset($_GET['hl']) && $_GET['hl']==$row['id']) {
		$ech.= "<a id='".$row['id']."'></a>";
	}
	$alien=new user;
	$alien->find($com->auth);
	$cmn="";
	$usr=$usr;
	if ($loged==1) {
		$lnk="work/comment/".$com->id."/".$com->lvl."/$cur";
		if (isset($noecho)) {
			$lnk="javascript:doit('".$com->id."','".($com->lvl+1)."')";
		}
		$cmn="(<a href=\"".$lnk."\">Ответить</a>)"; 
		if ($usr->lvl>=$elvl || ($com->auth == $usr->login && $cedit==1)) {

			$cmn.=" (<a href='work/editcom/".$com->id."/'>Редактировать</a>)";
		}
		if ($usr->lvl>=$elvl) {
			$cmn.=" (<a href='work/rmcom/".$com->id."/'>Удалить</a>)";
		}
	}
	$ssa= "<img class='cnoauth' src='style/img/figure.gif' />";
	if (strlen($alien->av)>2) {
		$ssa= "<img class='cauth' src='res.php?t=av&amp;img=".$alien->av."' />";
	}

	$rt="";$rate=$com->rate();
	if ($com->lvl>0) {
		$top="<a class='clnk' href='post/".$post11."/#cmnt".$com->cid."' title='Уровнем выше'>&#8593;</a>";
	} else {$top="";}
	if ($com->date>=$v_date && $com->auth!=$usr->login && $loged==1) {
		$cls="cntop";
		$jstocom.="com_arr[".$num_com."]='#cmnt".$com->id."'; ";
		$num_com+=1;
	} else {
		$cls="ctop";
	}
	if ($rate>0) {$rt="<span class='rp'>".$rate."</span>";}
	else if ($rate<0) {$rt="<span class='rm'>".$rate."</span>";} else {$rt=0;}
	$ech.= "<div class='".$cls."'>".$ssa."<a class='cauth' href='user/".$com->auth."'>".$com->auth."</a><span class='date'>".date('d.m.y  H:i',$com->date)."</span><a title='Ссылка на комментарий' class='clnk' href='post/".$post11."/#cmnt".$com->id."'>#</a>".$top."
			<span class='crate'><noindex><a rel='nofollow' class='ratep' href='twork.php?wt=ratecom&id=".$com->id."&rate=p&from=".$cur."'>+</a></noindex><span id='rc".$com->id."'>".$rt."</span><noindex><a rel='nofollow' class='ratem' href='twork.php?wt=ratecom&id=".$com->id."&rate=m&from=".$cur."'>&ndash;</a></noindex></span>
			
			</div>";

	$ech.= "<div class='ctext' >".code($com->text)."</div>
			<div class='cbottom'>$cmn</div>
			</dt><dd id='cmadd".$com->id."'>";
	if (!isset($noecho)) {
		echo $ech; $ech="";
		$sql_get="SELECT * FROM `comment` WHERE cid = '".$com->id."' && lvl='".($com->lvl+1)."'  ORDER BY  id   ";
		$result=mysql_query($sql_get,$sql);
		if (!$result) {
			echo  mysql_error();
		}
		if ($id=mysql_num_rows($result)==0) {} else {

			$cm=new com;
			while($row = mysql_fetch_assoc($result)) {
				$cm->make($row);
				com_echo($cm);
					
			}
		}
	}
	$ech.= "</dd><dt id='cm".$com->id."'></dt></dl>";
	if (isset($noecho)) {
		return $ech;
	}	else {
		echo $ech;
	}
}
?>