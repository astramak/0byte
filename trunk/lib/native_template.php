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
/**
 * Render menu
 *
 * @param array $menu_arr
 * @param numeric $count
 * @return string
 */
function render_menu($menu_arr,$count) {
	$vars = array('elements'=>$menu_arr,
	'count'=>$count);
	return render_template(TPL_TOP.'/menu.tpl.php',$vars);
}
/**
 * Render top of the page
 *
 * @return string
 */
function render_top() {
	return render_template(TPL_TOP.'/top.tpl.php',null);
}
/**
 * Render bottom of the top
 * 
 * @param array $var
 * @return string 
 */

function render_bottom_of_top($var) {
	return render_template(TPL_TOP.'/bottom.tpl.php',$var);
}

/**
 * Render hands free panel
 *
 * @global numeric $loged
 * @param array $elements_arr
 * @param numeric $size
 * @return string
 */
function render_hands_free($elements_arr,$size) {
    global $loged;
    $vars=array('elements'=>$elements_arr,'size'=>$size,'loged'=>$loged);
    return render_template(TPL_UTILS.'/hands_free.tpl.php',$vars);
}
/**
 * Render search panel
 *
 * @return string
 */
function render_search_panel() {
    return render_template(TPL_UTILS.'/search_panel.tpl.php',null);
}
/**
 * Render registration page
 *
 * @param array $array
 * @return string
 */
function render_register_page($array) {
    return render_template(TPL_FRAMES.'/register.tpl.php', $array);
}
/**
 * Render login page
 *
 * @param numeric $login
 * @param string $current
 * @param numeric $js
 * @param numeric $new
 * @return string
 */
function render_login($login,$current,$js,$new) {
    return render_template(TPL_FRAMES.'/login.tpl.php',array('login'=>$login,'current'=>$current,'js'=>$js,'new'=>$new));
}
/**
 * Render comment output
 *
 * @param class_com $com
 * @param numeric $avatar_use
 * @param numeric $allow_edit
 * @param numeric $allow_delete
 * @param string $cur
 * @param numeric $loged
 * @param numeric $pid
 * @param numeric $js
 * @return string
 */
function render_comment($com,$avatar_use,$allow_edit,$allow_delete,$cur,$loged,$pid,$js) {
    $vars=array("comment"=>$com,"avatar_use"=>$avatar_use,"allow_edit"=>$allow_edit,
"allow_delete"=>$allow_delete,"current"=>$cur,"loged"=>$loged,"pid"=>$pid,"js"=>$js);
    return render_template(TPL_FRAMES.'/comment.tpl.php', $vars);
}
/**
 * Render tags
 *
 * @param array $array
 * @param numeric $num
 * @return string
 */
function render_tags($array,$num) {
    return render_template(TPL_UTILS.'/tags.tpl.php',array("elements" => $array, "count" => $num));
}
/**
 * Render users and blogs top list
 *
 * @param array $users
 * @param array $blogs
 * @return string
 */
function render_tops($users,$blogs) {
    return render_template(TPL_UTILS.'/tops.tpl.php', array("users"=>$users,"blogs"=>$blogs));
}
/**
 * Render online and new users list
 *
 * @param array $online
 * @param numeric $online_count
 * @param array $new
 * @return string
 */
function render_online_and_new($online,$online_count,$new) {
    return render_template(TPL_UTILS.'/online_new.tpl.php', array("online"=>$online,"count"=>$online_count,"new"=>$new));
}
/**
 * Render comment creation page
 *
 * @param string $old_comment
 * @param numeric $lvl
 * @param string $current
 * @param numeric $id
 * @return string
 */
function render_new_comment($old_comment,$lvl,$current,$id) {
    return render_template(TPL_FRAMES.'/new_comment.tpl.php',
    array("comment"=>$old_comment,"lvl"=>$lvl,"current"=>$current,"id"=>$id));
}
/**
 * Render change password page
 * 
 * @param string $login
 * @return string 
 */
function render_change_password($login) {
    return render_template(TPL_FRAMES.'/change_password.tpl.php', array("login"=>$login));
}

function render_edit_comment($id,$text) {
    return render_template(TPL_FRAMES.'/edit_comment.tpl.php',array('id'=>$id,'text'=>$text));
}
?>