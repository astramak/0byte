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
 * Renders native PHP template and returns rendered content
 *
 * @param string $tpl_path
 * @param array $variables
 * @return string
 */
function render_template($tpl_path, $variables) {
	global $site, $s_name, $sl_name;

	$variables['site'] = $site;
	$variables['s_name'] = $s_name;
	$variables['sl_name'] = $sl_name;

	extract($variables, EXTR_SKIP);
	ob_start();
	include $tpl_path;
	return ob_get_clean();
}

/**
 * Renders mail template
 *
 * @param string $mail_name
 * @param array $variables
 * @return string
 */
function render_mail($mail_name, $variables) {
	return render_template(TPL_MAIL . '/' . $mail_name . '.tpl.php', $variables);
}

/**
 * Renders rss template
 *
 * @param string $type
 * @param string $title
 * @param string $link
 * @param array $items
 * @return string
 */
function render_rss($type, $title, $link, $items) {
	$vars = array(
		'title' => $title,
		'link' => $link,
		'items' => $items,
	);
	return render_template(TPL_RSS . '/posts.tpl.php', $vars);
}

function render_menu($menu_arr,$count) {
	$vars = array('elements'=>$menu_arr,
	'count'=>$count);
	return render_template(TPL_TOP.'/menu.tpl.php',$vars);
}

function render_top() {
	return render_template(TPL_TOP.'/top.tpl.php',null);
}

function render_bottom_of_top($var) {
	return render_template(TPL_TOP.'/bottom.tpl.php',$var);
}
?>