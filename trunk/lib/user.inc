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
class user {
	var $login;
	var $pwd;
	var $ratep;
	var $ratem;
	var $cheked;
	var $mail;
	var $icq;
	var $jabber;
	var $site;
	var $about;
	var $av;
	var $lvl;
	var $frnd;
	var $lck;
	var $hml;
	var $otr;
	var $uotr;
	var $pr;
	var $cr;
	var $pmr;
	var $brate;
	var $crate;
	var $prate;
	var $juse;
	var $jtext;
	var $jname;
	var $city;
	function rate() {
		global $blog_r,$com_r,$post_r;
		if ($this->uotr==0) {
			$this->otr=$this->brate/$blog_r+$this->crate/$com_r+$this->prate/$post_r;
			$this->uotr=1;
		}
		return($this->ratep - $this->ratem + $this->otr);
	}
	function find($name) {
		global $sql;
		$sql_get="SELECT * FROM `users` WHERE LOWER(name) = LOWER('".mysql_escape_string($name)."')   ";
		$result=mysql_query($sql_get,$sql);
		if (!$result) {
			echo  mysql_error();
		}
		$row = mysql_fetch_assoc($result);
		if (strtolower($row['name'])==strtolower($name)) {
			$this->uotr=0;
			$this->login=$name;
			$this->ratep=$row['ratep'];
			$this->ratem=$row['ratem'];
			$this->mail=$row['mail'];
			$this->icq=$row['icq'];
			$this->jabber=$row['jabber'];
			$this->site=$row['site'];
			$this->about=$row['about'];
			$this->av=$row['av'];
			$this->lvl=$row['lvl'];
			$this->frnd=$row['frnd'];
			$this->lck=$row['lck'];
			$this->hml=$row['hml'];
			$this->pr=$row['postre'];
			$this->cr=$row['comre'];
			$this->pmr=$row['pmre'];
			$this->crate=$row['crate'];
			$this->brate=$row['brate'];
			$this->prate=$row['prate'];
			$this->city=$row['city'];
			return (1);
		} else {
			return(0);
		}
	}
	function g_j() {
		global $sql;
		$sql_get="SELECT * FROM `users` WHERE name = '".mysql_escape_string($this->login)."'   ";
		$result=mysql_query($sql_get,$sql);
		$row = mysql_fetch_assoc($result);
		$this->juse=$row['juse'];
		if ($this->juse!=0){
			$this->jname=$row['jname'];
			if ($row['jdate']>=(time()-300)) {
				$this->jtext=$row['jtext'];
			} else {
				if ($this->juse==1) {
					$jurl="http://rss.juick.com/".$row['jname']."/blog";
				} else {
					$jurl="http://twitter.com/statuses/user_timeline/".$row['jname'].".rss";
				}
				$xml=simplexml_load_file($jurl);
				$this->jtext=$xml->channel->item[0]->description;
				$sl="UPDATE `users` SET `jdate` = '".time()."', `jtext` = '".$this->jtext."'
				WHERE `users`.`name` = '".mysql_escape_string($this->login)."'";
				$result=mysql_query($sl,$sql);
			}
		}
		return $this->juse;
	}
	function looser($name) {
		global $sql;
		$sql_get="SELECT * FROM `users` WHERE name = '".mysql_escape_string($name)."'   ";
		$result=mysql_query($sql_get,$sql);
		if (!$result) {
			echo  mysql_error();
		}
		$row = mysql_fetch_assoc($result);
		if ($row['name']==$name) {
			$this->login=$name;
			$this->mail=$row['mail'];
			$this->pwd=$row['pwd'];
			return (1);
		} else {
			return(0);
		}
	}
	function chek() {
		global $sql;
		if ($this->cheked!=1) {
			$sql_get="SELECT * FROM `users` WHERE  name = '".$this->login."' && lck = 0  ";
			$result=mysql_query($sql_get,$sql);
			if (!$result) {
				echo  mysql_error();
			}
			$row = mysql_fetch_assoc($result);
			if (strcmp($row['pwd'],$this->pwd)==0 && $row['activ']==1) {
				$this->cheked=1;
				$this->ratep=$row['ratep'];
				$this->ratem=$row['ratem'];
				$this->crate=$row['crate'];
				$this->brate=$row['brate'];
				$this->prate=$row['prate'];
				$this->lvl=$row['lvl'];
				return(1);
			} else {
				return(0);
			} } else {
				return(1);
			}
				
	}
}

function login() {
	global $usr;
	if (isset($_POST['un']) && $_POST['un']==1) {
		setcookie(login);
		setcookie(pwd);
		session_unregister("login");
		session_unregister("pwd");
		session_destroy();
		return(0);
	} else 	if (isset($_COOKIE['login']) && isset($_COOKIE['pwd']) && strlen($_COOKIE['login'])>1 && $_SESSION['login']<2 ) {
		$_SESSION['login']=$_COOKIE['login'];
		$_SESSION['pwd']=$_COOKIE['pwd'];
	}
	$usr->login=$_SESSION['login'];
	$usr->pwd=md5(base64_decode($_SESSION['pwd']));
	if ($usr->chek()==1) {
		return(1);
	} else {
		return(0);
	}
}
?>