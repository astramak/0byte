<div class='bottom'>
    <?php if ($loged) { if ($allow_edit) { ?>
        (<a  href="work/editpost/<?php echo $id; ?>">Править</a>)
    <?php }
    if ($allow_remove) { ?>
        (<a  href='<?php echo $block_url; ?>'><?php if ($blocked) { echo "За"; } else { echo "Раз"; } ?>блокировать</a>)
        (<a href='<?php echo $remove_url; ?>'>Удалить</a>)
    <?php }
    if ($allow_spy) {?>
        (<a id='sled' href='<?php echo $spy_url; ?>'><?php if ($spyed) {
            echo "Перестать о";
        } else {
            echo "О";
        }
        ?>тслеживать</a>)
    <?php } ?>
    (<a id="favor" href="<?php echo $favourite_url; ?>"><?php if (!$favourite) { ?>В избранное<?php } else { ?>Из избранного<?php } ?></a>) <?php } ?>
    (<a href="like/<?php echo $id; ?>">Похожие</a>)
<span class='rate'><a class='ratep' href='<?php echo $ratep_url; ?>'>+</a>
    <span id='rp<?php echo $id; ?>'><?php
    if ($rate>0) {
        ?><span class='rp' title="Всего <?php echo $rate_num;?> голос<?php
            if (($rate_num>1 && $rate_num<=3) || ($rate_num>20 && $rate_num%10>1 && $rate_num%10<=3) ) { echo 'а'; }
            else if (($rate_num<20 && $rate_num!=1) || ($rate_num>20 && $rate_num%10!=1)) { echo 'ов'; }
            ?>"><?php echo $rate;?></span><?php
    } else if ($rate<0) {
        ?><span class='rm' title="Всего <?php echo $rate_num;?> голос<?php
            if (($rate_num>1 && $rate_num<=3) || ($rate_num>20 && $rate_num%10>1 && $rate_num%10<=3) ) { echo 'а'; }
            else if (($rate_num<20 && $rate_num!=1) || ($rate_num>20 && $rate_num%10!=1)) { echo 'ов'; }
            ?>"><?php echo $rate;?></span><?php
    } else {
        ?><span title="Всего <?php echo $rate_num;?> голос<?php
            if (($rate_num>1 && $rate_num<=3) || ($rate_num>20 && $rate_num%10>1 && $rate_num%10<=3) ) { echo 'а'; }
            else if (($rate_num<20 && $rate_num!=1) || ($rate_num>20 && $rate_num%10!=1)) { echo 'ов'; }
            ?>">0</span><?php
    }?></span>
    <a class='ratem' href='<?php echo $ratem_url; ?>'>&ndash;</a>
</span></div>
<div class='tags'>
    <?php if ($tags) foreach ($tags as $tag)  { ?>
        <a href='tag/<?php echo $tag; ?>' rel='tag'><?php echo $tag; ?></a>
    <?php } ?>
</div>