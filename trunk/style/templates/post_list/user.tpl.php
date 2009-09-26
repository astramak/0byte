<div id='btop'>
    <?php if ($avatar) { ?>
        <img  src='<?php echo $avatar_url; ?>' style='float:left;' alt='' />
    <?php } ?>
<span class='bnm'><a href='user/<?php echo $name; ?>/'><?php echo $name; ?></a></span><?php if (!$no_user_rate) { ?><span class='rate'>
    <noindex><a rel='nofollow' class='ratep' href='<?php echo $ratep_url; ?>'>+</a></noindex>
    <span id='ru<?php echo $name; ?>'>
        <?php if ($rate>0) { ?>
        <span class='rp'><?php echo $rate; ?></span>
        <?php } else if ($rate<0) {
        ?><span class='rm'><?php echo $rate; ?></span<?php
        } else echo 0;?>
</span><noindex><a rel='nofollow' class='ratem' href='<?php echo $ratem_url; ?>'>
        &ndash;</a></noindex></span><?php } ?></div>