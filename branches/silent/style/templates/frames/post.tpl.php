<div class={top_class}>
	<?php if (!$draft) { ?><span class='date'><?php echo $date; ?></span>
	<?php } if (!$not_in_blog) {?>
    <a class='auth' href='user/<?php echo $author; ?>/'><?php echo $author; ?></a>
	<?php }?>
</div>
<div class='text'>
	<h2 class='title' <?php if ($blocked==1) { ?>style='color:red'<?php } ?>>
		<?php
		if ($type=='link') {?>
		<a href='<?php echo $link; ?>' class='blog'>
			<img class='auth' src='style/lnk.gif' style='height: 20px;' /></a>
		<?php } elseif ($type=='translate') {?>
		<img class='auth' src='style/tr.gif' style='height: 20px;' />
		<?php }
            	if ($avatar) {?>
		<img class='pav' src='<?php echo $avatar_url; ?>' alt='' />
		<?php }
                if ($hold) {
                    ?><img src='style/n_img/chain.gif'/><?php
                }
		if ($not_in_blog) { ?>
		<a class='blog' href='user/<?php echo $author; ?>/'><?php echo $author; ?></a>
		<?php } else {?>
		<a class='blog' href='blog/<?php echo $blog_id; ?>/'><?php echo $blog_name; ?></a>
		<?php } ?> &#8212;
		<?php
                if ($draft) {
                 ?>
		<a href='draft/<?php echo $id; ?>/' class='blog'><?php echo $title;?></a>
		<?php
                } else if ($type=='link') {?>
		<a href='<?php echo $link; ?>' rel='nofollow' class='blog_link'><?php echo $title; ?></a>
		<?php } else { ?>
		<a href='post/<?php echo $id; ?>/' class='blog'><?php echo $title;?></a>
		<?php } ?>
	</h2>
	<div class='mtxt'>
		<?php echo $text; ?>
	</div>
</div>
