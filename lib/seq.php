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
function gint($int) {
	$int = trim($int);
	$int = preg_match("/^[0-9]+$/i", $int) ? $int : 0;
	return($int);
}
function chml($mail_address) {
	$pattern = "/^[\w-]+(\.[\w-]+)*@";
	$pattern .= "([0-9a-z][0-9a-z-]*[0-9a-z]\.)+([a-z]{2,4})$/i";
	if (preg_match($pattern, $mail_address)) {
		$parts = explode("@", $mail_address);
		if (checkdnsrr($parts[1], "MX")){
			return(1);
		} else {
			return(0);
		}
	} else {
		return(0);
	}
}
function chud($ud) {
	if (preg_match("/[^(\w)|(\x7F-\xFF)|(\s)]/", $ud)) {return(0);} else {return(1);}
}
?>