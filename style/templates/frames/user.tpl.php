<h2><span class='fn'><?php echo $name; ?></span>  <a href='work/pmnew/<?php echo $name; ?>'>
        <img alt='ЛС' src='style/img/envelope.gif' /></a>
</h2>
<?php if ($avatar) {?>
    <img class='photo' style='float:right' src='<?php echo $avatar_url; ?>' alt='' />
<?php }
if ($use_micro)  { ?>
<span class='jst'><a href="<?php echo $micro_url;?>"><?php echo $micro_name;?></a>:<?php echo $micro_status;?></span>
<?php }
if ($blocked) {?>
    <h3>Пoльзователь заблокирован</h3>
<?php } ?>
 <table border='0'>
<?php if ($lvl>0) {?>
    <tr><td>Уровень доступа</td><td><?php echo $lvl; ?></td></tr>
<?php }
if (!$hide_mail) {?>
    <tr><td>E-mail</td><td><a href='mailto:<?php echo $mail;?>' class='email'><?php echo $mail;?></a></td></tr>
<?php }
if ($icq['set']) {?>
    <tr><td>ICQ</td><td><?php echo $icq['text'];?></td></tr>
<?php }
if ($jabber['set']) {?>
    <tr><td>Jabber</td><td><a href='xmpp:<?php echo $jabber['text']; ?>'><?php echo $jabber['text']; ?></a></td><td>
<?php }
if ($site['set']) { ?>
    <tr><td>Сайт</td><td><noindex><a href='<?php echo $site['text']; ?>' rel='nofollow'><?php echo $site['text']; ?></a></noindex></td></tr>
<?php }
if ($city['set']) {?>
    <tr><td>Город</td><td><?php echo $city['text']; ?></td><td>
<?php } ?>
<tr><td>Рейтинг</td><td><a class='ratep' href='<?php echo $ratep_url;?>'>+</a>
        <span id='ru<?php echo $name; ?>'><?php if ($rate>0) {
            ?><span class='rp'><?php echo $rate; ?></span><?php
        } else if ($rate<0) {
            ?><span class='rm'><?php echo $rate; ?></span><?php
        } else echo 0;?></span>
			<a class='ratem' href='<?php echo $ratem_url;?>'>&ndash;</a></td></tr>
<?php if ($about['set']) {?>
    <tr><td>О себе:</td><td><span class='note'><?php echo $about['text']; ?></span></td></tr>
<?php }?>
<tr><td>В блогах</td><td>
        <?php foreach ($blogs as $blog) {?>
            <a href='blog/<?php $blog['id']; ?>/'><?php echo $blog['name']; ?></a> 
        <?php } ?>
    </td></tr>
<tr><td><a href='auth/<?php echo $name; ?>/'>Всего постов</a></td><td><a href='auth/<?php echo $name; ?>/'><?php echo $post_count; ?></a></td></tr>
<tr><td><a href='comment/<?php echo $name; ?>/'>Коментариев</a></td><td><a href='comment/<?php echo $name; ?>/'><?php echo $comment_count; ?></a></td></tr>
<tr><td>Друзья</td><td>
        <?php foreach ($friends as $friend) {?>
            <a href='user/<?php echo $friend; ?>/'><?php echo $friend; ?></a>
        <?php } ?>
    </td></tr>
</table><br />
<?php if ($owner) {?>
    <br /><a href="work/edituser">Редактировать личные данные</a>
<a href="work/cpw">Сменить пароль</a>
<?php } else if (!$is_friend) {?>
    <br/><a id='ifrn' href='<?php echo $friend_url; ?>'>Добавить в друзья</a>
<?php } else { ?>
    <br /><a id='ofrn' href='<?php echo $friend_url; ?>'>Перестать дружить</a>
<?php }
if ($allow_block) { ?>
    <br /><br /><a href='<?php echo $block_url; ?>'><?php if ($blocked) echo "Раз"; else echo "За"; ?>блокировать</a>
<?php } ?>
</div>