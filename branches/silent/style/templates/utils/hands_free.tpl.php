<div rel="noindex" class='rtblb'>
    <table class="rtbl">
        <tbody>
            <tr id='af' class='sd'>
                <td class='lsd'>
                    <ul id='alist'>
                        <?php foreach ($elements as $element):?>

                            <?php if ($element['type']=='post') {
                                ?>    <li class='pelis'><?php
                                    if ($element['blogid']==0) {
                                        ?>

                            <a href='user/<?php echo $element['auth']; ?>/'><?php echo $element['auth']; ?></a>
                                    <?php } else { ?>
                            <a href='blog/<?php echo $element['blogid']; ?>/'><?php echo $element['blog']; ?></a>
                                    <?php }?>
                            &#8212; &laquo;<a href='post/<?php echo $element['id'];?>/'><?php echo $element['title'];?></a>&raquo;
                                <?php } else {?>

                        <li class='celis'><a href='user/<?php echo $element['who'];?>/'><?php echo $element['who'];?></a> &#8212; &laquo;<a href='post/<?php echo $element['pid'];?>/#cmnt<?php echo $element['id'];?>'>
                                        <?php if ($element['blogid']==0) {?>

                                <a href='user/<?php echo $element['auth']; ?>/'><?php echo $element['auth']; ?></a>
                                        <?php } else { ?>
                                <a href='blog/<?php echo $element['blogid']; ?>/'><?php echo $element['blog']; ?></a>
                                        <?php }?>
                                / <a href='post/<?php echo $element['pid']."/#cmnt". $element['id'];?>'><?php echo $element['title'];?></a>&raquo;

                                    <?php }  if ($element['rate']!=0) {?>
                                <span class='scb'>(<span class='<?php if ($element['rate']>0) echo 'rp'; else echo 'rm';?>'>
                                                <?php echo $element['rate'];?>
                                        </span>)
                                        <?php }?></span>
                                    </li>
                                    <?php endforeach; ?>

                                    </ul>
                                    </td>

                                    <td class='rsdno' id='ped'><a class="bbls"
                                                                  href='javascript:g_plist("post")'><img src="style/img/document.gif"
                                                                               alt="Посты" title="Посты" /></a> <a class="bbls" href='javascript:g_plist("com")'><img
                                                src="style/img/speech_bubble.gif" alt="Комментарии" title="Комментарии" /></a>
                                        <?php if ($loged) {?><a class="bbls" href='javascript:g_plist("eye")'><img src="style/n_img/eye.gif" alt="Изменения" title="Изменения" /></a>
                                        <a class="bbls" href="draft#"><img
                                                src="style/n_img/draft.png" alt="Черновики" title="Черновики" /></a>
                                        <a class="bbls" href="favourite#"><img
                                                src="style/n_img/fav.gif" alt="Избранное" title="Избранное" /></a>
                                            <?php } ?>
                                    </td>
                                    </tr>
                                    <tr id='pf' class='sd'>
                                        <td class='lsd'><span class='ttl'>Последние посты</span>
                                            <ul id='plist'>
                                            </ul>
                                        </td>
                                        <td class='rsdno'><a class="bbls"
                                                             style="background: #B6B6B6;" href='javascript:hplist()'><img
                                                    src="style/img/document.gif" alt="Посты" title="Посты" /></a> <a class="bbls"
                                                                                               href='javascript:g_plist("com")'><img
                                                    src="style/img/speech_bubble.gif" alt="Комментарии" title="Комментарии" /></a>
                                            <?php if ($loged) {?><a class="bbls" href='javascript:g_plist("eye")'><img src="style/n_img/eye.gif" alt="Изменения" title="Изменения" /></a>

                                            <a class="bbls" href="javascript:g_plist('draft')"><img
                                                    src="style/n_img/draft.png" alt="Черновики" title="Черновики" /></a>
                                            <a class="bbls" href="javascript:g_plist('favourite')"><img
                                                    src="style/n_img/fav.gif" alt="Избранное" title="Избранное" /></a>
                                                <?php } ?>
                                        </td>
                                    </tr>
                                    <tr id='cf' class='sd'>
                                        <td class='lsd'><span class='ttl'>Последние комментарии</span>
                                            <ul id='clist'>
                                            </ul>
                                        </td>
                                        <td class='rsdno'><a class="bbls"
                                                             href='javascript:g_plist("post")'><img src="style/img/document.gif"
                                                                                   alt="Посты" title="Посты" /></a> <a class="bbls" style="background: #B6B6B6;"
                                                                  href='javascript:hplist()'><img src="style/img/speech_bubble.gif"
                                                                            alt="Комментарии" title="Комментарии" /></a>
                                            <?php if ($loged) {?><a class="bbls" href='javascript:g_plist("eye")'><img src="style/n_img/eye.gif" alt="Изменения" title="Изменения" /></a>
                                            <a class="bbls" href="javascript:g_plist('draft')"><img
                                                    src="style/n_img/draft.png" alt="Черновики" title="Черновики" /></a>
                                            <a class="bbls" href="javascript:g_plist('favourite')"><img
                                                    src="style/n_img/fav.gif" alt="Избранное" title="Избранное" /></a><?php } ?>
                                        </td>
                                    </tr>

                                    <tr id='ef' class='sd'>
                                        <td class='lsd'><span class='ttl'>Изменения</span>
                                            <ul id='eblist'>
                                            </ul>
                                        </td>
                                        <td class='rsdno'><a class="bbls"
                                                             href='javascript:g_plist("post")'><img src="style/img/document.gif"
                                                                                   alt="Посты" title="Посты" /></a> <a class="bbls" href='javascript:g_plist("com")'><img
                                                    src="style/img/speech_bubble.gif" alt="Комментарии" title="Комментарии" /></a> <a
                                                class="bbls" style="background: #B6B6B6;" href='javascript:hplist()'><img
                                                    src="style/n_img/eye.gif" alt="Изменения" title="Изменения" /></a>
                                            <a class="bbls" href="javascript:g_plist('draft')"><img
                                                    src="style/n_img/draft.png" alt="Черновики" title="Черновики" /></a>
                                            <a class="bbls" href="javascript:g_plist('favourite')"><img
                                                    src="style/n_img/fav.gif" alt="Избранное" title="Избранное" /></a>
                                        </td>
                                    </tr>
                                    <tr id='df' class='sd'>
                                        <td class='lsd'><span class='ttl'>Черновики (<a href="draft">все</a>)</span>
                                            <ul id='drlist'>
                                            </ul>
                                        </td>
                                        <td class='rsdno'><a class="bbls"
                                                             href='javascript:g_plist("post")'><img src="style/img/document.gif"
                                                                                   alt="Посты" title="Посты" /></a> <a class="bbls" href='javascript:g_plist("com")'><img
                                                    src="style/img/speech_bubble.gif" alt="Комментарии" title="Комментарии" /></a> <a class="bbls"
                                                href='javascript:g_plist("eye")'><img
                                                    src="style/n_img/eye.gif" alt="Изменения" title="Изменения" /></a>
                                            <a class="bbls"  style="background: #B6B6B6;" href="javascript:hplist()"><img
                                                                               src="style/n_img/draft.png" alt="Черновики" title="Черновики" /></a>
                                            <a class="bbls" href="javascript:g_plist('favourite')"><img
                                                    src="style/n_img/fav.gif" alt="Избранное" title="Избранное" /></a>
                                        </td>
                                    </tr>
                                    <tr id='ff' class='sd'>
                                        <td class='lsd'><span class='ttl'>Избранное (<a href="favourite">всё</a>)</span>
                                            <ul id='fvlist'>
                                            </ul>
                                        </td>
                                        <td class='rsdno'><a class="bbls"
                                                             href='javascript:g_plist("post")'><img src="style/img/document.gif"
                                                                                   alt="Посты" title="Посты" /></a> <a class="bbls" href='javascript:g_plist("com")'><img
                                                    src="style/img/speech_bubble.gif" alt="Комментарии" title="Комментарии" /></a> <a
                                            class="bbls"    href='javascript:g_plist("eye")'><img
                                                    src="style/n_img/eye.gif" alt="Изменения" title="Изменения" /></a>
                                            <a class="bbls" href="javascript:g_plist('draft')"><img
                                                    src="style/n_img/draft.png" alt="Черновики" title="Черновики" /></a>
                                            <a class="bbls" style="background: #B6B6B6;" href="javascript:hplist()"><img
                                                                               src="style/n_img/fav.gif" alt="Избранное" title="Избранное" /></a>
                                        </td>
                                    </tr>
                                    </tbody>
                                    </table>
                                    </div>
