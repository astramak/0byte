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
$fst_post=1;

class post {
	var $title;
	var $date;
	var $auth;
	var $id;
	var $text;
	var $ftext;
	var $ratep;
	var $ratem;
	var $blog;
	var $blogid;
	var $blck;
	var $tp;
	var $flw;

	function post($row = null) {
		if ($row) $this->make($row);
	}

	function make($a) {
		$this->title=$a['title'];
		$this->date=$a['date'];
		$this->auth=$a['auth'];
		$this->id=$a['id'];
		$this->text=$a['text'];
		$this->ftext=$a['ftext'];
		$this->ratep=$a['ratep'];
		$this->ratem=$a['ratem'];
		$this->blog=$a['blog'];
		$this->blck=$a['blck'];
		$this->blogid=$a['blogid'];
		$this->tp=$a['tp'];
		$this->flw=$a['flw'];
		if ($this->tp==1 || $this->tp==2) {
			$this->lnk=$a['lnk'];
		}
	}

	function havecut() {
		if (strstr($this->text,"[cut]")===false && strstr($this->text,"[fcut]")===false) {
			return 0;
		} else {
			return 1;
		}
	}

	function rate() {
		$a=$this->ratep-$this->ratem;
		return($a);
	}

	function is_voting() {
		return ($this->tp == 3);
	}
}

function post_echo($row,$t) {
	global $sql,$usr,$cur,$fst_post,$loged;

	$alien=new user();
	$a=new post($row);

	if ($t==1) {
		$txt=$a->ftext;
	} else {
		$txt=$a->text;
	}
	$txt=code($txt);

	$bls="";
	if($a->blck==1) {
		$bls="style='color:red'";
	}
	if ($a->blog=="own") {
		$alien->find($a->auth);
		$ssa="";
		if (strlen($alien->av)>2) {
			$ssa= "<img  src='res.php?t=av&amp;img=".$alien->av."' class='pav' />";
		}

		$blog="$ssa <a class='blog' href='user/".$a->auth."/'>".$a->auth."</a>  &#8212; ";
	} else {
		$sql_get="SELECT * FROM `blogs` WHERE id = '".$a->blogid."' ";
		$resul=mysql_query($sql_get,$sql);
		$rowa = mysql_fetch_assoc($resul);
		$blg=new blog;
		$blg->make($rowa);
		$k="";
		if (strlen($blg->av)>0) {
			$k="<img class='pav' src='res.php?t=bl&amp;img=".$blg->av."' alt='' />";
		}
		$blog="$k <a class='blog' href='blog/".$a->blogid."/'>".$a->blog."</a> &#8212; ";
		$auth_blc="<a class='auth' href='user/".$a->auth."/'>".$a->auth."</a>";
	}
	if ($a->tp==1) {
		$blog="<a href='".$a->lnk."' rel='nofollow' class='blog'><img class='auth' src='style/lnk.gif' style='height: 20px;' /></a>
		".$blog."<a href='".$a->lnk."' rel='nofollow' class='blog'>".$a->title."</a>";
	} else if ($a->tp==2) {
			$blog="<img class='auth' src='style/tr.gif' style='height: 20px;' />
		".$blog."<a href='post/".$a->id."/' class='blog'>".$a->title."</a>";
			$txt="<a href='".$a->lnk."' rel='nofollow'>Оригинал</a><br />".$txt;
		}
		else {
			$blog.="<a href='post/".$a->id."/' class='blog'>".$a->title."</a>";
		}
	$answ="";
	if ($a->is_voting()) {
		$lnk=$row['lnk'];
		$sl="SELECT * FROM `wansw` WHERE who = '".$usr->login."' && cid = '".$a->id."'";
		$result=mysql_query($sl,$sql);
		$row = mysql_fetch_assoc($result);
		#echo $sl;
		if (strcmp($row['cid'],$a->id)==0) {
			$answ.=answ_echo($a->id);
		} else {
			$sql_get="SELECT * FROM `answ` WHERE cid = '".$a->id."'";
			$answ.="<div id='a_".$a->id."'><form method='post' action='twork.php?wt=answ&cur=".$cur."&id=".$a->id."' />";
			$res=mysql_query($sql_get,$sql);

			if ($lnk==1) {
				$ttp="checkbox";
				echo "<script type='text/javascript'>var a_type=1;</script>";
			} else {
				$ttp="radio";
				echo "<script type='text/javascript'>var a_type=2;</script>";
			}
			while ($ro = mysql_fetch_assoc($res)) {
				if ($lnk==1) {
					$nam=$ro['id'];
					$vl="";
					$fn="onClick=\"set_b('".$ro['id']."')\"";
				} else {
					$nam="answ";
					$vl=" value='".$ro['id']."'";
					$fn="onClick=\"set_a(this.form,'".$ro['id']."')\"";
				}
				$answ.="<label><input type='".$ttp."' name='".$nam."' ".$fn." ".$vl." />".$ro['title']."</label><br />";
			}
			if ($GLOBALS['loged']==1) {
				$answ.="<input type='submit' name='nax' onClick='answe(this.form,1)' value='Голосовать' /><input type='submit' name='nox' onClick='answe(this.form,2)' value='Воздержаться' /></form></div>";
			}
		}
	}
	if ($fst_post==1) {$fst='fst_top'; $fst_post=0; } else {$fst='top';}
	echo "<div class='$fst'><span class='date'>".date('d.m.y  H:i',$a->date)."</span>".$auth_blc."</div>";
	echo "<div class='text'><h2 class='title' $bls>".$blog."
			</h2><div class='mtxt'>".str_replace("[cut]"," ",str_replace("[fcut]"," ",$txt)).$answ."</div></div>";
	return($a);
}

function chkin($a) {
	global $sql,$usr;
	if ($a['lock']==0) {
		return(1);
	} else if ($loged==0) {
			return (0);
		}
		else
			if ($a['auth']==$usr->login) {
				return(1);
			} else
				if ($a['blogid']==0) {
					$sql_get="SELECT * FROM `users` WHERE name = '".$usr->login."' && frnd LIKE  '%".$a['auth']."%' ORDER BY  id DESC ";
					$result=mysql_query($sql_get,$sql);
					if (!$result) {
						echo  mysql_error();
					}
					$row = mysql_fetch_assoc($result);
					if ($row['name']==$usr->login) {
						return(1);
					} else {return(0);}
				} else {
					$sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."' && blogid = '".$a['blogid']."' ORDER BY  id DESC ";
					$result=mysql_query($sql_get,$sql);
					if (!$result) {
						echo  mysql_error();
					}
					$row = mysql_fetch_assoc($result);
					if ($row['name']==$usr->login) {
						return(1);
					} else {return(0);}
				}
}


function answ_echo ($id) {
	global $sql;
	$sql_get="SELECT * FROM `answ` WHERE cid = '".$id."'";
	$res=mysql_query($sql_get,$sql);
	$anw="<table>";
	$num=0;
	$aval=0;
	while ($ro = mysql_fetch_assoc($res)) {
		$num++;
		$ak[$num]['title']=$ro['title']	;
		$ak[$num]['val']=$ro['val'];
		$aval+=$ro['val'];
	}
	$prc=$aval/100;
	for ($i=1;$i<=$num;$i++) {
		$anw.= "<tr><td><b>".$ak[$i]['title']."</b></td><td>".$ak[$i]['val'].'
			</td><td class="tdans"><div class="ans" style="width: '.($ak[$i]['val']/$prc).'%"></div></td></tr>';
	}
	return($anw."</table>");
}
//seq_zone:
?>
