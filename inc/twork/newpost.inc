<?php
if ($usr->rate()<$np_rate) {
    j_err("У вас недостаточно рейтинга для этого действия!");
    jkill();
    redirect($dir.'error/not_allow');
}
$title = htmlspecialchars(trim(request::get_post('title')));
$text = trim(request::get_post('text'));
$len = request::get_post('len');
$blog_id = request::get_post('blog');
$tp = request::get_get('tp');
$lnk = request::get_post('lnk');
$org = request::get_post('org');

if ($blog_id == 0) {
    $blog = "own";
} else {
    $blog = db_result(db_query('SELECT name FROM blogs WHERE id = %d', $blog_id));
}


$lock = request::get_post('lock') == 'on' ? 1 : 0;
$post_writed=1;
if (request::get_post('draft', '0')=='0' || request::get_post('nodraft','0')!='0') {
	 $draft = '';
     include 'inc/new_post.inc';
}
if ($post_writed==0 || (request::get_post('draft', '0')!='0' || request::get_post('nodraft','0')=='0')) {
    if ($tp==3) {
        for ($i = 0; $i < $len; $i++) {
            $text.=base64_encode(trim(request::get_post('an' . ($i + 1)))).' ';
        }
    }
    if (strlen($title)<1) $title='Безымянный черновик';
    $qr=db_query('INSERT INTO `draft` SET  `title` = %s, `auth` = %s, `text` = %s,
			 `blog` = %d, `tag` = %s, `lock` = %d, `tp` = %d ',
        $title, $usr->login, $text,
        $blog_id, request::get_post('tag'), $lock, $tp);
    $id = db_last_insert_id($qr);
} 
if ($post_writed==0 || (request::get_post('draft', 0)  || request::get_post('nodraft','0')=='0')) {
    redirect("draft/" . $id);
} else {
     if ($blog_id==0) {
        user_post_to_lenta($usr->login, $id, $time);
    } else {
        blog_post_to_lenta($blog, $id, $time);
    }
    redirect("post/".$id);
}
?>
