<br/><span class='title'><?php echo $name; ?> 
          <?php if (!$no_user_rate) { ?><a class='ratep' href='<?php echo $ratep_url;?>'>+</a><?php } ?>
    <span id='ru<?php echo $name; ?>'><?php if ($rate>0) {
            ?><span class='rp'><?php echo $rate; ?></span><?php
        } else if ($rate<0) {
                ?><span class='rm'><?php echo $rate; ?></span><?php
        } else echo 0;?></span>
    <?php if (!$no_user_rate) { ?><a class='ratem' href='<?php echo $ratem_url;?>'>&ndash;</a><?php } ?></span>

<?php if ($avatar) {?>
<img class='photo' style='float:right' src='<?php echo $avatar_url; ?>' alt='' />
<?php }
if ($use_micro) { ?>
<br/><i><span class='grey'><a href="<?php echo $micro_url;?>" title='<?php echo $micro_name;?>' style='text-decoration:none'><?php echo $micro_status;?></a></span></i>
<?php }
if ($blocked) {?>
<br /><h3>Пoльзователь заблокирован. <?php if ($block_cause) echo ' : '.$block_cause; ?></h3>
<?php } ?>
<br /><br />
<?php if ($lvl>0) {?>
    <?php echo $lvl; ?>-й уровень доступа<br /><br />

<?php }
if ($city['set']) {?>
<img src='style/n_img/city.png'/> <a href='list/user/city/<?php echo $city['text']; ?>'><?php echo $city['text']; ?></a>, 
<?php } ?>
<img src='style/n_img/envelope.gif'/> <a href='work/pmnew/<?php echo $name; ?>'>личное сообщение</a>,
<?php

if (!$hide_mail) {?>
<img src='style/n_img/mailing.gif'/> <a href='mailto:<?php echo $mail;?>' class='email'><?php echo $mail;?></a>, 
<?php } $not_first=0;
if ($icq['set']) { $not_first=1; ?>
<img src='style/n_img/icq.png'/> <?php echo $icq['text'];
}
if ($jabber['set']) {  if ($not_first) echo ','; $not_first=1; ?> <img src='style/n_img/jabber.png'/><a href='xmpp:<?php echo $jabber['text']; ?>'><?php echo $jabber['text']; ?></a><?php
}
if ($usite['set']) { if ($not_first) echo ','; ?> <img src='style/n_img/world.gif'/> <noindex><a href='<?php echo $usite['text']; ?>' rel='nofollow'><?php echo $usite['text']; ?></a></noindex>
<?php }
echo '';
?>
<br/><br/><br/>
<?php if ($about['set']) {?>
О себе: <br /><span class='note'><?php echo $about['text']; ?></span>
<?php }
if (@$blogs) { ?>
<br/></br><hr><br/>Состоит в
    <?php foreach ($blogs as $blog) {?>
<a href='blog/<?php echo $blog['id']; ?>/'><?php echo $blog['name']; ?></a><?php if ($blog!=end($blogs)) echo ','; ?>
    <?php } } ?>
<br/>
<?php if (@$friends) { ?><br />Дружит с
    <?php foreach ($friends as $friend) { if (strlen($friend)>1) { ?>
<a href='user/<?php echo $friend; ?>/'><?php echo $friend; ?></a><?php if ($friend!=end($friends)) echo ','; ?>
        <?php } } } ?>
<br /><br />
Написал <a href='auth/<?php echo $name; ?>/'><?php echo $post_count." "; echo inducing($post_count, array('поста','постов','пост'));?></a> и <a href='comment/<?php echo $name; ?>/'><?php echo $comment_count." ";
echo inducing($comment_count, array('комментария','комментариев','комментарий')); ?></a>

<br /><br /><hr>
<?php if ($loged) {if ($owner) {?>
<br /><img src='style/n_img/edit.png'/> <a href="work/edituser">Редактировать профиль</a>
<img src='style/n_img/edit.png'/> <a href="work/cpw">Сменить пароль</a>
    <?php } else if (!$is_friend) {?>
<br/><a id='ifrn' href='<?php echo $friend_url; ?>'>Добавить в друзья</a>
        <?php } else { ?>
<br /><a id='ofrn' href='<?php echo $friend_url; ?>'>Перестать дружить</a>
        <?php }
    if ($allow_block) { ?>
<br /><br /><a href='<?php echo $block_url; ?>'><?php if ($blocked) echo "Раз"; else echo "За"; ?>блокировать</a>
    <?php } } ?>
</div>
