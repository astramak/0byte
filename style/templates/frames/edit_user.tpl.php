<h3>Редактирование профиля <?php echo $login; ?></h3>
<form name="aa" method="post" action="twork.php?wt=edituser">
    <table border="0">
        <tr>
            <td>E-mail</td>
            <td><input type="text" name="mail"
                       value="<?php echo $mail; ?>" /><br />
                <label><input name="hml" type="checkbox"
                              <?php echo $show_mail; ?> />Скрыть</label></td>
        </tr>
        <tr>
            <td>icq</td>
            <td><input type="text" name="icq"
                       value="<?php echo $icq; ?>" /></td>
        </tr>
        <tr>
            <td>jabber</td>
            <td><input type="text" name="jabber"
                       value="<?php echo $jabber; ?>" /></td>
        </tr>
        <tr>
            <td>Город</td>
            <td><input type="text" name="city"
                       value="<?php echo $city; ?>" /></td>
        </tr>
        <tr>
            <td>Часовой пояс</td>
            <td><select name="timezone">
                    <option <?php if ($timezone==-12) { ?>selected="selected"<?php } ?> value="-12">(GMT -12:00) Эневеток, Кваджалейн</option>
                    <option <?php if ($timezone==-11) { ?>selected="selected"<?php } ?> value="-11">(GMT -11:00) Остров Мидуэй, Самоа</option>
                    <option <?php if ($timezone==-10) { ?>selected="selected"<?php } ?> value="-10">(GMT -10:00) Гавайи</option>
                    <option <?php if ($timezone==-9) { ?>selected="selected"<?php } ?> value="-9">(GMT -9:00) Аляска</option>
                    <option <?php if ($timezone==-8) { ?>selected="selected"<?php } ?> value="-8">(GMT -8:00) Тихоокеанское время (США и Канада), Тихуана</option>
                    <option <?php if ($timezone==-7) { ?>selected="selected"<?php } ?> value="-7">(GMT -7:00) Горное время (США и Канада), Аризона</option>
                    <option <?php if ($timezone==-6) { ?>selected="selected"<?php } ?> value="-6">(GMT -6:00) Центральное время (США и Канада), Мехико</option>
                    <option <?php if ($timezone==-5) { ?>selected="selected"<?php } ?> value="-5">(GMT -5:00) Восточное время (США и Канада), Богота, Лима</option>
                    <option <?php if ($timezone==-4.5) { ?>selected="selected"<?php } ?> value="-4.5">(GMT -4:30) Каракас</option>
                    <option <?php if ($timezone==-4) { ?>selected="selected"<?php } ?> value="-4">(GMT -4:00) Атлантическое время (Канада), Ла Пас</option>
                    <option <?php if ($timezone==-3.5) { ?>selected="selected"<?php } ?> value="-3.5">(GMT -3:30) Ньюфаундленд</option>
                    <option <?php if ($timezone==-3) { ?>selected="selected"<?php } ?> value="-3">(GMT -3:00) Бразилия, Буэнос-Айрес, Джорджтаун</option>
                    <option <?php if ($timezone==-2) { ?>selected="selected"<?php } ?> value="-2">(GMT -2:00) Среднеатлантическое время</option>
                    <option <?php if ($timezone==-1) { ?>selected="selected"<?php } ?> value="-1">(GMT -1:00) Азорские острова, острова Зелёного Мыса</option>
                    <option <?php if ($timezone==0) { ?>selected="selected"<?php } ?> value="0">(GMT) Дублин, Лондон, Лиссабон, Касабланка, Эдинбург</option>
                    <option <?php if ($timezone==1) { ?>selected="selected"<?php } ?> value="1">(GMT +1:00) Брюсель, Копенгаген, Мадрид, Париж, Берлин</option>
                    <option <?php if ($timezone==2) { ?>selected="selected"<?php } ?> value="2">(GMT +2:00) Афины, Киев, Минск, Бухарест, Рига, Таллин</option>
                    <option <?php if ($timezone==3) { ?>selected="selected"<?php } ?> value="3">(GMT +3:00) Москва, Санкт-Петербург, Волгоград</option>
                    <option <?php if ($timezone==3.5) { ?>selected="selected"<?php } ?> value="3.5">(GMT +3:30) Тегеран</option>
                    <option <?php if ($timezone==4) { ?>selected="selected"<?php } ?> value="4">(GMT +4:00) Абу-Даби, Баку, Тбилиси, Ереван</option>
                    <option <?php if ($timezone==4.5) { ?>selected="selected"<?php } ?> value="4.5">(GMT +4:30) Кабул</option>
                    <option <?php if ($timezone==5) { ?>selected="selected"<?php } ?> value="5">(GMT +5:00) Екатеринбург, Исламабад, Карачи, Ташкент</option>
                    <option <?php if ($timezone==5.5) { ?>selected="selected"<?php } ?> value="5.5">(GMT +5:30) Бомбей, Калькутта, Мадрас, Нью-Дели</option>
                    <option <?php if ($timezone==5.75) { ?>selected="selected"<?php } ?> value="5.75">(GMT +5:45) Катманду</option>
                    <option <?php if ($timezone==6) { ?>selected="selected"<?php } ?> value="6">(GMT +6:00) Омск, Новосибирск, Алма-Ата, Астана</option>
                    <option <?php if ($timezone==6.5) { ?>selected="selected"<?php } ?> value="6.5">(GMT +6:30) Янгон, Кокосовые острова</option>
                    <option <?php if ($timezone==7) { ?>selected="selected"<?php } ?> value="7">(GMT +7:00) Красноярск, Норильск, Бангкок, Ханой, Джакарта</option>
                    <option <?php if ($timezone==8) { ?>selected="selected"<?php } ?> value="8">(GMT +8:00) Иркутск, Пекин, Перт, Сингапур, Гонконг</option>
                    <option <?php if ($timezone==9) { ?>selected="selected"<?php } ?> value="9">(GMT +9:00) Якутск, Токио, Сеул, Осака, Саппоро</option>
                    <option <?php if ($timezone==9.5) { ?>selected="selected"<?php } ?> value="9.5">(GMT +9:30) Аделаида, Дарвин</option>
                    <option <?php if ($timezone==10) { ?>selected="selected"<?php } ?> value="10">(GMT +10:00) Владивосток, Восточная Австралия, Гуам</option>
                    <option <?php if ($timezone==11) { ?>selected="selected"<?php } ?> value="11">(GMT +11:00) Магадан, Сахалин, Соломоновы Острова</option>
                    <option <?php if ($timezone==12) { ?>selected="selected"<?php } ?> value="12">(GMT +12:00) Камчатка, Окленд, Уэллингтон, Фиджи</option>
                </select></td>
        </tr>
        <tr>
            <td>Сайт</td>
            <td><input type="text" name="site"
                       value="<?php echo $usite; ?>" /></td>
        </tr>
        <tr>
            <td>О себе</td>
            <td><textarea rows="5" cols="30" name="about"><?php echo $about; ?></textarea></td>
        </tr>
        <tr>
            <td>Оповещение:</td>
            <td><label><input name="pr" type="checkbox"
                              <?php echo $post_reply ?> />Об ответах на посты</label>
                <label><input name="cr" type="checkbox"
                              <?php echo $comment_reply; ?> />Об ответах на
		комментарии</label> <label><input name="pmr" type="checkbox"
                                                  <?php echo $pm_reply; ?> />О личных сообщения</label>
            </td>
        </tr>
        <tr>
            <td>Статус</td>
            <td><select name='juse'>
                    <option value="0">Нет</option>
                    <option <?php echo $juick; ?> value="1">Juick</option>
                    <option <?php echo $twitter; ?> value="2">Twitter</option>
                </select> <label><input type='text' name='jname'
                                        value="<?php echo $micro_name; ?>" /></label>
            </td>
        </tr>
        <tr>
            <td>Я в</td><td><div id="me_on"><?php if ($me_on_count==0) {?>
                <input type="text" name="me_on_name1" id="me_on_name1" value="Название сервиса"/>
                <input type="text" name="me_on_url1" id="me_on_url1" value="Адрес вашей страницы" /><br id="br_1" />
                </div>
                <input type="hidden" name="me_on_count" id="me_on_count" value="1" />
                <?php } else { $i=1; foreach ($me_on as $name=>$url) {?>
                <input type="text" name="me_on_name<?php echo $i; ?>" id="me_on_name<?php echo $i; ?>" value="<?php echo $name; ?>"/>
                <input type="text" name="me_on_url<?php echo $i; ?>" id="me_on_url<?php echo $i; ?>" value="<?php echo $url; ?>" /><br id="br_<?php echo $i; ?>" />
                    <?php $i++; }?></div><input type="hidden" id="me_on_count" name="me_on_count" value="<?php echo $i-1; ?>" /> <?php } ?>
<a href="javascript:add_me_on()">Добавить</a> <a href="javascript:rm_me_on()">Убрать</a> 
            </td>
        </tr>
    </table>
    <input type="submit" class="tag_w6" value="Сохранить всё это" /></form>
Аватар:<?php if ($av_use) {?>
<img src="res.php?t=av&img=<?php echo $av; ?>" alt="" /><?php } ?>
Изображение резрешением не больше, чем 70х70 пикселей. Максимальный объём 100кб.
<form method="post" enctype="multipart/form-data"
      action="twork.php?wt=img"><input type="file" name="img" /> <input
        type="submit" value="Загрузить" /></form>
    <?php
    if ($error) {
        ?>
<i>Неправильные данные!</i>
    <?php } ?>