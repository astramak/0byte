<div id="main">
<?php if ($yes) {?>
<div id='btop'>
    <?php if ($avatar) { ?>
        <img src='<?php echo $avatar_url; ?>' style='float:left;' alt='<?php echo $name; ?>' />
        <?php } ?>
        <span class='bnm'><a href='user/<?php echo $name; ?>'><?php echo $name; ?></a></span>
        <span class='rate'>
            <a class='ratep' href='<?php echo $ratep_url; ?>'>+</a>
            <?php if ($rate>0) { ?>
                <span class='rp'><?php echo $rate;?></span>
            <?php } else if ($rate <0) {?>
                <span class='rm'><?php echo $rate;?></span>
            <?php } else { ?>
                <?php echo $rate;?>
            <?php } ?>
            <a class='ratem' href='<?php echo $ratem_url; ?>'>&ndash;</a>
        </span>
</div>
 <?php foreach ($comments as $comment) {
    include('comment2.tpl.php');
 } ?>
<?php } else {?>
<br/>Положите начало беседе :)<br/>
<?php } ?>
</div>
