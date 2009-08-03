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
function fladd($list,$user) {
	if (strpos($list,$user)===false) {
		if (strlen($list)>0) {
			$list.=$user.", ";
		} else {
			$list=$user.", ";
		}
	}
	return($list);
}

function flrm($list,$user) {
	return (str_replace($user.", ","",$list));
}

function flsnd($list,$usr,$pid,$comid) {
	global $eml,$site,$s_name;
	$arr=split(",",$list);
	$q=sizeof($arr);
	for ($z=0; $z<$q; $z++) {
		$name = trim($arr[$z]);
		if ($name != $usr) {
		// TOFIX: why do we need to delete record and then add the same record?
			db_query('DELETE FROM eye WHERE pid = %d AND who = %s LIMIT 1', $pid,$name);
			db_query('INSERT INTO eye SET who = %s, pid = %d', $name, $pid);

			$to = db_result(db_query('SELECT mail FROM users WHERE name = %s', $name));
			$subject = "Ответ на отслеживаемый вами пост на ".$s_name;
			$message = render_mail('observe_reply', array(
				'user' => $usr,
				'pid' => $pid,
				'comid' => $comid,
			));
			$headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
			nullbyte_mail($to, $subject, $message, true, $headers);
		}
	}
}
?>