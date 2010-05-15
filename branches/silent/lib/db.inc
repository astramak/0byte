<?php

/*
* Database superclass
*/
class DB {

	/*
	 * Singleton instance
	 */
	private static $instance = null;

	/*
	 * Database connection
	 */
	private $connection;

	/*
	 * Temporary arguments for prepare __query
	 */
	private $tmpargs;

	/*
	 * Constructor
	 */
	public function __construct() {
		$this->connection = mysql_connect(
			SQL_SERVER,
			SQL_LOGIN,
			SQL_PASS
		) or die('Can\'t connect to database');

		mysql_select_db(
			SQL_DB, 
			$this->connection
		) or die('Can\'t select database');

		$this->_exec('set names utf8') 
			or die('Can\'t execute queries');
	}

	/*
	 * Callback for regex
	 * @param $matches array
	 * @param $init bool
	 * @return string
	 */
	private function prepareCallback($matches) {
		$arg = array_shift($this->tmpargs);

		switch ($matches[1]) {
			case '%d':
				// integer
				return (int) $arg;
			case '%s':
				// string
				return '\'' . mysql_real_escape_string($arg) . '\'';
			case '%f':
				// float
				return (float) $arg;
			case '%%':
				return '%';
		}

		return '';
	}

	/*
	 * Prepare a query
	 * @param $query string
 	 * @param $args array
 	 * @return string
 	 */
	private function prepareQuery($query, $args = array()) {
		$this->tmpargs = $args;
		$prepared = preg_replace_callback('/(%d|%s|%%|%f)/', 'self::prepareCallback', $query);
		unset($this->tmpargs);

		return $prepared;
	}

	/*
	 * Query executor
	 * @param $query string
	 * @param $args array
	 * @return resource
	 */
	private function __query($query, $args = array()) {
		assert($query != '');

		$prepared = count($args) > 0 ? $this->prepareQuery($query, $args) : $query;

		return mysql_query($prepared, $this->connection);
	}

	/*
	 * Select query
	 * @param $query string
	 * @param $args array
	 * @param $tty int
	 * @return array
	 */
	private function _select($query, $args = array(), $tty = CACHE_NO) {
		if (defined('DEBUG')) {
			$log = $query;

			if (count($args) > 0)            
				$log .= ' [' . implode(',', $args) . ']';

			if ($tty > CACHE_NO)
				$log .= ' [' . $tty . ' sec. cache]';

			FB::log($log, 'DB', FirePHP::INFO);
		}

		if ($tty > CACHE_NO	) {
			$cached = Cache::get($query, $tty, CACHE_SQL);

		if ($cached !== false) 
			return $cached;
		}

		$res = $this->__query($query, $args);

		if (!$res) {
			if (defined('DEBUG'))
				FB::log(mysql_error($this->connection), FirePHP::ERROR);

			return false;
		}

		$result = array();

		while ($row = mysql_fetch_assoc($res))
			$result[] = $row;

		mysql_free_result($res);

		if ($tty > CACHE_NO	)
			Cache::set($query, $result, CACHE_SQL);

		return $result;
	}

	/*
	 * Execute query
	 * @param $query string
	 * @param $args array
	 * @return resource
	 */
	private function _exec($query, $args = array()) {
		return $this->__query($query, $args);
	}

	private function _insert($query, $args = array()) {        
		return $this->__query($query, $args) ? mysql_insert_id($this->connection) : -1;
	}

	/*
	 * Getting DB instance
	 * @return DB
	 */
	private static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new DB();
		}

		return self::$instance;
	}

	/*
	 * Select query
	 * @param $query string
	 * @param $args array
	 * @param $tty int
	 * @return array
	 */    
	public static function select($query = '', $args = array(), $tty = CACHE_NO) {
		return self::getInstance()->_select($query, $args, $tty);
	}
	
	public static function selectFirst($query = '', $args = array(), $tty = CACHE_NO) {
		$tmp = self::select($query, $args, $tty);
		
		if (
			$tmp
			&& count($tmp) > 0
		)
			return array_shift($tmp);
			
		return false;
	}

	public static function selectFirstVal($query = '', $args = array(), $tty = CACHE_NO) {
		$tmp = self::selectFirst($query, $args, $tty);

		if (count($tmp) > 0)
			return array_shift($tmp);

		return false;
	}

	/*
	 * Simply execute query with no results
	 * @param $query string
	 * @param $args array
	 * @return resource
	 */
	public static function exec($query = '', $args = array()) {
		return self::getInstance()->_exec($query, $args);
	}

	/*
	 * Insert query
	 * @param $query string
	 * @result int
	 */
	public static function insert($query = '', $args = array()) {
		return self::getInstance()->_insert($query, $args);
	}

	/*
	 * !!! It is just for backward compatibility !!!
	 */
	public static function getConnection() {
		return self::getInstance()->connection;   
	}
}


define('DB_QUERY_REGEXP', '/(%d|%s|%%|%f|%b|%n)/');

function db_connect($settings = null) {
    static $connections = null;

    if (!$settings) {
        global $db_settings;
        $settings = $db_settings;
    }
    
    // ******* part for new DB class ****
    if (!isset($connections[$settings]))
        $connection[$settings] = DB::getConnection();
    // ******* --------------------- ****

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
    
    if (defined('DEBUG'))
        FB::log($query, 'DBold', FirePHP::INFO);
    
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
