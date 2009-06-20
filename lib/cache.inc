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
	if (!is_writable('./tmp/html/')) return false;
	$fp = fopen('./tmp/html/' . $filename, 'w');
	if (!$fp) return false;
	fwrite($fp, $content);
	fclose($fp);
	return true;
}

function readCache($filename, $expiry) {
	$filepath = './tmp/html/' . $filename;
	if (is_file($filepath)) {
		if ((time() - $expiry) > filemtime($filepath)) return false;
		return file_get_contents($filepath);
	}
	return false;
}

function inCache($what,$name) {
	$GLOBALS['cache_' . $name] = $what;
}

function retCache($name) {
	if (isset($GLOBALS['cache_' . $name])) {
		return($GLOBALS['cache_' . $name]);
	} else {
		return(FALSE);
	}
}
?>