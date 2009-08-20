<?php
    $blck=db_result(db_query("SELECT `blck` FROM `post` WHERE `id` = %d",request::get_get('id')));
    $block=$blck%10==1;
    $blck=($blck-$block)/10;
    $rate=$blck%10==1;
    $blck=($blck-$rate)/10;
    $comment=$blck%10==1;
    $content=render_template(TPL_FRAMES.'/block_post.tpl.php', array('block'=>$block,'rate'=>$rate,'comment'=>$comment,'id'=>request::get_get('id'),'json'=>@$json?1:0));
    if ($json) {
        $out['content']=$content;
    } else {
        echo $content;
    }
?>