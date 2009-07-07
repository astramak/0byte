<div id='btop'>
    <?php if ($avatar) { ?>
        <img style='float:left' src='<?php echo $avatar_url; ?>' alt='' />
    <?php } ?>
<div class='bbnm'><span class='bnm'><?php echo $name; ?></span><br /><?php echo $about; ?>
</div><span class='rate'>
    <?php if ($in_blog && $owner) { ?>
        <a id='ibl' href='<?php echo $inblog_url; ?>'>Вступить!</a>
    <?php }  else if ($owner) { ?>
        <a id='obl' href='<?php echo $inblog_url; ?>'>Выйти!</a>
    <?php } ?>
<noindex><a class='ratep' rel='nofollow' href='<?php echo $ratep_url;?>'>+</a></noindex>
<span id='rb<?php echo $id;?>'>
    <?php if ($rate>0) {
        ?><span class='rp'><?php echo $rate; ?></span><?php
    } else if ($rate<0) {
        ?><span class='rm'><?php echo $rate; ?></span><?php
    } else echo 0;
    ?>
</span>
<noindex><a class='ratem'  rel='nofollow' href='<?php echo $ratem_url; ?>'>&ndash;</a></noindex>
</span></div>
