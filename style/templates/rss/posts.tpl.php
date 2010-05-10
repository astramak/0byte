<?php print '<?xml version="1.0" encoding="utf-8"?>' . "\r\n" ?>
<rss version="2.0">
	<channel>
		<title><?php print htmlspecialchars($title) ?></title>
		<link><?php print $link ?></link>
		<description><?php print htmlspecialchars($title) ?>; rss канал</description>
		<language>ru-ru</language>
		<generator>0byte</generator>
		<pubDate><?php print date('r', (isset($items[0]) ? $items[0]['date'] : time())) ?></pubDate>
		<image>
		<link>http://welinux.ru/</link>
		<url>http://welinux.ru/style/img/source.png</url>
		<title><?php print htmlspecialchars($title) ?></title>
		</image>

		<?php foreach ($items as $item): ?>
		<item>
			<title><?php print htmlspecialchars($item['blogid'] ? $item['blog'] : $item['auth']) ?> &#8212; <?php print htmlspecialchars($item['title']) ?></title>
			<link><?php echo $site, 'post/', $item['id'], '/' ?></link>
			<description><?php print htmlspecialchars($item['descr']) ?></description>
			<pubDate><?php print date('r', $item['date']) ?></pubDate>
			<author><?php print $item['auth'] ?></author>
			<guid><?php echo $site. 'post/'. $item['id']. '/'; ?></guid>
		</item>
		<?php endforeach; ?>
	</channel>
</rss>