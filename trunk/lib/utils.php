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

/**
 * Send email
 *
 * @param string $to email recipient
 * @param string $subject email subject
 * @param string $message email body
 * @param bool $html is email message html
 * @param array $headers additional email headers
 * @return bool
 */
function nullbyte_mail($to, $subject, $message, $html = true, $headers = array()) {
    $mail_headers = $headers;
    if ($html) $mail_headers[] = "Content-type: text/html; charset='UTF-8'";
    $mail_headers[] = 'X-Mailer: PHP/' . phpversion();
    return mail($to, $subject, $message, implode("\r\n", $mail_headers));
}

/**
 * Generate random alpha-numeric string of the following length
 *
 * @param int $len string length
 * @return string
 */
function nullbute_generate_pwd($len) {
    $pwd = '';
    // generate random string
    while (strlen($pwd) < $len) {
        $pwd .= md5(uniqid());
    }
    $pwd = substr($pwd, 0, $len);
    // more entropy by capitalizing some letters
    for ($i = 0; $i < $len; $i++) {
        if (!is_numeric($pwd[$i]) && rand() % 2) $pwd[$i] = strtoupper($pwd[$i]);
    }
    return $pwd;
}

/**
 * Encode special characters in a plain-text string for display as HTML.
 *
 * Uses drupal_validate_utf8 to prevent cross site scripting attacks on
 * Internet Explorer 6.
 */
function check_plain($text) {
    return validate_utf8($text) ? htmlspecialchars($text, ENT_QUOTES) : '';
}

/**
 * Checks whether a string is valid UTF-8.
 *
 * All functions designed to filter input should use drupal_validate_utf8
 * to ensure they operate on valid UTF-8 strings to prevent bypass of the
 * filter.
 *
 * When text containing an invalid UTF-8 lead byte (0xC0 - 0xFF) is presented
 * as UTF-8 to Internet Explorer 6, the program may misinterpret subsequent
 * bytes. When these subsequent bytes are HTML control characters such as
 * quotes or angle brackets, parts of the text that were deemed safe by filters
 * end up in locations that are potentially unsafe; An onerror attribute that
 * is outside of a tag, and thus deemed safe by a filter, can be interpreted
 * by the browser as if it were inside the tag.
 *
 * This function exploits preg_match behaviour (since PHP 4.3.5) when used
 * with the u modifier, as a fast way to find invalid UTF-8. When the matched
 * string contains an invalid byte sequence, it will fail silently.
 *
 * preg_match may not fail on 4 and 5 octet sequences, even though they
 * are not supported by the specification.
 *
 * The specific preg_match behaviour is present since PHP 4.3.5.
 *
 * @param $text
 *   The text to check.
 * @return
 *   TRUE if the text is valid UTF-8, FALSE if not.
 */
function validate_utf8($text) {
    if (strlen($text) == 0) {
        return TRUE;
    }
    return (preg_match('/^./us', $text) == 1);
}

/**
 * Trim array values
 *
 * @param array $list
 * @param string $apply_function apply additional function to all array values
 */
function trim_array(array &$list, $apply_function = '') {
    if ($apply_function) {
        $func = '$v = ' . $apply_function . '(trim($v));';
    } else {
        $func = '$v = trim($v);';
    }
    array_walk($list, create_function('&$v,$k', $func));
}

/**
 * Redirect user to some location
 *
 * @param string $location
 * @param int $http_response_code
 *   Valid values for an actual "goto" as per RFC 2616 section 10.3 are:
 *   - 301 Moved Permanently (the recommended value for most redirects)
 *   - 302 Found (default in Drupal and PHP, sometimes used for spamming search
 *         engines)
 *   - 303 See Other
 *   - 304 Not Modified
 *   - 305 Use Proxy
 *   - 307 Temporary Redirect (alternative to "503 Site Down for Maintenance")
 *   Note: Other values are defined by RFC 2616, but are rarely used and poorly
 *   supported.
 */
function redirect($location, $http_response_code = 302) {
    header('Location: '. $location, true, $http_response_code);
    die;
}
/**
 * Get favicon of requested url
 *
 * @param string $url
 * @return url
 */
function get_favicon_url($url) {
    $out=explode('/',$url);
    return 'http://'.$out[2].'/favicon.ico';
}
?>
