<?php
$time=time();
$tz = new dtxt();
$tz->cut(gtext($text));
   $tag = tags_add_list(request::get_post('tag'));
    switch ($tp) {
            case 0:
                    db_query('INSERT INTO `post` SET `date` = %s, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d ',
                            $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
                            $blog_id, $tag, $lock, $tp);
                    break;

            case 1:
                    if (!$lnk) {
                            redirect('index.php');
                    }
                    db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s'.$draft,
                            $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
                            $blog_id, $tag, $lock, $tp, $lnk);
                    break;

            case 2:
                    if ($org) {
                            redirect('index.php');
                    }
                    db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s'.$draft,
                            $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
                            $blog_id, $tag, $lock, $tp, $org);
                    break;

            case 3:
                    if (!$len) {
                            redirect('index.php');
                    }
                    $nm = request::get_post('mng') == 'on' ? 1 : 0;
                    db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s'.$draft,
                            $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
                            $blog_id, $tag, $lock, $tp, $nm);
                    break;
    }
    $id = db_last_insert_id('post');
    if ($tp == 3 && (!request::get_post('draft', 0) || request::get_post('write',0))) {
            for ($i = 0; $i < $len; $i++) {
                    $question = trim(request::get_post('an' . ($i + 1)));
                    if ($question) {
                            db_query('INSERT INTO `answ` SET `title` = %s, `cid` = %d', $question, $id);
                    }
            }
    }
?>
