<?php
include ("cfg.php");
include ("inc/head.php");
include("inc/top.php");

$who = request::get_get('who');
if (!$who) {

} else {
    $alien=new user;
    $alien->find($who);
    $avatar=0;
    $name=$alien->login;
    $avatar_url=null;
    $count=20;
    if (strlen($alien->av)> 2 ) {
        $avatar=1;
        $avatar_url="res.php?t=av&img=".$alien->av;
    }
    $rate=$alien->rate();
    $frm=request::get_get('frm',0);
    $all_count=db_result(db_query('SELECT COUNT(id) FROM comment WHERE who = %s ORDER BY id DESC',$who));
    $result = db_query('SELECT * FROM comment WHERE who = %s ORDER BY id DESC LIMIT %d, %d', $who,$frm,$count);
    if (!$all_count) {
        echo render_template(TPL_FRAMES.'/comment_list.tpl.php',array(
        'avatar'=>$avatar,'avatar_url'=>$avatar_url,'name'=>$name,'rate'=>$rate,'yes'=>0));
    } else {
        while($row = db_fetch_assoc($result)) {
            $com = new comment($row);

            $post = db_fetch_assoc(db_query('SELECT * FROM post WHERE id = %d', $row['krnl']));
            if ($post['blogid']) {
                $blog=$post['blog'];
                $blog_url='blog/'.$post['blogid'];
            } else {
                $blog=$post['auth'];
                $blog_url='user/'.$post['auth'];
            }
            $comments[]=array('blog'=>$blog,'blog_url'=>$blog_url,'date'=>date('d.m.y H:i',$com->date),'text'=>code($com->text),
                "rate"=>$com->rate(),'post_title'=>$post['title']);
        }
        echo render_template(TPL_FRAMES.'/comment_list.tpl.php',array('comments'=>$comments,
        'avatar'=>$avatar,'avatar_url'=>$avatar_url,'name'=>$name,'rate'=>$rate,'yes'=>1));
    }

}
echo render_paginator('comment/'.$alien->login.'/', $count,$all_count, $frm);
include("inc/foot.php");
?>