<h2>Справка!</h2>
<h3>Разделение поста, или [cut], [fcut]</h3>
<h4>[cut]</h4>
Этот тег разделяет пост так, что в группе сообщений будет видно только
то, что до него, а в самом сообщении обе части.
<br />
Например:
<br />
Сообщение:
<i>Привет [cut] пока</i>
<br />
В группе:
<i>Привет</i>
В самом:
<i>Привет пока</i>
<br />
<h4>[fcut]</h4>
Этот тeг разделяет пост так, что в группе сообщений будет видно только
то, что до него, а в самом сообщении то, что после него.
<br />
Например:
<br />
Сообщение:
<i>Привет [fcut] пока</i>
<br />
В группе:
<i>Привет</i>
В самом:
<i>пока</i>
<br />
<h3>Форматирование</h3>
[b]жирный[/b] -
<b>жирный</b>
<br />
[i]курсив[/i] -
<i>курсив</i>
<br />
[u]подчёркивание[/u] -
<u>подчёркивание</u>
<br />
[del]перечёкивание[/del] -
<del>перечёркивание</del>
<br />
[ins]текст[/ins] -
<ins>написанный позднее</ins>
<br />
[h1][/h1],[h2][/h2],[h3][/h3] - Заголовок раздела
<br />
[color:red]цвет[/color] -
<span style="color: red">цвет</span>
, где вместо &#171;red&#187; любой другой цвет
<br />
[size:16][/size] -
<span style="font-size: 16px">размер</span>
, где вместо &#171;16&#187; любой другой размер
<br />
[left][/left] и [right][/right] - выравнивание влево и вправо, пример:
<br />
<span style="float: left">лево</span>
<span style="float: right">право</span>
<h4>Таблицы</h4>
Любая таблица должна начинаться с
<b>[table]</b>
и заканчиваться
<b>[/table]</b>
. Каждая строка должна начинаться с
<b>[tr]</b>
и заканчиваться на
<b>[/tr]</b>
. Каждая ячейка в строке должна начинаться с
<b>[td]</b>
и заканчиваться
<b>[/td]</b>
Элементы шапки рекомендуется писать как
<b>[th][/th]</b>
. Шапку тоже нужно выдялять в
<b>[tr][/tr]</b>
</b>
<br />
Пример:
<br />
Код -
[table][tr][th]1h[/th][th]2h[/th][/tr][tr][td]1[/td][td]2[/td][/tr][tr][td]3[/td][td]4[/td][/tr][/table]
<br />
Выход:
<br />
<table>
	<tr>
		<th>1h</th>
		<th>2h</th>
	</tr>
	<tr>
		<td>1</td>
		<td>2</td>
	</tr>
	<tr>
		<td>3</td>
		<td>4</td>
	</tr>
</table>
<h4>Списки</h4>
<h5>Обычные</h5>
Ненумерованный список должен начинаться с
<b>[ul]</b>
и заканчиваться
<b>[/ul]</b>
, а нумерованный с
<b>[ol]</b>
и на
<b>[/ol]</b>
. Элемент списка должен начинаться с
<b>[li]</b>
и заканчиваться на
<b>[/li]</b>
, пример:
<br />

<div style="float: left">Нумерованный ([ol][li]1[/li][li]2[/li][/ol]):
<ol>
	<li>1</li>
	<li>2</li>
</ol>
</div>
<div style="float: right">Ненумерованный
([ul][li]1[/li][li]2[/li][/ul]):
<ul>
	<li>1</li>
	<li>2</li>
</ul>
</div>
<h5 style="margin-top: 100px;">Многоуровневые</h5>
Многоуровневый список начинается с
<b>[dl]</b>
и заканчивается на
<b>[/dl]</b>
. Первый уровень находится в
<b>[dt][/dt]</b>
, второй уровень в
<b>[dd][/dd]</b>
, например:
<br />
Код: [dl][dt]1[/dt][dd]1a[dd]1b[/dd][dt]2[/dt][dd]2a[/dd][/dl]
<dl>
	<dt>1</dt>
	<dd>1a
	
	
	<dd>1b</dd>
	<dt>2</dt>
	<dd>2a</dd>
</dl>
<h4>Изображение</h4>
[img=альтернативный текст][/img] - изображение с альтернативным текстом
(отображается если картинки отключены)
<br />
[img][/img] - изображение, пример:
<br />
<img
	src="img/res.php?fl=1223455122.jpeg">
<br />
<h4>Ссылки</h4>
[url=http://.ru][/url] -
<a href="http://.ru">ссылка</a>
<br />
[url]http://.ru[/url] -
<a href="http://.ru">http://.ru</a>
<br />
<br />
<br />
По всем вопросам nvbn.rm@gmail.com