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
function writeCache($content, $filename) {
	$fp = fopen('./tmp/html/' . $filename, 'w');
	fwrite($fp, $content);
	fclose($fp);
}
function readCache($filename, $expiry) {
	if (file_exists('./tmp/html/' . $filename)) {
		if ((time() - $expiry) > filemtime('./tmp/html/' . $filename))
		return FALSE;
		$cache = file('./tmp/html/' . $filename);
		return implode('', $cache);
	}
	return FALSE;
}
function inCache($what,$name) {
	$GLOBALS['cache_'.$name]=$what;
}
function retCache($name) {
	if (isset($GLOBALS['cache_'.$name])) {
		return($GLOBALS['cache_'.$name]);
	} else {
		return(FALSE);
	}
}
?>