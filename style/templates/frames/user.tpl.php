<br/><span class='title'><?php echo $name; ?>  <a href='work/pmnew/<?php echo $name; ?>'>
        <img alt='ЛС' src='style/img/envelope.gif' title='Написать личное сообщение этому пользователю'/></a>  <a class='ratep' href='<?php echo $ratep_url;?>'>+</a>
        <span id='ru<?php echo $name; ?>'><?php if ($rate>0) {
            ?><span class='rp'><?php echo $rate; ?></span><?php
        } else if ($rate<0) {
            ?><span class='rm'><?php echo $rate; ?></span><?php
        } else echo 0;?></span>
			<a class='ratem' href='<?php echo $ratem_url;?>'>&ndash;</a></span>

<?php if ($avatar) {?>
    <img class='photo' style='float:right' src='<?php echo $avatar_url; ?>' alt='' />
<?php }
if ($use_micro)  { ?>
<br/><i><span class='grey'><a href="<?php echo $micro_url;?>"><?php echo $micro_name;?></a>:<?php echo $micro_status;?></span></i>
<?php }
if ($blocked) {?>
    <br><h3>Пoльзователь заблокирован</h3>
<?php } ?>
<br><br>
<?php if ($lvl>0) {?>
    <?php echo $lvl; ?>-й уровень доступа<br><br>
<?php }
if (!$hide_mail) {?>
    <img src='http://img200.imageshack.us/img200/5982/emailh.png'/> <a href='mailto:<?php echo $mail;?>' class='email'><?php echo $mail;?></a>, 
<?php } $not_first=0;
if ($icq['set']) { $not_first=1; ?>
    <img src='http://web.icq.com/whitepages/online?icq=<?php echo $icq['text'];?>&img=5'/><?php echo $icq['text'];
}
if ($jabber['set']) {  if ($not_first) echo ','; $not_first=1; ?><img src='http://img194.imageshack.us/img194/2286/jabberonline.png'/><a href='xmpp:<?php echo $jabber['text']; ?>'><?php echo $jabber['text']; ?></a><?php
 }
if ($usite['set']) { if ($not_first) echo ','; ?> <img src='http://img44.imageshack.us/img44/4667/webbrowser.png'/> <noindex><a href='<?php echo $usite['text']; ?>' rel='nofollow'><?php echo $usite['text']; ?></a></noindex>
<?php }
echo '- контакты.';
?>
<br><br>
<?php 
if ($city['set']) {?>
Город - <?php echo $city['text']; ?>
<?php } ?>

<br><br/>
<?php if ($about['set']) {?>
    <?php echo $name; ?> о себе: <br><span class='note'><?php echo $about['text']; ?></span>
<?php }
if (@$blogs) { ?>
<br><br>Состоит в
        <?php foreach ($blogs as $blog) {?>
            <a href='blog/<?php $blog['id']; ?>/'><?php echo $blog['name']; ?></a> 
        <?php } } ?>
 
<br><br>
Написал <a href='auth/<?php echo $name; ?>/'><?php echo $post_count; ?> постов</a> и <a href='comment/<?php echo $name; ?>/'><?php echo $comment_count; ?> коментариев</a>

<br>
<?php if (@$friends) { ?>Дружит с
        <?php foreach ($friends as $friend) {?>
            <a href='user/<?php echo $friend; ?>/'><?php echo $friend; ?></a>
        <?php } ?>
    <?php } ?>
<br /><br><hr>
<?php if ($owner) {?>
    <br /><img src='http://astramak.jino.ru/welinux/edit.png'/> <a href="work/edituser">Редактировать профиль</a> 
    <img src='http://astramak.jino.ru/welinux/edit.png'/> <a href="work/cpw">Сменить пароль</a>
<?php } else if (!$is_friend) {?>
    <br/><a id='ifrn' href='<?php echo $friend_url; ?>'>Добавить в друзья</a>
<?php } else { ?>
    <br /><a id='ofrn' href='<?php echo $friend_url; ?>'>Перестать дружить</a>
<?php }
if ($allow_block) { ?>
    <br /><br /><a href='<?php echo $block_url; ?>'><?php if ($blocked) echo "Раз"; else echo "За"; ?>блокировать</a>
<?php } ?>
</div>