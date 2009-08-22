<div class="usln">
	<div class="usrd">
		<?php if ($loged) {?>
		<a class='you' href='user/'><?php echo $login;?></a>
		<span <?php if ($user_rate>0) echo "class='rp'"; else  if ($user_rate<0)  echo "class='rm'";?>><?php echo $user_rate;?>
		</span> <a href='work/newpost'>Новый пост</a>
			<?php if ($allow_blog) {?> / <a href='work/newblog'>блог</a>. Ваши <a href='work/myblog'>блоги</a><?php }?>
		и  <!-- <img src='style/img/<?php if ($not_readed>0) {?>mail<?php } else {?>envelope<?php }?>.gif'
					 alt='' /> --> <a href='work/pmls' title='<?php echo $not_readed." / ".$mail;?>'>ЛС</a><span class='grey'> (<?php echo $not_readed."/".$mail;?>)</span> </div>
		<div id='inout'><img src='style/img/figure.gif' alt='' />
			<form id='out' method='post' action='<?php echo $site;?>'><input type='hidden' name='un' value='1' />
				<input id='outb' type='submit' value='Выйти' /></form></div>
		<?php } else {?>
		<a href='register'>Зарегистрироваться</a></div>
	<div id='inout'><a id='lgin' href='login/<?php echo $current_url; ?>'>Войти</a></div>
	<?php }?>
</div>
</div>
</div>
<div id="main">