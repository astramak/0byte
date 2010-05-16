<?php

function description() {
	return <<<EOF
Create the initial structure if it doesn't exists
EOF;
}

function checkTable($tables, $tableName, $sql) {
	if (!in_array($tableName, $tables)) {
		ulog('Creating ' . $tableName . ' table');
		
		if (!DB::exec($sql))
			return false;
			
		ulog('  Success');
	} else {
		ulog('Table ' . $tableName . ' already exists');
	}
	
	return true;
}

function update() {
	$tables = DB::tables();
	
	if (!checkTable($tables, 'answ', '
CREATE TABLE `answ` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `val` int(11) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'block_user', '
CREATE TABLE `block_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user` text COLLATE utf8_unicode_ci NOT NULL,
  `cause` text COLLATE utf8_unicode_ci NOT NULL,
  `end` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
	
	if (!checkTable($tables, 'blogs', '
CREATE TABLE `blogs` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `owner` text COLLATE utf8_unicode_ci NOT NULL,
  `ratep` int(11) NOT NULL DEFAULT \'0\',
  `ratem` int(11) NOT NULL DEFAULT \'0\',
  `av` text COLLATE utf8_unicode_ci NOT NULL,
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'brate', '
CREATE TABLE `brate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` text COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'comment', '
CREATE TABLE `comment` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `who` text COLLATE utf8_unicode_ci NOT NULL,
  `cid` int(11) NOT NULL,
  `ratep` int(11) NOT NULL DEFAULT \'0\',
  `ratem` int(11) NOT NULL DEFAULT \'0\',
  `lvl` int(11) NOT NULL DEFAULT \'0\',
  `krnl` int(11) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
	
	if (!checkTable($tables, 'crate', '
CREATE TABLE `crate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` text COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'draft', '
CREATE TABLE `draft` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `tag` text COLLATE utf8_unicode_ci NOT NULL,
  `blog` int(11) NOT NULL,
  `lnk` text COLLATE utf8_unicode_ci NOT NULL,
  `lock` tinyint(4) NOT NULL DEFAULT \'0\',
  `tp` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'eye', '
CREATE TABLE `eye` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `who` tinytext CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;'))
		return false;
		
	if (!checkTable($tables, 'favourite', '
CREATE TABLE `favourite` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `who` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'hist', '
CREATE TABLE `hist` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` text COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL,
  `date` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
	
	if (!checkTable($tables, 'inblog', '
CREATE TABLE `inblog` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `blogid` text COLLATE utf8_unicode_ci NOT NULL,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `bname` text COLLATE utf8_unicode_ci NOT NULL,
  `out` int(11) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
	
	if (!checkTable($tables, 'lenta', '
CREATE TABLE `lenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `uid` int(11) NOT NULL,
  `type` int(11) NOT NULL,
  `who` text COLLATE latin1_general_ci NOT NULL,
  `date` text COLLATE latin1_general_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_general_ci;'))
		return false;
	
	if (!checkTable($tables, 'menu', '
CREATE TABLE `menu` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `url` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=5;'))
		return false;
		
	$max_menu = DB::selectFirstVal('select max(id) from menu');
	
	if (!$max_menu)
		$max_menu = 0;
		
	if ($max_menu == 0) {
		ulog('  Filling menu table with sample content');
		
		DB::exec('
INSERT INTO menu (id, name, url)
SELECT 2, \'Тематические\', \'main\';');

		DB::exec('
INSERT INTO menu (id, name, url)
SELECT 3, \'Персональные\', \'pers\';');

		DB::exec('
INSERT INTO menu (id, name, url)
SELECT 1, \'Все\', \'.\';');

		DB::exec('
INSERT INTO menu (id, name, url)
SELECT 4, \'Лента\', \'lenta\';');
	}
		
	if (!checkTable($tables, 'pm', '
CREATE TABLE `pm` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `auth` text COLLATE utf8_unicode_ci NOT NULL,
  `to` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `date` text COLLATE utf8_unicode_ci NOT NULL,
  `readed` int(11) NOT NULL DEFAULT \'0\',
  `dto` int(11) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
	
	if (!checkTable($tables, 'post', '
CREATE TABLE `post` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` text COLLATE utf8_unicode_ci NOT NULL,
  `title` text COLLATE utf8_unicode_ci NOT NULL,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `auth` text COLLATE utf8_unicode_ci NOT NULL,
  `ratep` int(11) NOT NULL,
  `ratem` int(11) NOT NULL,
  `ftext` text COLLATE utf8_unicode_ci NOT NULL,
  `blog` text COLLATE utf8_unicode_ci NOT NULL,
  `blogid` int(11) NOT NULL,
  `tag` text COLLATE utf8_unicode_ci NOT NULL,
  `lock` int(11) NOT NULL DEFAULT \'0\',
  `blck` tinyint(4) NOT NULL DEFAULT \'0\',
  `tp` tinyint(4) NOT NULL DEFAULT \'0\',
  `lnk` text COLLATE utf8_unicode_ci NOT NULL,
  `flw` text COLLATE utf8_unicode_ci NOT NULL,
  `top` int(11) NOT NULL DEFAULT \'0\',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'rate', '
CREATE TABLE `rate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` text COLLATE utf8_unicode_ci NOT NULL,
  `pid` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'restore', '
CREATE TABLE `restore` (
  `id` int(11) NOT NULL,
  `user` text NOT NULL,
  `code` text NOT NULL,
  `pwd` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=cp1251;'))
		return false;
		
	if (!checkTable($tables, 'tags', '
CREATE TABLE `tags` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text COLLATE utf8_unicode_ci NOT NULL,
  `num` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'urate', '
CREATE TABLE `urate` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `who` text COLLATE utf8_unicode_ci NOT NULL,
  `pid` text COLLATE utf8_unicode_ci NOT NULL,
  `type` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'users', '
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `mail` text COLLATE utf8_unicode_ci NOT NULL,
  `icq` text COLLATE utf8_unicode_ci NOT NULL,
  `jabber` text COLLATE utf8_unicode_ci NOT NULL,
  `site` text COLLATE utf8_unicode_ci NOT NULL,
  `lvl` int(11) NOT NULL,
  `pwd` text COLLATE utf8_unicode_ci NOT NULL,
  `ratep` int(11) NOT NULL DEFAULT \'0\',
  `ratem` int(11) NOT NULL DEFAULT \'0\',
  `about` text COLLATE utf8_unicode_ci NOT NULL,
  `av` text COLLATE utf8_unicode_ci NOT NULL,
  `frnd` text COLLATE utf8_unicode_ci NOT NULL,
  `lck` tinyint(4) NOT NULL DEFAULT \'0\',
  `hml` int(11) NOT NULL,
  `activ` int(11) NOT NULL DEFAULT \'1\',
  `ref` int(11) NOT NULL DEFAULT \'0\',
  `postre` tinyint(4) NOT NULL DEFAULT \'1\',
  `comre` tinyint(4) NOT NULL DEFAULT \'1\',
  `pmre` tinyint(4) NOT NULL DEFAULT \'1\',
  `online` text COLLATE utf8_unicode_ci NOT NULL,
  `prate` int(11) NOT NULL DEFAULT \'0\',
  `crate` int(11) NOT NULL DEFAULT \'0\',
  `brate` int(11) NOT NULL DEFAULT \'0\',
  `juse` tinyint(4) NOT NULL DEFAULT \'0\',
  `jdate` text COLLATE utf8_unicode_ci NOT NULL,
  `jtext` text COLLATE utf8_unicode_ci NOT NULL,
  `jname` text COLLATE utf8_unicode_ci NOT NULL,
  `jabre` tinyint(4) NOT NULL DEFAULT \'0\',
  `city` tinytext COLLATE utf8_unicode_ci NOT NULL,
  `timezone` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	if (!checkTable($tables, 'wansw', '
CREATE TABLE `wansw` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cid` int(11) NOT NULL,
  `who` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;'))
		return false;
		
	return true;
}
