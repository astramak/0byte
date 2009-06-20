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
function ntag($tag) {
	if (!tag_is_valid($tag)) return 0;
	$id = db_result(db_query('SELEC id FROM tags WHERE LOWER(name) = LOWER(%s)', $tag));
	if ($id) {
		db_query('UPDATE tags SET num = num + 1 WHERE id = %d', $id);
	} else {
		db_query('INSERT INTO tags SET name = %s, num = 1', $tag);
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

function otag($tag) {
	if (!tag_is_valid($tag)) return 0;
	$id = db_result(db_query('SELECT id FROM tags WHERE LOWER(name) = LOWER(%s)', $tag));
	if ($id) {
		db_query('UPDATE tags SET num = num - 1 WHERE id = %d', $id);
	}
	return(1);
}

function tag_is_valid($tag) {
	$len = strlen($tag);
	return ($len > 2 && $len < 40);
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