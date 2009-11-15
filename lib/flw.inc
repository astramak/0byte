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
function fladd($list,$user) {
    if (strpos($list,$user)===false) {
        if (strlen($list)>0) {
            $list.=$user.", ";
        } else {
            $list=$user.", ";
        }
    }
    return($list);
}

function flrm($list,$user) {
    return (str_replace($user.", ","",$list));
}

function flsnd($list,$usr,$pid,$comid,$text,$title) {
    global $eml,$site,$sl_name,$notify,$notify_plugins;
    $arr=split(",",$list);
    $q=sizeof($arr);
    for ($z=0; $z<$q; $z++) {
        $name = trim($arr[$z]);
        if ($name != $usr) {
        // TOFIX: why do we need to delete record and then add the same record?
            add_eye($pid, $name, time());
//            db_query('DELETE FROM eye WHERE pid = %d AND who = %s LIMIT 1', $pid,$name);
//            db_query('INSERT INTO eye SET who = %s, pid = %d', $name, $pid);
            comment_to_lenta($name, $comid);
            $row = db_fetch_assoc(db_query('SELECT `mail`,`jabber` FROM `users` WHERE name = %s', $name));
            $subject = "Ответ на отслеживаемый вами пост на ".$sl_name;
            $message = render_mail('observe_reply', array(
                'user' => $usr,
                'pid' => $pid,
                'comid' => $comid,
                'text' => gtext($text),
                'title' => $title
            ));
            $headers = array('From: reply'.$eml, 'Reply-To: reply'.$eml);
            nullbyte_mail($row['to'], $subject, $message, true, $headers);
            if (@count($notify_plugins)>0) {
                $notify[]=array('to'=>$row['jabber'],'msg'=>$message);
            }
        }
    }
}

/**
 * Re-new status of post in eye-spy list
 * 
 * @param int $id post id
 * @param string $author follower
 */
function add_eye($id,$author) {
    db_query("DELETE FROM `eye` WHERE `pid`= %d && `who` = %s LIMIT 1",$id,$author);
    db_query("INSERT INTO `eye` ( `who` ,`pid`) VALUES ( %s , %d )",$author,$id);
}
/**
 * Add elemnt to lenta list
 *
 * @param string $who
 * @param int $id
 * @param int $type type of element: 0 -comment, 1 - post
 * @param timestamp $date
 */
function to_lenta($who,$id,$type,$date) {
    db_query("DELETE FROM `lenta` WHERE `uid`= %d && `who` = %s && `type` = %d && `date` = %s LIMIT 1",$id,$who,$type,$date);
    db_query("INSERT INTO `lenta` ( `uid`, `type`, `date`, `who`) VALUES (%d, %d, %s, %s )",$id,$type,$date,$who);
//   printf("INSERT INTO `lenta` ( `uid`, `type`, `date`, `who`) VALUES (%d, %d, %s, %s )",$id,$type,$date,$who);
}
/**
 * Add comment to lenta list
 *
 * @param string $who follower
 * @param int $id comment id
 * @param timestamp $date posting date
 */
function comment_to_lenta($who,$id,$date) {
    to_lenta($who, $id, 0,$date);
}
/**
 * Add user post to lenta list
 *
 * @param string $who follower
 * @param int $id post id
 * @param timestamp $date posting date
 */
function user_post_to_lenta($who,$id,$date) {
    to_lenta($who, $id, 2,$date);
}
/**
 * Add blog post to lenta list
 *
 * @param string $blog blog
 * @param int $id post id
 * @param timestamp $date posting date
 */
function blog_post_to_lenta($blog,$id,$date) {
    to_lenta($blog, $id, 1,$date);
}
/**
 * Delete post from lenta list
 * 
 * @param int $id post id
 */
function delete_post_from_lenta($id) {
    db_query('DELETE FROM `lenta` WHERE `uid` = %d && `type` != 0 LIMIT 1',$id);
}
?>