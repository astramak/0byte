<div class='bottom'>
    <?php if ($show_full && !$draft) { ?>
        <a class='full' href='post/<?php echo $id; ?>/'>Полностью...</a>
    <?php } ?>
<?php if (!$draft) { ?><span class='rate'><?php echo $comments; ?>
<noindex><a class='ratep' rel='nofollow' href='<?php echo $ratep_url; ?>'>+</a>
    </noindex><span id='rp<?php echo $id; ?>'>
        <?php if ($rate>0) {
            ?><span class='rp' title="Всего <?php echo $rate_num;?> голос<?php
            if (($rate_num>1 && $rate_num<=3) || ($rate_num>20 && $rate_num%10>1 && $rate_num%10<=3) ) { echo 'а'; }
            else if (($rate_num<20 && $rate_num!=1) || ($rate_num>20 && $rate_num%10!=1)) { echo 'ов'; }
            ?>"><?php echo $rate;?></span><?php
        } else if ($rate<0) {
            ?><span class='rm' title="Всего <?php echo $rate_num;?> голос<?php 
            if (($rate_num>1 && $rate_num<=3) || ($rate_num>20 && $rate_num%10>1 && $rate_num%10<=3) ) { echo 'а'; }
            else if (($rate_num<20 && $rate_num!=1) || ($rate_num>20 && $rate_num%10!=1)) { echo 'ов'; }
            ?>"><?php echo $rate;?></span><?php
        } else { ?><span title="Всего <?php echo $rate_num;?> голос<?php
            if (($rate_num>1 && $rate_num<=3) || ($rate_num>20 && $rate_num%10>1 && $rate_num%10<=3) ) { echo 'а'; }
            else if (($rate_num<20 && $rate_num!=1) || ($rate_num>20 && $rate_num%10!=1)) { echo 'ов'; }
            ?>">0</span><?php } ?>
</span><noindex><a rel='nofollow' class='ratem' href='<?php echo $ratem_url; ?>'>&ndash;</a></noindex>
</span><?php } ?></div>