<?php
function _db_connect($host, $user, $pass, $port = null) {
	if ($port) $host .= ':' . $port;
	$link = mysql_connect($host, $user, $pass);
	if (!$link) {
		die(mysql_error());
	}
	mysql_query("SET NAMES UTF8", $link);
	return $link;
}

function _db_select_db($db_name) {
	return mysql_select_db($db_name);
}

function _db_error() {
	return mysql_error();
}

function _db_escape_string($text) {
	return "'" . mysql_real_escape_string($text) . "'";
}

function _db_encode_blob($data) {
	return "'" . mysql_real_escape_string($data) . "'";
}

function _db_query($query) {
	$result = mysql_query($query);

	if ($result) {
		return $result;
	} else {
		trigger_error(check_plain(mysql_error() ."\nquery: ". $query), E_USER_WARNING);
	}
}

/**
 * Fetch one result row from the previous query as an object.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   An object representing the next row of the result, or FALSE. The attributes
 *   of this object are the table fields selected by the query.
 */
function _db_fetch_object($result) {
	if ($result) {
		return mysql_fetch_object($result);
	}
}

/**
 * Fetch one result row from the previous query as an array.
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   An associative array representing the next row of the result, or FALSE.
 *   The keys of this object are the names of the table fields selected by the
 *   query, and the values are the field values for this result row.
 */
function _db_fetch_assoc($result) {
	if ($result) {
		return mysql_fetch_assoc($result);
	}
}

/**
 * Return an individual result field from the previous query.
 *
 * Only use this function if exactly one field is being selected; otherwise,
 * use db_fetch_object() or db_fetch_array().
 *
 * @param $result
 *   A database query result resource, as returned from db_query().
 * @return
 *   The resulting field or FALSE.
 */
function _db_result($result) {
	if ($result && mysql_num_rows($result) > 0) {
	// The mysql_fetch_row function has an optional second parameter $row
	// but that can't be used for compatibility with Oracle, DB2, etc.
		$array = mysql_fetch_row($result);
		return $array[0];
	}
	return FALSE;
}

/**
 * Returns the last insert id.
 *
 * @param $table
 *   The name of the table you inserted into.
 * @param $field
 *   The name of the autoincrement field.
 */
function _db_last_insert_id($table, $field) {
	return _db_result(_db_query('SELECT LAST_INSERT_ID()'));
}
?>
