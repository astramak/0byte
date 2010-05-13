<?php if ($answered) {?>
<table>
		<?php foreach ($elements as $element): ?>
    <tr>
		<td><b><?php echo $element['title'];?></b></td>
		<td><?php echo $element['val']; ?></td>
		<td class="tdans">
			<div class="ans" style="width:<?php echo $element['size']; ?>%"></div>
		</td>
	</tr>
		<?php endforeach;?>
</table>
<?php } else { ?>
<div id='a_<?php echo $id;?>'>
	<form method='post' action='<?php echo $action; ?>'>
			<?php foreach ($elements as $element): ?>
		<div>
			<label><input <?php echo $element['options']; ?> /><?php echo $element['title']; ?></label>
		</div>
               		<?php endforeach; ?>
			<?php if ($loged) {?>
		<div>
			<input type='submit' name='nax' onClick='answe(this.form,1); return false;' value='Голосовать' />
			<input type='submit' name='nox' onClick='answe(this.form,2); return false;' value='Воздержаться' />
		</div>
			<?php } ?>
	</form>
</div>
<?php } ?>