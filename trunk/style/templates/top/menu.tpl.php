<?php foreach ($elements as $element): ?>
<div <?php if ($element['active']) { echo "class='amenuel'";} else if ($element['before_active']) {echo "class='lmenuel'";}
else {echo "class='menuel'";}?> >
<a href="<?php echo $element['url'];?>"><?php echo $element['title'];?>
<?php if ($element['new']>0) {?><span class="add"><?php echo $element['new'];?></span><?php }?></a></div>
<?php endforeach; ?>
