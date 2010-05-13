<?php print $user ?> отправил вам <a href="<?php echo $site, 'work/pmread/', $pm_id ?>">личное сообщение</a>
<br /><br />
--<br/>
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