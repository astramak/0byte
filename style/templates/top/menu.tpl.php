<?php foreach ($elements as $element):
	if ($element['show']) {?>
<div class="{active='<?php echo$element['url']; ?>'}a{/active}{before_active='<?php echo$element['url']; ?>'}l{/before_active}menuel">
	<a href="<?php echo $element['url'];?>">
				<?php echo $element['title'];?>
				<?php if ($element['new']>0) {?>
		<span class="add"><?php echo $element['new'];?></span>
				<?php } ?>
	</a>
</div>
	<?php } ?>
<?php  endforeach; ?>
