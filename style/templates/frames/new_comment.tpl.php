<?php if (!$js) {?>
   <h3>Комментарий к:</h3>
<?php
echo $comment;
}?>
<div id="mq" class="inpt"></div>
<form method='post'
	action='twork.php?wt=newcom&lvl=<?php echo($lvl."&id=".$id."&from=".$current); ?>'>
<textarea name='text' rows='10' cols='80'></textarea><br />
<input type='submit' value='Отправить' /></form>
<script type="text/javascript"> mk('mq','new'); </script>
