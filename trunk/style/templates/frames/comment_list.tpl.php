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
 <?php foreach ($comments as $comment) { ?>
     <div class='ctop'>
         <?php if ($avatar) { ?>
            <img class='cauth' src='<?php echo $avatar_url; ?>' style='float:left;' alt='' />
         <?php } else { ?>
            <img class='cnoauth' src='style/img/figure.gif' alt="" />
         <?php } ?>
            <span class='date'><?php echo $comment['date']; ?></span>
      <span class='cauth'>&nbsp;<a href='<?php echo $comment['blog_url']; ?>'><?php echo $comment['blog']; ?></a>  &#8212;  
              <a href='<?php echo $comment['url']; ?>'><?php echo $comment['post_title']; ?></a></span>
            <span class='crate rateonly'>
             <?php if ($comment['rate']>0) { ?>
                <span class='rp'><?php echo $comment['rate'];?></span>
            <?php } else if ($comment['rate']<0) {?>
                <span class='rm'><?php echo $comment['rate'];?></span>
            <?php } else { ?>
                <?php echo $comment['rate'];?>
            <?php } ?>
           </span>
     </div>
<div class='ctext'><?php echo $comment['text']; ?></div>
<?php } ?>
<?php } else {?>
<br/>Положите начало беседе :)<br/>
<?php } ?>
</div>
