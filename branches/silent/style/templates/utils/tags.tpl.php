<div class='rtblb'><div id='promo' class='google'>
<script type="text/javascript"><!--
google_ad_client = "pub-3461478191377314";
/* 300x250, создано 04.10.09 */
google_ad_slot = "9485153032";
google_ad_width = 300;
google_ad_height = 250;
//-->
</script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div></div>
<div class='rtblb'>
	<div id='tags'>
		<?php foreach ($tags as $tag): ?>
		<a href="tag/<?php echo $tag['name'] ?>" style='font-size:<?php echo $tag['size'] ?>px;'><?php echo $tag['name'] ?></a>
		<?php endforeach;?>
                <a href="tags" style="font-size:26px; color:#000;">Все</a>
	</div>
</div>