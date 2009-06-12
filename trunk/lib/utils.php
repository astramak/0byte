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
		$pwd .= uniqid();
	}
	$pwd = substr($pwd, 0, $len);
	// more entropy by capitalizing some letters
	for ($i = 0; $i < $len; $i++) {
		if (!is_numeric($pwd[$i]) && rand() % 2) $pwd[$i] = strtoupper($pwd[$i]);
	}
	return $pwd;
}
?>
