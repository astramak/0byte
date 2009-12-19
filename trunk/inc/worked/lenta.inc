<?php
if (!($out = readCache('lenta_'.$usr->login.'_'.$frm.'.cache', CACHE_TIME_LIMIT))) {
    ob_start();

    $frnd = db_result(db_query('SELECT `frnd` FROM `users` WHERE `name` = %s', $usr->login));
    $where="1 = 0";
    $frm=request::get_get('frm',0);
    if ($frnd) {
        $arr = explode(',', $frnd);
        trim_array($arr, '_db_escape_string');
        if ($arr) $where = '`_lenta`.`who` IN (' . implode(',', $arr) . ')';

    }
    $result=db_query('SELECT * FROM (SELECT * FROM `lenta` WHERE `lenta`.`date` > %d ) as `_lenta`,
    (SELECT `post`.`id`,`post`.`auth` FROM `post` WHERE `post`.`date` > %d && `post`.`auth` != %s) as `_post`,
    (SELECT `inblog`.`name`,`inblog`.`bname` FROM `inblog` WHERE `inblog`.`out` = 0 && `inblog`.`name` = %s ) as `_inblog`
    WHERE (`_lenta`.`who` = %s && `_lenta`.`type` = 0) ||
    (`_lenta`.`who` = `_inblog`.`bname` && `_lenta`.`type` = 1  && `_post`.`id`=`_lenta`.`uid`) ||
    (`_lenta`.`type` = 2 && '.$where.' ) GROUP BY `_lenta`.`id` ORDER BY `_lenta`.`date` DESC  LIMIT %d , %d',
            time()-7*24*60*60, time()-7*24*60*60, $usr->login, $usr->login, $usr->login, $frm, 20);
    $com=new comment;
    while ($row=db_fetch_assoc($result)) {
        //    echo $row['type'];
        if ($row['type']==0) {

            $com_arr=db_fetch_assoc(db_query("SELECT `comment`.*,`post`.`blogid`,`post`.`blog`,`post`.`auth`,`post`.`title`
 FROM `post`,`comment` WHERE `comment`.`krnl`=`post`.`id` && `comment`.`id` = %d ",$row['uid']));
            $com->make($com_arr);
            if ($com_arr['blogid']) {
                $blog=$com_arr['blog'];
                $blog_url='blog/'.$com_arr['blogid'];
            } else {
                $blog=$com_arr['auth'];
                $blog_url='user/'.$com_arr['auth'];
            }
            if (strlen($com->name)>1) {
                echo render_template(TPL_FRAMES.'/comment2.tpl.php', array('name'=>$com_arr['who'],'comment'=>array('blog'=>$blog,'blog_url'=>$blog_url,'date'=>date('d.m.y H:i',$com->date),'text'=>code($com->text),
                        "rate"=>$com->rate(),'post_title'=>$com_arr['title'],'url'=>'post/'.$com_arr['krnl'].'/', 'full_url' => 'post/'.$com_arr['krnl'].'/#cmnt'.$com->id)
                ,'avatar'=>db_result(db_query('SELECT `av` FROM `users` WHERE `name` = %s',$com_arr['who']))));
            }
        } else {
            $post=db_fetch_assoc(db_query("SELECT * FROM `post` WHERE `id`=%d",$row['uid']));
            if (strlen($post['auth'])>1) {
                $post=post_echo($post,0);

                if ($post->tp==1 || ($post->tp!=3 && $post->havecut()==1)) {
                    $full=1;
                } else {
                    $full=0;
                }
                echo render_template(TPL_POST_LIST.'/bottom.tpl.php', array('show_full'=>$full,
                'id'=>$post->id,'comments'=>klist($post->id),
                'ratep_url'=>"twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=p&amp;from=".$cur,
                'ratem_url'=>"twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=m&amp;from=".$cur,
                'rate'=>$post->rate(),'draft'=>0,'rate_num'=>($post->ratep+$post->ratem)%100));
            }
        }

    }

    echo render_paginator('lenta/', 20,
    $new=db_result(db_query("SELECT (`l`.`cn`+`p`.`cn`) as `cnt` FROM (SELECT COUNT(`id`) as `cn` FROM`lenta` WHERE `lenta`.`date` > %d &&
`lenta`.`who`=%s && `lenta`.`type`= 0 ) as `l`, (SELECT COUNT(`id`) as `cn` FROM `post`
 WHERE `date` > %d && `blck` = 0 && `auth` != %s && ".get_special().") as `p`"
    ,time()-7*24*60*60,$usr->login,time()-7*24*60*60,$usr->login))
    , $frm);
    $out=ob_get_clean();
    writeCache($out,'lenta_'.$usr->login.'_'.$frm.'.cache');
}
echo $out;
?>
