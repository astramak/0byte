<h2 class="title">Полный список <?php if ($type=='tag') { ?>тегов<?php } else { ?>городов<?php } ?></h2>
<div id='tag_list'><?php foreach ($tags as $tag): ?>
<a href="<?php echo $type; ?>/<?php echo $tag['name'] ?>" style="font-size: <?php echo $tag['size']; ?>px;"><?php echo $tag['name'] ?></a>
<?php endforeach;?></div>