<?php
$post_id = request::get_get('post');
$blog_id = request::get_post('blog');
$title = request::get_post('title');
$text = request::get_post('text');
$lnk = request::get_post('lnk');

if ($blog_id) {
    $blog = db_result(db_query('SELECT name FROM blogs WHERE id = %d', $blog_id));
} else {
    $blog = "own";
}
$lock = request::get_post('lock') == 'on' ? 1 : 0;
if (request::get_post('draft', 0)) {
    $tp= db_result(db_query('SELECT tp FROM draft WHERE id = %d && auth = %s', $post_id, $usr->login));
    if ($tp!=0) {
        if (request::get_post('write',0)) {
           db_query(' DELETE FROM `draft` WHERE `id` = %d LIMIT 1',$post_id);
           $len=request::get_post('len');
           include 'inc/new_post.inc';
           redirect("post/" . $id);
        } else {
            if ($tp==3) {
                $text=null;
                for ($i = 0; $i < request::get_post('len'); $i++) {
                    $text.=base64_encode(trim(request::get_post('an' . ($i + 1)))).' ';
                }
                $lnk = request::get_post('mng') == 'on' ? 1 : 0;
            }
            db_query('UPDATE draft SET title = %s, text = %s,  `lock` = %d, blog = %d, tag = %s, lnk = %s WHERE id = %d && auth = %s LIMIT 1',
                $title, $text, $lock, $blog,request::get_post('tag'), $lnk, $post_id, $usr->login);
            redirect("draft/" . $post_id);
        }
    }
} else {
    $row= db_fetch_assoc(db_query('SELECT * FROM post WHERE id = %d', $post_id));
    if (($usr->lvl > $elvl || $usr->login == $row['auth']) && (($title && $text) || $row['tp'] == 3)) {


        $tag = tags_add_list(request::get_post('tag'));
        tags_remove_list($row['tag']);

        if ($row['tp'] == 3) {
            db_query('UPDATE post SET `lock` = %d, tag = %s, blog = %s, blogid = %d, lnk = %s WHERE id = %d',
                $lock, $tag, $blog, $blog_id, $lnk, $post_id);
        } else {
            $tz = new dtxt();
            $tz->cut($text);

            db_query('UPDATE post SET title = %s, text = %s, ftext = %s, `lock` = %d, blog = %s, blogid = %d, tag = %s, lnk = %s  WHERE id = %d',
                $title, $tz->short_text, $tz->full_text, $lock, $blog, $blog_id, $tag, $lnk, $post_id);
        }
        redirect("post/" . $post_id);
    } else {
        redirect('index.php');
    }
}
?>