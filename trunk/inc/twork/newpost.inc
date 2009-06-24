<?php
$title = trim(request::get_post('title'));
$text = trim(request::get_post('text'));
$len = request::get_post('len');
$blog_id = request::get_post('blog');
$tp = request::get_get('tp');
$lnk = request::get_post('lnk');
$org = request::get_post('org');

if(!$title || (!$text && !$len) || strlen($title) < 2) {
	redirect('index.php');
} elseif ($blog_id == 0) {
	$blog = "own";
} else {
	$blog = db_result(db_query('SELECT name FROM blogs WHERE id = %d', $blog_id));
}

$tag = tags_add_list(request::get_post('tag'));
$tz = new dtxt();
$tz->cut($text);
$lock = request::get_post('lock') == 'on' ? 1 : 0;
$time=time();

switch ($tp) {
	case 0:
		db_query('INSERT INTO `post` SET `date` = %s, `title` = %s, `auth` = %s, `text` = %s,
			`ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d ',
			$time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
			$blog_id, $tag, $lock, $tp);
		break;

	case 1:
		if (!$lnk) {
			redirect('index.php');
		}
		db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
			`ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s',
			$time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
			$blog_id, $tag, $lock, $tp, $lnk);
		break;

	case 2:
		if ($org) {
			redirect('index.php');
		}
		db_query('INSERT INTO `post` SET `date` = %d, `title` = %s, `auth` = %s, `text` = %s,
			`ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s',
			$time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
			$blog_id, $tag, $lock, $tp, $org);
		break;

	case 3:
		if (!$len) {
			redirect('index.php');
		}
		$nm = request::get_post('mng') == 'on' ? 1 : 0;
		db_query('INSERT INTO `post` SET (`date` = %d, `title` = %s, `auth` = %s, `text` = %s,
			`ftext` = %s, `blog` = %s, `blogid` = %d, `tag` = %s, `lock` = %d, `tp` = %d, `lnk` = %s',
			$time, $title, $usr->login, $tz->short_text, $tz->full_text, $blog,
			$blog_id, $tag, $lock, $tp, $nm);
		break;
}

$id = db_last_insert_id('post');
if ($tp == 3) {
	for ($i = 0; $i < $len; $i++) {
		$question = trim(request::get_post('an' . ($i + 1)));
		if ($question) {
			db_query('INSERT INTO `answ` SET `title` = %s, `id` = %d', $question, $id);
		}
	}
}

redirect("post/" . $id)
?>