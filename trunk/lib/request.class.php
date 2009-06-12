<?php
/*
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

/**
 * Wrapper for PHP Request
 *
 * @author Vladimir "krig" Garvardt <vgarvardt@gmail.com>
 */
class request {
/**
 * Gets variable from $_REQUEST array
 *
 * @param string $var valiable name
 * @param mixed $default_value default value if $_REQUEST[$var] is not set
 * @param bool $default_on_empty sets default value if value is empty
 * @return mixed
 */
	public static function get_request($var, $default_value = "", $default_on_empty = false) {
		return self::get_from_array($_REQUEST, $var, $default_value, $default_on_empty);
	}

	/**
	 * Gets variable from $_POST array
	 *
	 * @param string $var valiable name
	 * @param mixed $default_value default value if $_POST[$var] is not set
	 * @param bool $default_on_empty sets default value if value is empty
	 * @return mixed
	 */
	public static function get_post($var, $default_value = "", $default_on_empty = false) {
		return self::get_from_array($_POST, $var, $default_value, $default_on_empty);
	}

	/**
	 * Gets variable from $_GET array
	 *
	 * @param string $var valiable name
	 * @param mixed $default_value default value if $_GET[$var] is not set
	 * @param bool $default_on_empty sets default value if value is empty
	 * @return mixed
	 */
	public static function get_get($var, $default_value = "", $default_on_empty = false) {
		return self::get_from_array($_GET, $var, $default_value, $default_on_empty);
	}

	/**
	 * Gets variable from $_COOKIE array
	 *
	 * @param string $var valiable name
	 * @param mixed $default_value default value if $_COOKIE[$var] is not set
	 * @param bool $default_on_empty sets default value if value is empty
	 * @return mixed
	 */
	public static function get_cookie($var, $default_value = "", $default_on_empty = false) {
		return self::get_from_array($_COOKIE, $var, $default_value, $default_on_empty);
	}

	/**
	 * Gets value from $_ARRAY array
	 *
	 * @param array $_ARRAY
	 * @param string $var variable name
	 * @param mixed $default_value default value if $_ARRAY[$var] is not set
	 * @param bool $default_on_empty sets default value if value is empty
	 * @return mixed
	 */
	private static function get_from_array(&$_ARRAY, $var, $default_value, $default_on_empty) {
		$out = $default_value;
		if (isset($_ARRAY[$var])) {
			if (!$default_on_empty || strlen(strval($_ARRAY[$var])) > 0) {
				$out = self::process_val($_ARRAY[$var]);
			}
		}
		return $out;
	}

	/**
	 * Gets processed var
	 *
	 * @param mixed $val
	 */
	private static function process_val($val) {
		if (get_magic_quotes_gpc()) {
			if (is_array($val)) {
				foreach ($val as $key => $value) {
					$val[$key] = self::process_val($value);
				}
			} elseif(is_string($val)) {
				$val = stripslashes($val);
			}
		}
		return $val;
	}
}
?>