<?php
$time=time();
$tz = new dtxt();
$tz->cut(gtext($text));
$tag = tags_add_list(request::get_post('tag'));
switch ($tp) {
    case SIMPLE_POST: //if simple post
        if(!$title || !$text || strlen($title) < 2) { //check required fields
            $post_writed=0;  //post not writed -> to draft
            break;
        } else {
            $query=db_query('INSERT INTO `post` SET `date` = %s, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d ',
                $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
                $blog_id, $tag, $lock, $tp);
            $id=db_last_insert_id($query);
        }
        break;
    case LINK_POST: //if post type - link
        if (!$title || strlen($title) < 2 || !$lnk) { //check required fields
            $post_writed=0; //post not writed -> to draft
            break;
        } else {
            $query=db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s'.$draft,
                $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
                $blog_id, $tag, $lock, $tp, $lnk);
            $id=db_last_insert_id($query);
        }
        break;

    case TRANSLATION_POST: //if post type - translat
        if (!$title || strlen($title) < 2 || !$org || strlen($org)<2) { //check required fields
            $post_writed=0; //post not writed -> to draft
            break;
        }
        $query=db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s'.$draft,
            $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
            $blog_id, $tag, $lock, $tp, $org);
        $id=db_last_insert_id($query);
        break;

    case ANSWER_POST: //if post type - answer
        if (!$title || strlen($title) < 2 || !$len || $len<2) { //check required fields
            $post_writed=0; //post not writed -> to draft
            break;
        }
        $nm = request::get_post('mng') == 'on' ? 1 : 0;
        $query=db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
                            `ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s',
            $time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
            $blog_id, $tag, $lock, $tp, $nm);

     $id=db_last_insert_id($query); 
    
            for ($i = 0; $i < $len; $i++) {
                $question = trim(request::get_post('an' . ($i+1)));

                if ($question) {
                    db_query('INSERT INTO `answ` SET `title` = %s, `cid` = %d', $question, $id);
                }
        } 
        break;
}
?>
