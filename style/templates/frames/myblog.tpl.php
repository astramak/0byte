<h2>Мои блоги</h2>
<?php foreach ($blogs as $blog) { ?>
    <h3><a href='blog/<?php echo $blog['id']; ?>'><?php echo $blog['name']; ?></a></h3>
    <?php if($blog['avatar']) { ?>
<img style='float:right' src='res.php?t=bl&img=<?php echo $blog['avatar_url']; ?>' alt='' />
    <?php } ?>
    <h4 class='elt'>Участники:</h4><ul>
    <?php foreach ($blog['users'] as $user) { ?>
        <li><a href='user/<?php echo $user; ?>'><?php echo $user; ?></a></li>
    <?php } ?>
</ul>
<h4 class='elt'>Описание</h4><form method='post'action='<?php echo $blog['ch_url']; ?>'>
	 	<textarea name='text'><?php echo $blog['about']; ?></textarea><input type='submit' value='Отправить' />
	 	</form>
        <h4 class='elt'>Смена картинки:</h4>
	 	<form method='post' enctype='multipart/form-data' action='<?php echo $blog['av_ch_url']; ?>'>
<input type='file' name='img' />
<input type='submit' value='Загрузить' />
</form><a href='work/rmblog/<?php echo $blog['id'] ?>'>Удалить</a>
<?php } ?>
