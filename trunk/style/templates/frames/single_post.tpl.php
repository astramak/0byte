<br/><hr/>
<div class='bottom'>
    <?php if ($loged) { if ($allow_edit) { ?>
       <a href="work/editpost/<?php echo $id; ?>" class='scb'><img src="style/n_img/pen.gif"/>Править</a>  
    <?php }
    if ($allow_remove) { ?>
        <a href='<?php echo $block_url; ?>' class='scb'><img src="style/n_img/symbol_no.gif"/>Блокировки</a> 
        <a href='<?php echo $remove_url; ?>' class='scb'><img src="style/n_img/trash.gif"/>Удалить</a> 
    <?php }
    if ($allow_hold) {
        ?><a href="work/hold/<?php echo $id; ?>" class='scb'><img src="style/n_img/pound.gif"/><?php if (!$hold) echo 'За'; else echo 'От';?>крепить</a><?php
    }
    if ($allow_spy) {?>
        <a id='sled' class='scb' href='<?php echo $spy_url; ?>'><img src="style/n_img/eye.gif"/><?php if ($spyed) {
            echo "Перестать о";
        } else {
            echo "О";
        }
        ?>тслеживать</a> 
    <?php } ?>
    <a id="favor" class='scb' href="<?php echo $favourite_url; ?>"><img src="style/n_img/fav.gif"/><?php if (!$favourite) { ?>В избранное<?php } else { ?>Из избранного<?php } ?></a> <?php } ?>
	<img src="style/n_img/base.gif"/><a href="like/<?php echo $id; ?>" class='scb'>Похожие</a>
<span class='rate'><a class='ratep' href='<?php echo $ratep_url; ?>'>+</a><span id='rp<?php echo $id; ?>'><?php
    if ($rate>0) {
        ?><span class='rp' title="Всего <?php echo $rate_num;?> <?php
            echo inducing($rate_num, array('голоса','голосов','голос'));
            ?>"><?php echo $rate;?></span><?php
    } else if ($rate<0) {
        ?><span class='rm' title="Всего <?php echo $rate_num;?> <?php
            echo inducing($rate_num, array('голоса','голосов','голос'));
            ?>"><?php echo $rate;?></span><?php
    } else {
        ?><span title="Всего <?php echo $rate_num;?> <?php
            echo inducing($rate_num, array('голоса','голосов','голос'));
            ?>">0</span><?php
    }?></span><a class='ratem' href='<?php echo $ratem_url; ?>'>&ndash;</a>
</span></div>
    <?php if ($tags) { ?>
<div class='tags'><span class='grey'>Теги:</span> 
    <?php } ?>
    <?php if ($tags) foreach ($tags as $tag)  { ?>
        <a href='tag/<?php echo $tag; ?>' rel='tag'><?php echo $tag; ?></a>
    <?php } ?>
</div><hr/>