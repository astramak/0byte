<div class='rtblb'><div id='tags'>
<?php
foreach ($elements as $element):
?>
<a style='font-size: <?php echo $element['size'];?>px;'
href='tag/<?php echo $element['name'];?>' rel='tag'><?php echo $element['name'];?></a>
<?php endforeach;?>
</div></div>