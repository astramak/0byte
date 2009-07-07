<div class='bottom'>
    <?php if ($allow_edit) { ?>
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
<span class='rate'><a class='ratep' href='<?php echo $ratep_url; ?>'>+</a>
    <span id='rp<?php echo $id; ?>'><?php
    if ($rate>0) {
        ?><span class='rp'><?php echo $rate;?></span><?php
    } else if ($rate<0) {
        ?><span class='rm'><?php echo $rate;?></span><?php
    } else {
        ?>0<?php
    }?></span>
    <a class='ratem' href='<?php echo $ratem_url; ?>'>&ndash;</a>
</span></div>
<div class='tags'>
    <?php foreach ($tags as $tag)  { ?>
        <a href='tag/<?php echo $tag; ?>' rel='tag'><?php echo $tag; ?></a>
    <?php } ?>
</div>