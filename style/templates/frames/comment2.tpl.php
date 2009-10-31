 <div class='ctop'>
         <?php if ($avatar) { ?>
            <img class='cauth' src='<?php echo $avatar_url; ?>' style='float:left;' alt='' />
         <?php } else { ?>
            <img class='cnoauth' src='style/img/figure.gif' alt="" />
         <?php } ?>
            <span class='date'><?php echo $comment['date']; ?></span>
      <span class='cauth'>&nbsp;<a href='<?php echo $comment['blog_url']; ?>'><?php echo $comment['blog']; ?></a>  &#8212;
              <a href='<?php echo $comment['url']; ?>'><?php echo $comment['post_title']; ?></a> <a href="<?php echo $comment['full_url']; ?>">#</a></span>
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