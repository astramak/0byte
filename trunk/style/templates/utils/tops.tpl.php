<div class='rtblb'><table  class='rtbl'><tbody>
<tr id ='bltop' class='sd'>
<td class='lsd'>
<span class='ttl'>Top блогов (<a href='list/blog/'>все</a>)</span>
<ul id='blist'>
<?php foreach ($blogs as $blog): ?>
<li><a href='blog/<?php echo $blog['name']; ?>/'><?php echo $blog['name']; ?></a>
<?php if ($blog['rate']!=0) {?>
    <span class='scb'>(<span class='r<?php if ($blog['rate']>0) echo 'p'; else echo 'm';?>'><?php echo $blog['rate']; ?></span>)</span>
<?php }?>
</li>
<?php endforeach; ?>
</ul>
</td><td class='rsdno'>

<div id='shall'><a class='bbls'  href='javascript:g_plist(\"top_user\")'><img src='style/img/figure.gif' alt='Топ пользователей' /></a>
<a class='bbls' href='javascript:g_plist(\"top_blog\")'><img src='style/img/documents.gif' alt='Топ блогов' /></a></div>
<div id='shblog'><a class='bbls'  href='javascript:g_plist(\"top_user\")'><img src='style/img/figure.gif' alt='Топ пользователей' /></a>
<a class='bbls' style='background:#B6B6B6;' href='javascript:hgptop()'><img src='style/img/documents.gif' alt='Топ блогов' /></a></div>


</td></tr>
<tr id ='ustop' class='sd'>
<td class='lsd'>
<span class='ttl'>Top пользователей (<a href='list/user/'>все</a>)</span>
<ul class='ulist' id='ulister'>
<?php foreach ($users as $user):?>
<li><a href='user/<?php echo $user['name'];?>/'><?php echo $user['name'];?></a>
<?php if ($user['rate']!=0) {?>
    <span class='scb'>(<span class='r<?php if ($user['rate']>0) echo 'p'; else echo 'm';?>'><?php echo $user['rate']; ?></span>)</span>
<?php }?>
</li>
<?php endforeach;?>
</ul></td><td class='rsdno'>

<div id='shuser'><a style='background:#B6B6B6;' class='bbls'  href='javascript:hgptop()'><img src='style/img/figure.gif' alt='Топ пользователей' /></a>
<a class='bbls' href='javascript:g_plist(\"top_blog\")'><img src='style/img/documents.gif' alt='Топ блогов' /></a></div>

</td></tr></tbody></table></div>