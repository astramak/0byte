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
class comment {
	var $id;
	var $date;
	var $text;
	var $auth;
	var $cid;
	var $ratep;
	var $ratem;
	var $lvl;
	var $krnl;
	var $new;

	function comment($row = null) {
		if ($row) $this->make($row);
	}

	function make($row) {
		$alias = array('who' => 'auth');
		foreach ($row as $key => $val) {
			$prop = isset($alias[$key]) ? $alias[$key] : $key;
			$this->{$prop} = $val;
		}
	}

	function rate() {
		return ($this->ratep - $this->ratem);
	}
}

function klist($pid) {
	global $loged, $usr;
	$re = "<a class='klist' href='post/".$pid."/#cm'><img src='style/img/speech_bubble.gif' alt='Коментариев:' /> ";
	$count = db_result(db_query('SELECT COUNT(id) FROM comment WHERE krnl = %d', $pid));
	if ($loged) {
		$v_date = db_result(db_query('SELECT date FROM hist WHERE pid = %d AND who = %s', $pid, $usr->login));
		$new = db_result(db_query('SELECT COUNT(id) FROM comment WHERE krnl = %d AND date >= %d AND who != %s', $pid, $v_date, $usr->login));
		if ($new) {
			$re .= "<span class='rp'>" . $new . "</span> / ";
		}
	}
	$re .= ($count ? $count : 'нет') . '</a>';
	return $re;
}

function rmcom($com) {
// remove comment itself
	db_query('DELETE FROM comment WHERE id = %d', $com->id);
	// and remove all comment children
	$result = db_query('SELECT id FROM comment WHERE cid = %d', $com->id);
	while ($row = db_fetch_object($result)) {
		rmcom($row);
	}
}

function com_echo($com,$noecho=0) {
	global $usr,$loged,$elvl,$post11,$v_date,$jstocom,$num_com,$cur,$last_com_id,$cedit;
        $post11=$com->krnl;
	$ech= "<dl class='lvl2'><dt id='cmnt".$com->id."' >";
	if ($last_com_id<$com->id) {
		$last_com_id=$com->id;
	}
	$cur=$cur;
       	$alien=new user();
	$alien->find($com->auth);
	$usr = $usr;
	if ($loged==1) {
		$allow_edit=0;
		$allow_delete=0;
		if ($usr->lvl>=$elvl || ($com->auth == $usr->login && $cedit==1)) {
			$allow_edit=1;
		}
		if ($usr->lvl>=$elvl) {
			$allow_delete=1;
		}
	}
	$avatar_use=0;
	if (strlen($alien->av)>2) {
		$avatar_use=1;
	}

	if ($com->date>=$v_date && $com->auth!=$usr->login && $loged==1) {
		$jstocom.="com_arr[".$num_com."]='#cmnt".$com->id."'; ";
		$num_com+=1;
		$com->new=1;
	} else {
		$com->new=0;
	}
        $com->date+=TZ;
	$ech.=render_comment($com,$avatar_use,$allow_edit,$allow_delete,$cur,$loged,$post11,$noecho);
	$ech.="</dt><dd id='cmadd".$com->id."'>";
	if (!$noecho) {
		echo $ech;
		$ech="";
		$result = db_query('SELECT * FROM comment WHERE cid = %d AND lvl = %d ORDER BY id ASC', $com->id, ($com->lvl + 1));
		while ($row = db_fetch_assoc($result)) {
			com_echo(new comment($row));
		}
	}
	$ech.= "</dd><dt id='cm".$com->id."'></dt></dl>";
	if ($noecho!=0) {
		return $ech;
	} else {
		echo $ech;
	}
}
?>