<div class='bottom'>
    <?php if ($show_full && !$draft) { ?>
        <a class='full' href='post/<?php echo $id; ?>/'>Полностью...</a>
    <?php } ?>
<?php if (!$draft) { ?><span class='rate'><?php echo $comments; ?>
<noindex><a class='ratep' rel='nofollow' href='<?php echo $ratep_url; ?>'>+</a>
    </noindex><span id='rp<?php echo $id; ?>'>
        <?php if ($rate>0) {
            ?><span class='rp'><?php echo $rate;?></span><?php
        } else if ($rate<0) {
            ?><span class='rm'><?php echo $rate;?></span><?php
        } else echo 0; ?>
</span><noindex><a rel='nofollow' class='ratem' href='<?php echo $ratem_url; ?>'>&ndash;</a></noindex>
</span><?php } ?></div>