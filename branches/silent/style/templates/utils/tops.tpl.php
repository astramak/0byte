<div class='rtblb'>
	<table class='rtbl'>
		<tbody>
			<tr id ='bltop' class='sd'>
				<td class='lsd'>
					<span class='ttl'>Лучшие блоги (<a href='list/blog/'>все <?php echo $blogs_num; ?></a>)</span>
					<ul id='blist'>
						<?php foreach ($blogs as $blog): ?>
						<li><a href='blog/<?php echo $blog['id']; ?>/'><?php echo $blog['name']; ?></a>
								<?php if ($blog['rate']!=0) {?>
							<span class='scb'>(<span class='r<?php if ($blog['rate']>0) echo 'p'; else echo 'm';?>'><?php echo $blog['rate']; ?></span>)</span>
								<?php }?>
						</li>
						<?php 
						endforeach; ?>
					</ul>
    

	            	<?php if ($loged) {?>
                    
					<?php if (isset($allow_blog) && $allow_blog) {?>
					<ul id='glist'>
					  <li><a href='work/newblog'>Новый блог</a></li>
                    </ul>

					<ul id='alist'><!-- lol style -->
					  <li><a href='work/myblog'>Ваши блоги</a></li>
					</ul>
				    <?php }?>

					<?php } else {?>
					<!-- register and create your tematic blog about linux!, example -->
                    <?php }?>


				</td>
				<td class='rsdno'>
					<div id='shall'>
						<a class='bbls' href='javascript:g_plist("top_user")'>
							<img src='style/img/figure.gif' alt='Топ пользователей' title="Топ пользователей" />
						</a>
						<a class='bbls' href='javascript:g_plist("top_blog")'>
							<img src='style/img/documents.gif' alt='Топ блогов'  title="Топ блогов" />
						</a>
					</div>
					<div id='shblog'>
						<a class='bbls' href='javascript:g_plist("top_user")'>
							<img src='style/img/figure.gif' alt='Топ пользователей'  title="Топ пользователей" />
						</a>
						<a class='bbls' style='background:#B6B6B6;' href='javascript:hgptop()'>
							<img src='style/img/documents.gif' alt='Топ блогов'  title="Топ блогов" />
						</a>
					</div>
				</td>
			</tr>
			<tr id ='ustop' class='sd'>
				<td class='lsd'>
					<span class='ttl'>Элита (<a href='list/user/'><?php echo $users_num; ?></a> из <a href="list/city/"><?php
                                                echo $city_num.' '.inducing($city_num, array('городов','городов','города')); ?></a>)</span>
					<ul class='ulist' id='ulister'>
						<?php foreach ($users as $user):?>
						<li><a href='user/<?php echo $user['name'];?>/'><?php echo $user['name'];?></a>
								<?php if ($user['rate']!=0) {?>
							<span class='scb'>(<span class='r<?php if ($user['rate']>0) echo 'p'; else echo 'm';?>'><?php echo $user['rate']; ?></span>)</span>
								<?php }?>
						</li>
						<?php endforeach;?>
					</ul>
				</td>
				<td class='rsdno'>
					<div id='shuser'>
						<a style='background:#B6B6B6;' class='bbls'  href='javascript:hgptop()'>
							<img src='style/img/figure.gif' alt='Топ пользователей'  title="Топ пользователей" />
						</a>
						<a class='bbls' href='javascript:g_plist("top_blog")'>
							<img src='style/img/documents.gif' alt='Топ блогов' title="Топ блогов" />
						</a>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>
