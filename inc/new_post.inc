<?php
$time=time();
$tz = new dtxt();
$tz->cut(gtext($text));
$tag = tags_add_list(request::get_post('tag'));
switch ($tp) {
    case 0:
        if(!$title || !$text || strlen($title) < 2) {
            $post_writed=0;
        } else {
            db_query('INSERT INTO `post` SET `date` = %s, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d ',
                $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
                $blog_id, $tag, $lock, $tp);
        }
        break;

    case 1:
        if (!$title || strlen($title) < 2 || !$lnk) {
            $post_writed=0;
        } else {
            db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s'.$draft,
                $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
                $blog_id, $tag, $lock, $tp, $lnk);
        }
        break;

    case 2:
        if (!$title || strlen($title) < 2 || !$org) {
            $post_writed=0;
        }
        db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s'.$draft,
            $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
            $blog_id, $tag, $lock, $tp, $org);
        break;

    case 3:
        if (!$title || strlen($title) < 2 || !$len || $len<2) {
            $post_writed=0;
        }
        $nm = request::get_post('mng') == 'on' ? 1 : 0;
        db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s'.$draft,
            $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
            $blog_id, $tag, $lock, $tp, $nm);
     
        if (!request::get_post('draft', 0) || request::get_post('write',0)) {
            for ($i = 0; $i < $len; $i++) {
                $question = trim(request::get_post('an' . ($i + 1)));
                if ($question) {
                    db_query('INSERT INTO `answ` SET `title` = %s, `cid` = %d', $question, $id);
                }
            }
        }
        break;
}

?>
