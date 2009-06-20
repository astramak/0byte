<div class='rtblb'>
	<div id='tags'>
		<?php foreach ($tags as $tag): ?>
		<a href="tag/<?php echo $tag['name'] ?>" class="tag_w<?php echo $tag['weight'] ?>"><?php echo $tag['name'] ?></a>
		<?php endforeach;?>
	</div>
</div>