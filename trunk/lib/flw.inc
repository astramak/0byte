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
	global $sql,$eml,$site,$s_name;
	$arr=split(",",$list);
	$q=sizeof($arr);
	for ($z=0; $z<$q; $z++) {
		if (trim($arr[$z]) != $usr) {
			$sql_get="SELECT * FROM `users` WHERE name = '".trim($arr[$z])."'";
			$result=mysql_query($sql_get,$sql);
			$row = mysql_fetch_assoc($result);
			$sql_get="DELETE FROM `eye` WHERE `pid`='".$pid."' && `who`='".trim($arr[$z])."' LIMIT 1";
			$result=mysql_query($sql_get,$sql);
			$sql_get="INSERT INTO `eye` ( `who` ,`pid`) VALUES ('".trim($arr[$z])."','".$pid."')";
			$result=mysql_query($sql_get,$sql);

			$to = $row['mail'];
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