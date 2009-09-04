<h2 class="title">Полный список тегов</h2>
<div id='tag_list'><?php foreach ($tags as $tag): ?>
<a href="tag/<?php echo $tag['name'] ?>" style="font-size: <?php echo $tag['size']; ?>px;"><?php echo $tag['name'] ?></a>
<?php endforeach;?></div>