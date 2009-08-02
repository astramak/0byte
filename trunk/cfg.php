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
// define some constants
define('ROOT_PATH', dirname(__FILE__));
define('TPL_ROOT', ROOT_PATH . '/style/templates');
define('TPL_MAIL', TPL_ROOT . '/mail');
define('TPL_RSS', TPL_ROOT . '/rss');
define('TPL_UTILS', TPL_ROOT . '/utils');
define('TPL_FRAMES', TPL_ROOT . '/frames');
define('TPL_PM', TPL_ROOT . '/pm');
define('TPL_TOP',TPL_ROOT.'/top');
define('TPL_BOTTOM',TPL_ROOT.'/bottom');
define('TPL_POST_LIST',TPL_ROOT.'/post_list');
define('TPL_EDITOR',TPL_ROOT.'/editor');
define('TPL_MAIN', TPL_ROOT);

//lib load
include("lib/blog.inc");
include("lib/comment.inc");
include("lib/post.inc");
include("lib/menu.inc");
include("lib/seq.php");
include("lib/tag.inc");
include("lib/pm.inc");
include("lib/text.inc");
include("lib/user.inc");
include("lib/cache.inc");
//include("lib/geshi/geshi.php");
include("lib/flw.inc");
include("lib/json.inc");
include("lib/plugins.inc");
include("lib/script.inc");
require_once 'lib/request.class.php';
require_once 'lib/utils.php';
require_once 'lib/native_template.php';
require_once 'lib/db.inc';

//user cfg
include("config.php");

$db_connection = db_connect();
// depricated and should be removed after DB code update
$sql = $db_connection;

$pg = request::get_get('pg');

//if (!request::get_get('debug')) ini_set('display_errors', 0);

$usr = new user();
ini_set('display_errors', 1);
function crl($a) {
	if ($a==0) {
		echo '<b class="b1"></b><b class="b2"></b><b class="b3"></b><b class="b4"></b>';
	} else {
		echo '<b class="b4"></b><b class="b3"></b><b class="b2"></b><b class="b1"></b>';
	}
}
parse_plugin_array($use);
?>
