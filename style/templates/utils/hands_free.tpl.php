<div rel="noindex" class='rtblb'>
<table class="rtbl">
	<tbody>
		<tr id='af' class='sd'>
			<td class='lsd'>
			<ul id='alist'>
		<?php foreach ($elements as $element):?>
          
          <?php if ($element['type']=='post') {
           ?>    <li class='pelis'><?php
              if ($element['blog']=="own") {
              ?>
             
              <a href='user/<?php echo $element['auth']; ?>/'><?php echo $element['auth']; ?></a>
              <?php } else { ?>
                <a href='blog/<?php echo $element['blogid']; ?>/'><?php echo $element['blog']; ?></a>
              <?php }?>
      &#8212; &laquo;<a href='post/<?php echo $element['id'];?>/'><?php echo $element['title'];?></a>&raquo;
          <?php } else {?>

<li class='celis'><a href='user/<?php echo $element['who'];?>/'><?php echo $element['who'];?></a> &#8212; &laquo;<a href='post/<?php echo $element['pid'];?>/#cmnt<?php echo $element['id'];?>'>
<?php if ($element['blog']=="own") {?>
             
              <a href='user/<?php echo $element['auth']; ?>/'><?php echo $element['auth']; ?></a>
              <?php } else { ?>
                <a href='blog/<?php echo $element['blogid']; ?>/'><?php echo $element['blog']; ?></a>
              <?php }?>
/<a href='post/<?php echo $element['pid']."/#cmnt". $element['id'];?>'><?php echo $element['title'];?></a>&raquo;

          <?php }  if ($element['rate']!=0) {?>
              <span class='scb'>(<span class='<?php if ($element['rate']>0) echo 'rp'; else echo 'rm';?>'>
              <?php echo $element['rate'];?>
              )</span>
          <?php }?>
          </li>
        <?php endforeach; ?>

     </ul>
			</td>

			<td class='rsdno' id='ped'><a class="bbls"
				href='javascript:g_plist("post")'><img src="style/img/document.gif"
				alt="Посты" /></a> <a class="bbls" href='javascript:g_plist("com")'><img
				src="style/img/speech_bubble.gif" alt="Комментарии" /></a> 
                <?php if ($loged) {?><a class="bbls" href='javascript:g_plist("eye")'><img src="style/n_img/eye.gif" alt="Изменения" /></a><?php } ?>
			</td>
		</tr>
		<tr id='pf' class='sd'>
			<td class='lsd'><span class='ttl'>Последние посты</span>
			<ul id='plist'>
			</ul>
			</td>
			<td class='rsdno'><a class="bbls"
				style="background: #B6B6B6;" href='javascript:hplist()'><img
				src="style/img/document.gif" alt="Посты" /></a> <a class="bbls"
				href='javascript:g_plist("com")'><img
				src="style/img/speech_bubble.gif" alt="Комментарии" /></a>
                <?php if ($loged) {?><a class="bbls" href='javascript:g_plist("eye")'><img src="style/n_img/eye.gif" alt="Изменения" /></a><?php } ?>
			</td>
		</tr>
		<tr id='cf' class='sd'>
			<td class='lsd'><span class='ttl'>Последние комментарии</span>
			<ul id='clist'>
			</ul>
			</td>
			<td class='rsdno'><a class="bbls"
				href='javascript:g_plist("post")'><img src="style/img/document.gif"
				alt="Посты" /></a> <a class="bbls" style="background: #B6B6B6;"
				href='javascript:hplist()'><img src="style/img/speech_bubble.gif"
				alt="Комментарии" /></a>
                <?php if ($loged) {?><a class="bbls" href='javascript:g_plist("eye")'><img src="style/n_img/eye.gif" alt="Изменения" /></a><?php } ?>
			</td>
		</tr>

		<tr id='ef' class='sd'>
			<td class='lsd'><span class='ttl'>Изменения</span>
			<ul id='eblist'>
			</ul>
			</td>
			<td class='rsdno'><a class="bbls"
				href='javascript:g_plist("post")'><img src="style/img/document.gif"
				alt="Посты" /></a> <a class="bbls" href='javascript:g_plist("com")'><img
				src="style/img/speech_bubble.gif" alt="Комментарии" /></a> <a
				class="bbls" style="background: #B6B6B6;" href='javascript:hplist()'><img
				src="style/n_img/eye.gif" alt="Изменения" /></a></td>
		</tr>

	</tbody>
</table>
</div>
