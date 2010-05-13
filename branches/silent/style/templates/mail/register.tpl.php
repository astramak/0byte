Для продолжения регистрации перейдите
<a href="<?php print $site ?>active.php?id=<?php print $id ?>&name=<?php print $name ?>">по этой ссылке</a>
<br><br>
--</br>
<?
$random_text = array("Умеющий читать робот-рассыльщик welinux.ru",
                    "Любящий всё живое робот-рассыльщик welinux.ru",
                    "Потрясающий артист, робот-рассыльщик welinux.ru",
                    "Просто робот-рассыльщик welinux.ru",
                    "Совсем не спам, просто робот-рассыльщик welinux.ru",
					"Бритый робот-рассыльщик welinux.ru",
					"Не смешной робот-рассыльщик welinux.ru",
					"Смешной рандомный текст про робота-рассыльщика welinux.ru",);
srand(time());
$sizeof = count($random_text);
$random = (rand()%$sizeof);
print("$random_text[$random]");
?>