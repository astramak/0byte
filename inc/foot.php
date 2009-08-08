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
echo render_template(TPL_BOTTOM."/top.tpl.php", null);
include("inc/right.php"); 
$cur=$_SERVER['REQUEST_URI'];
	$cur=str_replace("&","*amp",$cur);
	$cur=str_replace("?","*qw",$cur);
	$script->add("var cur = '$cur';");
        $loged=$loged?1:0;
$script->add("var loged=".$loged."; strt();");
echo render_template(TPL_BOTTOM.'/main.tpl.php', array('SCRIPT'=>$script->result(),'loged'=>$loged));
?>
