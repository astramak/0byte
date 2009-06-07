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
function ntag($a) {
	global $sql;
	if (strlen($a)<3 || strlen($a)>40 ) {
		return(0);
	}
	$sql_get="SELECT * FROM `tags` WHERE LOWER(name) = LOWER('".$a."')";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result);
	if (strlen($row['name'])==strlen($a)) {

		$sl="UPDATE `tags` SET `num` = `num`+1
		WHERE `tags`.`name` = '".$row['name']."'";
		$result=mysql_query($sl,$sql);
	} else {
		$sl="INSERT INTO `tags` (`name`,`num`)
	VALUES ( '".$a."' ,'1' )"; 
		$result=mysql_query($sl,$sql);
	}
	return(1);
}
function stag($a) {
	$t=0;
	$arr=split(",",$a);
	$q=sizeof($arr);
	$res="";
	for ($z=0;$z<$q;$z++) {
		if (ntag(trim($arr[$z]))==1) {
			if ($t==0) {
				$t=1;
				$res=trim($arr[$z]);
			} else {
				$res.=",".trim($arr[$z]);
			}
		}
	}
	return($res);
}
//tag remove

function otag($a) {
	global $sql;
	if (strlen($a)<3 || strlen($a)>40 ) {
		return(0);
	}
	$sql_get="SELECT * FROM `tags` WHERE LOWER(name) = LOWER('".$a."')";
	$result=mysql_query($sql_get,$sql);
	if (!$result) {
		echo  mysql_error();
	}
	$row = mysql_fetch_assoc($result); 
	if (strlen($row['name'])==strlen($a)) {

		$sl="UPDATE `tags` SET `num` = `num`-1
		WHERE `tags`.`name` = '".$row['name']."'";
		$result=mysql_query($sl,$sql);
	}
	return(1);
}
function rtag($a) {
	$t=0;
	$arr=split(",",$a);
	$q=sizeof($arr);
	for ($z=0;$z<$q;$z++) {
		if (otag(trim($arr[$z]))==1) {
			if ($t==0) {
				$t=1;
				$res=trim($arr[$z]);
			} else {
				$res.=",".trim($arr[$z]);
			}
		}
	}
	return($res);
}
?>