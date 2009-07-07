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
	var $jdate;
	var $jtext;
	var $jname;
	var $city;
        var $timezone;
	function rate() {
		global $blog_r,$com_r,$post_r;
		if ($this->uotr==0) {
			$this->otr=$this->brate/$blog_r+$this->crate/$com_r+$this->prate/$post_r;
			$this->uotr=1;
		}
		return($this->ratep - $this->ratem + $this->otr);
	}

	function find($name) {
		$result = db_query('SELECT * FROM `users` WHERE LOWER(name) = LOWER(%s)', $name);
		$row = db_fetch_assoc($result);
		if ($row) {
			$this->uotr = 0;
			$this->login = $name;
			foreach ($row as $key => $val) {
				$this->{$key} = $val;
			}
			return true;
		}
		return false;
	}

	function g_j() {
		if ($this->juse != 0) {
			if ($this->jdate < (time()-300)) {
				if ($this->juse == 1) {
					$jurl = "http://rss.juick.com/".$row['jname']."/blog";
				} else {
					$jurl = "http://twitter.com/statuses/user_timeline/".$row['jname'].".rss";
				}
				$xml = simplexml_load_file($jurl);
				$this->jtext = $xml->channel->item[0]->description;
				$this->jdate = time();
				db_query('UPDATE users SET jdate = %d, jtext = %s WHERE name = %s', time(), $this->jtext, $this->login);
			}
		}
		return $this->juse;
	}

	function looser($name) {
		return $this->find($name);
	}

	function check() {
		if ($this->cheked != 1) {
			$result = db_query('SELECT * FROM users WHERE name = %s AND lck = 0', $this->login);
			$row = db_fetch_assoc($result);
			if ($row && strcmp($row['pwd'], $this->pwd) == 0 && $row['activ'] == 1) {
				$this->cheked = 1;
				$this->ratep = $row['ratep'];
				$this->ratem = $row['ratem'];
				$this->crate = $row['crate'];
				$this->brate = $row['brate'];
				$this->prate = $row['prate'];
				$this->lvl = $row['lvl'];
                                $this->timezone=$row['timezone'];
				return true;
			} else {
				return false;
			}
		} else {
			return true;
		}
	}
}

function login() {
	global $usr;
	$un = request::get_post('un');
	$login = request::get_cookie('login');
	$pwd = request::get_cookie('pwd');

	if ($un == 1) {
		foreach(array('login', 'pwd') as $key) setcookie($key, '', time() - 4200, '/');
		if (request::get_cookie(session_name())) setcookie(session_name(), '', time() - 4200, '/');
		session_destroy();
		return(0);
	} elseif ($pwd && strlen($login) > 1 && !isset($_SESSION['login'])) {
		$_SESSION['login'] = $login;
		$_SESSION['pwd'] = $pwd;
	}

	if (!isset($_SESSION['login'])) return 0;

	$usr->login = $login;
	$usr->pwd = md5(base64_decode($pwd));
	if ($usr->check()) {
		return(1);
	} else {
		return(0);
	}
}
?>