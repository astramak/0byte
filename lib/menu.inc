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
class mel {
	var $name;
	var $url;
	var $cur;
	var $new;

	function chcur() {
		global $index,$pg;
		if ( isset($index) && $this->url=="." && (sizeof($_GET)==0 || sizeof($_GET)==sizeof($_GET['frm'])   || strncmp($this->url,$pg,strlen($pg))==0 ||  sizeof($_GET)==0 )) {
			$this->cur=1;
		}
//        else if  ($this->url=="main" && $pg != "main") {
//				$this->cur=0;
//			}
			else if (strlen($pg)>1 && strncmp($this->url,$pg,strlen($pg))==0 ) {
				$this->cur=1;
            }
				 else {
					$this->cur=0;
				}
		return $this->cur;
	}

	function snew() {
		global $usr,$to_main,$loged;
		$dt = time() - 86400;
		if ($this->url==".") {
			$sql_get="SELECT * FROM `post` WHERE `date` > '".$dt."' && `blck` = 0 && `ratep` - `ratem` >= ".$to_main;
		} elseif ($this->url=="main") {
			$sql_get="SELECT * FROM `post` WHERE `date` > '".$dt."' && `blck` = 0 && blog != 'own'";
		} elseif ($this->url=="pers") {
			$sql_get="SELECT * FROM `post` WHERE `date` > '".$dt."' && `blck` = 0 && blog = 'own'";
		} elseif ($this->url=="lenta") {
			if ($loged==1) {
				$sql_get="SELECT * FROM `post` WHERE (";
				$sl="SELECT * FROM `inblog` WHERE  `name` = '".$usr->login."' &&  `out` = 0 ORDER BY  id DESC ";
				$rt=mysql_query($sl);
				$rwo = mysql_fetch_assoc($rt);
				$sql_get.="`blogid` = '".$rwo['blogid']."'";
				while ($rwo = mysql_fetch_assoc($rt)) {
					$sql_get.=" || `blogid` = '".$rwo['blogid']."'";
				}
				$sl="SELECT * FROM `users` WHERE  `name` = '".$usr->login."'";
				$rt=mysql_query($sl);
				$rwo = mysql_fetch_assoc($rt);
				$arr=split(",",$rwo['frnd']);
				$q=sizeof($arr);
				for ($z=1;$z<$q;$z++) {
					$f=trim($arr[$z]);
					$sql_get.=" || `auth` = '".$f."'";
				}
				$sql_get.=" ) && (`date` > '".$dt."'  && `blck` = 0) ORDER BY  id DESC";
			}
		}
		$resul=mysql_query($sql_get);
		$this->new=mysql_num_rows($resul);
		if ($this->new==0) {$this->new="";} else {
			$this->new="+".$this->new;
		}
	}
}

class mn {
	var $title;
	var $menu;
	var $menu_c;
	function gt () {
		echo $this->title;
	}
	function mg ($el) {
		return($this->menu[$el]);
	}
}

function cmenu($en) {
	$result = db_query('SELECT * FROM menu ORDER BY id ASC');
	$en->menu_c=0;
	while ($row = db_fetch_assoc($result)) {
		$en->menu[$en->menu_c]=new mel;
		$en->menu[$en->menu_c]->name=$row['name'];
		$en->menu[$en->menu_c]->url=$row['url'];
		$en->menu[$en->menu_c]->chcur();
		$en->menu_c++;
	}
	return ($en);
}
?>