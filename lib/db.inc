<?php
define('DB_QUERY_REGEXP', '/(%d|%s|%%|%f|%b|%n)/');

function db_connect($settings = null) {
    static $connections = null;

    if (!$settings) {
        global $db_settings;
        $settings = $db_settings;
    }

    if (!isset($connections[$settings])) {
        $parts = parse_url($settings);
        $scheme = $parts['scheme'];
        $host = $parts['host'];
        $port = isset($parts['port']) ? $parts['port'] : null;
        $user = $parts['user'];
        $pass = isset($parts['pass']) ? $parts['pass'] : '';
        $name = substr($parts['path'], 1);

        $scheme_lib = dirname(__FILE__) .  '/db.' . $scheme . '.inc';
        if (!is_file($scheme_lib)) {
            die('Proper DB lib was not found (' . $scheme . ')');
        }
        require_once $scheme_lib;
        $connections[$settings] = _db_connect($host, $user, $pass, $port);
        if (!db_select_db($name, $connections[$settings])) {
            die('Select DB error: ' . db_error($connections[$settings]));
        }
    }

    return $connections[$settings];
}

function db_select_db($db_name) {
    return _db_select_db($db_name);
}

function db_error() {
    return _db_error();
}

function db_query($query) {
    $args = func_get_args();
    array_shift($args);
    if (isset($args[0]) and is_array($args[0])) { // 'All arguments in one array' syntax
        $args = $args[0];
    }
    _db_query_callback($args, TRUE);
    $query = preg_replace_callback(DB_QUERY_REGEXP, '_db_query_callback', $query);
    return _db_query($query);
}

function _db_query_callback($match, $init = FALSE) {
    static $args = NULL;
    if ($init) {
        $args = $match;
        return;
    }

    switch ($match[1]) {
        case '%d': // We must use type casting to int to convert FALSE/NULL/(TRUE?)
            return (int) array_shift($args); // We don't need db_escape_string as numbers are db-safe
        case '%s':
            return _db_escape_string(array_shift($args));
        case '%n':
        // Numeric values have arbitrary precision, so can't be treated as float.
        // is_numeric() allows hex values (0xFF), but they are not valid.
            $value = trim(array_shift($args));
            return get_int($value);
        case '%%':
            return '%';
        case '%f':
            return (float) array_shift($args);
        case '%b': // binary data
            return _db_encode_blob(array_shift($args));
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
function db_fetch_object($result) {
    return _db_fetch_object($result);
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
function db_fetch_assoc($result) {
    return _db_fetch_assoc($result);
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
function db_result($result) {
    return _db_result($result);
}

/**
 * Returns the last insert id.
 *
 * @param $table
 *   The name of the table you inserted into.
 * @param $field
 *   The name of the autoincrement field.
 */
function db_last_insert_id($table, $field = 'id') {
    return _db_last_insert_id($table, $field);
}

/**
 * Returns rows number in the result
 *
 * @param resource $result
 * @return int
 */
function db_num_rows($result) {
    return _db_num_rows($result);
}
?>
