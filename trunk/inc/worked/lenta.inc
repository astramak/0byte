<?php
 $frnd = db_result(db_query('SELECT `frnd` FROM `users` WHERE `name` = %s', $usr->login));
 $where="1 = 0";
            if ($frnd) {
                $arr = explode(',', $frnd);
                trim_array($arr, '_db_escape_string');
                if ($arr) $where = '`lenta`.`who` IN (' . implode(',', $arr) . ')'; 
            }
$result=db_query("SELECT `lenta`.*,`inblog`.`bname` FROM `post`,`lenta`,`inblog`
WHERE (`lenta`.`who` = %s && `lenta`.`type` = 0) ||
(`lenta`.`who`= `inblog`.`bname` && `lenta`.`type`= 1 && `inblog`.`name` = %s && `inblog`.`out` = 0 && `post`.`id`=`lenta`.`uid` && `post`.`auth`!= %s) ||
(`lenta`.`type` = 2 && ".$where." ) GROUP BY `lenta`.`id`
 ORDER BY `date` DESC  ",$usr->login,$usr->login,$usr->login);
//'SELECT `blogid` FROM `inblog` WHERE `name` = %s && `out` = 0 ORDER BY id DESC'
$com=new comment;
while ($row=db_fetch_assoc($result)) {
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
        echo render_template(TPL_FRAMES.'/comment2.tpl.php', array('comment'=>array('blog'=>$blog,'blog_url'=>$blog_url,'date'=>date('d.m.y H:i',$com->date),'text'=>code($com->text),
                "rate"=>$com->rate(),'post_title'=>$com_arr['title'],'url'=>'post/'.$com_arr['krnl'].'/', 'full_url' => 'post/'.$com_arr['id'].'/#cmnt'.$com->id)
            ,'avatar'=>db_result(db_query('SELECT `av` FROM `users` WHERE `name` = %s',$com_arr['auth']))));
    } else {
        $post=db_fetch_assoc(db_query("SELECT * FROM `post` WHERE `id`=%d",$row['uid']));
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
?>
