<div class="c{date user='<?php echo $comment->auth; ?>' time='<?php echo $comment->date; ?>'}n{/date}top">
    <img class='<?php echo $avatar_use ? ("cauth") : 'cnoauth';?>' src='<?php echo $avatar_use ? ("res.php?t=av&amp;img=".$avatar) : 'style/img/figure.gif';?>' alt="" />
    <a class='cauth' href='user/<?php echo $comment->auth; ?>'><?php echo $comment->auth; ?></a>
    <span class='date'>{time}<?php echo $comment->date; ?>{/time}</span>
    <a title='Ссылка на комментарий' class='clnk' href='post/<?php echo $pid; ?>/#cmnt<?php echo $comment->id;?>'>#</a>
    <?php if ($comment->lvl>0) {?>
    <a class='clnk' href='post/<?php echo $pid; ?>/#cmnt<?php echo $comment->cid; ?>' title='Уровнем выше'>&#8593;</a>
    <?php } ?>
    <span class='crate'>
        <noindex>
            <a rel='nofollow' class='ratep' href="<?php if ($js) echo "javascript:x_r('"; ?>twork.php?wt=ratecom&id=<?php echo $comment->id; ?>&rate=p&from=<?php echo $current; if ($js) echo "&json=1','c')";?>">+</a></noindex><span id='rc<?php echo $comment->id;?>'><span class='<?php
            if ($comment->rate()>0) {
                echo "rp";
            } elseif ($comment->rate()<0) {
                echo "rm";
            }
                  ?>'><?php echo $comment->rate(); ?></span></span><noindex><a rel='nofollow' class='ratem' href="<?php if ($js) echo "javascript:x_r('"; ?>twork.php?wt=ratecom&id=<?php echo $comment->id; ?>&rate=m&from=<?php echo $current; if ($js) echo "&json=1','c')";?>">&ndash;</a>
        </noindex>
    </span>
</div>
<div class='ctext' ><?php echo $comment->text; ?></div>
{loged}
<div class='cbottom'>
    <?php  if (!$allow_comment) {?>
	<a href='<?php if ($js) {?>
        javascript:doit("<?php echo $comment->id; ?>","<?php echo ($comment->lvl+1);?>")
            <?php } else {?>
        work/comment/<?php echo $comment->id."/".$comment->lvl."/".$current;
            }?>' class='om'><img src="style/n_img/comment_reply.gif"/>Ответить</a>
            <?php } ?>
    {allow_edit}
	<a href='work/editcom/<?php echo $comment->id;?>/' class='supragrey'><img src="style/n_img/pen_t.gif"/>Редактировать</a>
    {/allow_edit}{allow_delete}
	<a href='work/rmcom/<?php echo $comment->id; ?>/' class='supragrey'><img src="style/n_img/trash_t.gif"/>Удалить</a>
    {/allow_delete}
</div>
{/loged}
