<div id='list'>
    <?php if ($prev) {?>
        <a class='nomnm' id='prev' href='<?php echo $prev_url; ?>'>&#8592; </a>
    <?php }
    foreach ($pages as $page) {
        if ($page['current']) {?>
             <span class='nmn'><?php echo $page['number']; ?></span>
         <?php } else { ?>
             <a class='nmn' href='<?php echo $page['url']; ?>'><?php echo $page['number']; ?></a>
             <?php }
         }
         if ($next) { ?>
            <a class='nomnm' id='next' href='<?php echo $next_url; ?>'> &#8594;</a>
         <?php } ?>
            <br />
            <?php if ($show_first) { ?>
                <a class='nomnm' href='<?php echo $first_url;?>'>&#8612; Начало</a>
            <?php } if ($show_last) { ?>
                 <a class='nomnm' href='<?php echo $last_url; ?>'>Конец &#8614; </a>
            <?php } ?>
</div>