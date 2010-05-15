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
 
define('CACHE_STATIC', 'static/');
define('CACHE_SQL',    'sql/');

define('CACHE_NO',       0);                 // do not cache
define('CACHE_MIN',      60);                // minute for cache
define('CACHE_NORMAL',   60 * 10);           // 10 minutes
define('CACHE_BIG',      60 * 60);           // hour
define('CACHE_VERY_BIG', 60 * 60 * 24);      // day
 
/*
 * Cache class
 */
class Cache {

	/*
	 * Singleton instance
	 */
	private static $instance = array();
	
	private $path;
	private $valid = false;

	/*
	 * Get the cache instance
	 * @param $type int
	 * @return Cache
	 */
	private static function getInstance($path = CACHE_STATIC) {
		if (!isset(self::$instance[$path])) {
			$instance = new Cache($path);
			
			if (!$instance->valid)
				$instance = false;
		
			self::$instance[$path] = new Cache($path);
		}
		
		return self::$instance[$path];
	}
	
	public static function get($var, $tty = CACHE_NO, $path = CACHE_STATIC) {
		if ($tty === CACHE_NO)
			return false;
	
		$instance = self::getInstance($path);
		
		if (!$instance)
			return false;
			
		return $instance->_get($var, $tty);
	}
	
	public static function set($var, $value, $path = CACHE_STATIC) {
		$instance = self::getInstance($path);
		
		if (!$instance)
			return false;
			
		return $instance->_set($var, $value);
	}
	
	public function __construct($path = CACHE_STATIC) {
		if (!defined('CACHE_PATH'))
			return false;	
			
		if (
			!file_exists(CACHE_PATH)
			&& !mkdir(CACHE_PATH)
		)
			return false;
			
		$path = CACHE_PATH . $path;
		
		if (
			!file_exists($path)
			&& !mkdir($path)
		)
			return false;
			
		$this->path = $path;
		$this->valid = true;
	}
	
	private function getCacheFileName($var) {
		return $this->path . md5($var);
	}
	
	private function _get($var, $tty) {
		$filename = $this->getCacheFileName($var);
		
		if (!file_exists($filename))
			return false;
			
		if (time() - filemtime($filename) > $tty) {
			@unlink($filename);
			return false;
		}
		
		return unserialize(file_get_contents($filename));
	}
	
	private function _set($var, $value) {
		$filename = $this->getCacheFileName($var);
		
		file_put_contents($filename, serialize($value));
	}	
	
}

// ---------------------------------------
// this part is for backward compatibility
// ---------------------------------------
 
function writeCache($content, $filename) {
	return Cache::set($filename, $content);

/*
    if (!is_writable('./tmp/html/')) return false;
    $fp = fopen('./tmp/html/' . $filename, 'w');
    if (!$fp) return false;
    fwrite($fp, $content);
    fclose($fp);
    return true;
*/
}
function deleteCache($filename) {
//    unlink('./tmp/html/'.$filename);
}
function readCache($filename, $expiry) {
	return Cache::get($filename, $expiry);

/*
    $filepath = './tmp/html/' . $filename;
    if (is_file($filepath)) {
        if ((time() - $expiry) > filemtime($filepath)) return false;
        return file_get_contents($filepath);
    }
    return false;
*/
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
