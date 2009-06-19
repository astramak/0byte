<?php if (!$js) {?> <h3>Комментарий к:</h3> <?php echo $comment;}?>
<div id="mq" class="inpt"></div>
<form method='post' action='twork.php?wt=newcom&lvl=<?php echo($lvl."&id=".$id."&from=".$current); ?>'>
	<div>
		<textarea name='text' rows='10' cols='80'></textarea>
	</div>
	<div>
		<input type='submit' value='Отправить' />
	</div>
</form>
<script type="text/javascript"> mk('mq','new'); </script>
