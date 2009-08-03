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
 * Renders utils template
 *
 * @param string $name
 * @param array $variables
 * @return string
 */
function render_util($name, $variables) {
	return render_template(TPL_UTILS . '/' . $name . '.tpl.php', $variables);
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
 * @param array $tags
 * @return string
 */
function render_tags($tags) {
    return render_template(TPL_UTILS.'/tags.tpl.php', array("tags" => $tags));
}
/**
 * Render users and blogs top list
 *
 * @param array $users
 * @param array $blogs
 * @return string
 */
function render_tops($users,$blogs) {
    return render_template(TPL_UTILS.'/tops.tpl.php', array("users"=>$users, "blogs"=>$blogs));
}
/**
 * Render online and new users list
 *
 * @param array $online
 * @param array $new
 * @return string
 */
function render_online_and_new($online, $new) {
    return render_template(TPL_UTILS.'/online_new.tpl.php', array("online"=>$online, "new"=>$new));
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
/**
 * Render edit comment page
 *
 * @param numeric $id
 * @param string $text
 * @return string
 */
function render_edit_comment($id,$text) {
    return render_template(TPL_FRAMES.'/edit_comment.tpl.php',array('id'=>$id,'text'=>$text));
}
/**
 * Render posts
 *
 * @param array $array
 * @return string
 */
function render_post($array) {
    return render_template(TPL_FRAMES.'/post.tpl.php', $array);
}
/**
 * Render answer
 *
 * @param array $array
 * @param numeric $answered
 * @param numeric $id
 * @param numeric $loged
 * @param string $action
 * @return string
 */
function render_answer($array,$answered,$id=0,$loged=1,$action="") {
    return render_template(TPL_FRAMES.'/answer.tpl.php',
        array('elements'=>$array,'answered'=>$answered,'id'=>$id,'loged'=>$loged,'action'=>$action));
}
function render_edit_post($title,$blogs,$url,$type,$tags,$status,$text=null,$lnk=null,$draft=null) {
    return render_template(TPL_FRAMES.'/edit_post.tpl.php', array('title'=>$title,'blogs'=>$blogs,
        'url'=>$url,$type=>'1','text'=>$text,'tags'=>$tags,'lnk'=>$lnk,'status'=>$status,'draft'=>$draft));
}
function render_edit_user($array) {
    return render_template(TPL_FRAMES.'/edit_user.tpl.php', $array);
}
function render_myblog($array,$loged=1) {
    return render_template(TPL_FRAMES.'/myblog.tpl.php', array('blogs'=>$array,'loged'=>$loged));
}
function render_new_post($type,$type_,$tp,$blogs,$len=0) {
    return render_template(TPL_FRAMES.'/new_post.tpl.php', array('type'=>$type,$type_=>'1','tp'=>$tp,
        'blogs'=>$blogs,'len'=>$len));
}

function render_paginator($start,$count,$all_count,$current_num=0,$end=null) {
        $k=1;
        $pages=null;
        $prev=0;
        $prev_url=null;
        if ($current_num>=$count) {
        //	echo "<a class='nomnm' id='prev' href='".$inser."from/".($current_num-$count).$fnd."'>&#8592; </a>";
            $prev=1;
            $prev_url=$start."from/".($current_num-$count).$end;
            if ($current_num-$count==0) {
                $prev_url=$start.$end;
            }
        }
        $numb=0;
        while ($all_count>0 && $numb<10) {
                if (($k-1-$current_num/$count)<5 && ($k-1-$current_num/$count)>-5) {
                        if ($current_num==($k-1)*$count) {
        //			echo "<span class='nmn'>$k</span> ";
                                $current=1;
                        } else {
        //			echo ("<a class='nmn' href='".$inser."from/".(($k-1)*$count).$fnd."'>$k</a> ");
                                $current=0;
                        }
                        $numb++;
                        $url=$start."from/".(($k-1)*$count).$end;
                        if ($k-1==0) {
                            $url=$start.$end;
                        }
                        $pages[]=array('current'=>$current,'number'=>$numb,'url'=>$url);


                }
                $k++;
                $all_count-=$count;
        }
        $next=0;
        $next_url=null;
        if ($current_num<($k-2)*$count) {
        //	echo "<a class='nomnm' id='next' href='".$inser."from/".($current_num+$count).$fnd."'> &#8594;</a>";
            $next=1;
            $next_url=$start."from/".($current_num+$count).$end;
        }
        //echo "<br />";
        $wtch=0;
        $show_first=0;
        $first_url=null;
        if ($current_num>=5*$count) {
        //	echo "<a class='nomnm' href='".$inser."from/0".$fnd."'>&#8612; Начало</a>";
                $show_first=1;
                $first_url=$start.$end;
        //	$wtch=1;
        }
        $show_last=0;
        $last_url=null;
        if ($current_num<($k-6)*$count) {
        //	if ($wtch==1) {echo "||";}
                $show_last=1;
                $last_url=$start."from/".($k-2)*$count.$end;
        //        echo "<a class='nomnm' href='".$inser."from/".($k-2)*$count.$fnd."'>Конец &#8614; </a>";
        }
        return render_template(TPL_FRAMES.'/paginator.tpl.php',array('prev'=>$prev,'prev_url'=>$prev_url,
            'next'=>$next,'next_url'=>$next_url,'pages'=>$pages,'show_first'=>$show_first,'first_url'=>$first_url,
        'show_last'=>$show_last,'last_url'=>$last_url));
}
function render_error($text,$id=null) {
    return render_template(TPL_FRAMES.'/error.tpl.php', array('text'=>$text,'id'=>$id));
}
?>