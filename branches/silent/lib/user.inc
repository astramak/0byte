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
    var $block_cause;
    var $other;
    
    private $friends;
    
	function rate() {
		global $blog_r,$com_r,$post_r;
		if ($this->uotr==0) {
			$this->otr=$this->brate/$blog_r+$this->crate/$com_r+$this->prate/$post_r;
			$this->uotr=1;
		}
		return($this->ratep - $this->ratem + $this->otr);
	}

	function find($name,$what="*",$nolock=0) {
		$result = DB::selectFirst('select ' . $what . ' from users where lower(name) = lower(%s) limit 1', array($name), CACHE_MIN);
		
		if (!$result)
			return false;
			
		if ($this->pr)
			$this->pr = $result['postre'];
			
		if ($this->cr)
			$this->cr = $result['compre'];
			
		if ($this->pmr)
			$this->pmr = $result['pmre'];
			
		$this->uotr = 0;
		$this->login = $name;
		
		foreach($result as $key => $val) {
			$this->{$key} = $val;
		}
		
		if ($nolock = 0)
			$this->check_lock();
			
		return true;
	}

        function get_me_on() {
            return(json_decode($this->other));
        }

	function g_j() {
		if ($this->juse != 0) {
			if ($this->jdate < (time()-30)) {
				if ($this->juse == 1) {
					$jurl = "http://rss.juick.com/".$this->jname."/blog";
				} else {
					$jurl = "http://twitter.com/statuses/user_timeline/".$this->jname.".rss";
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
// AND lck = 0
        function check_lock() {
            $row = db_fetch_assoc(db_query('SELECT * FROM `block_user` WHERE `user` = %s LIMIT 1 ', $this->login));
            if (db_result(db_query('SELECT `lck` FROM `users` WHERE `name` = %s',$this->login))>=2) {
                return 2;
            } else if ($row['end']!=1 && $row['end']<time()) {
                db_query("DELETE FROM `block_user` WHERE `id` = %d LIMIT 1",$row['id']);
                db_query("UPDATE `users` SET `lck` = '0' WHERE `name` = %s LIMIT 1 ",$this->login);
                $this->lck=0;
                return 0;
            } else {
                $this->lck=1;
                $this->block_cause=$row['cause'];
                return 1;
            }
        }
	function check() {
		if ($this->cheked != 1) {
			$result = DB::selectFirst('select * from users where lower(name) = lower(%s) limit 1', array($this->login), CACHE_MIN);
		
			if (
				$result 
				&& strcmp($result['pwd'], $this->pwd) == 0
				&& $result['activ'] == 1
				&& !$this->check_lock()
			) {
				$this->cheked = 1;
				
				$this->ratep    = $result['ratep'];
				$this->ratem    = $result['ratem'];
				$this->crate    = $result['crate'];
				$this->brate    = $result['brate'];
				$this->prate    = $result['prate'];
				$this->lvl      = $result['lvl'];
				$this->timezone = $result['timezone'];
				
				$this->lck=0;
				
				return true;
			}
			
			return false;
		}
		
		return false;
	}
	
	/*
	 * Get friends array
	 * @return array
	 */
	public function getFriends() {
	    if (!is_array($this->friends)) {
	        $friends = db_result(db_query('SELECT `frnd` FROM `users` WHERE `name` = %s', $this->login));
	        
	        if ($friends) {
	            $this->friends = explode(',', $friends);
	            trim_array($this->friends, '_db_escape_string');
	        } else {
	            $this->friends = array();
	        }
	        
	    }
	    
	    return $this->friends;
	}
	
	/*
	 * Update last activity time
	 * @return user
	 */
	public function updateOnline() {
        // we don't need to update last activity time too frequently
        // just one update per minute is enough, though
        if ( 
            !isset( $_SESSION['last_online'] )
            || ( time() - intval( $_SESSION['last_online'] ) ) > 60
        ) {
            db_query('UPDATE users SET online = %d WHERE name = %s', time(), $this->login);
            $_SESSION['last_online'] = time();
        }
        
        return $this;
	}
}
function unlogin() {
    if (request::get_post('un',0)) {
        setcookie('login',0, time());
		setcookie('pwd',0, time());
		session_destroy();
	}
}
function login() {
	global $usr,$db_salt;
	
	$login = request::get_cookie('login');
	$pwd = request::get_cookie('pwd');
    
    if (request::get_post('un',0)) 
        return 0;

	if (!isset($_SESSION['login'])) 
	    return 0;

    if (strlen(@$_SESSION['login'])>strlen($login) && strlen(@$_SESSION['pwd'])>strlen($pwd)) {
        $login=$_SESSION['login'];
        $pwd=$_SESSION['pwd'];
    } else {
        $_SESSION['login'] = $login;
        $_SESSION['pwd'] = $pwd;
    }
    
	$usr->login = $login;
	$usr->pwd = md5($db_salt.base64_decode($pwd));
	
	if ($usr->check()) {
		return(1);
	} else {
		return(0);
	}
}
