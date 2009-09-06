<div class='rtblb'>
	<div id='tags'>
		<?php foreach ($tags as $tag): ?>
		<a href="tag/<?php echo $tag['name'] ?>" style='font-size:<?php echo $tag['size'] ?>px;'><?php echo $tag['name'] ?></a>
		<?php endforeach;?>
                <a href="tags" style="font-size:26px; color:#000;">Все</a>
	</div>
</div>