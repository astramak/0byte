<?php
$post_id = request::get_get('post');
$blog_id = request::get_post('blog');
$title = request::get_post('title');
$text = request::get_post('text');
$lnk = request::get_post('lnk');

if ($blog_id) {
	$blog = db_result(db_query('SELECT name FROM blogs WHERE id = %d', $blog_id));
} else {
	$blog = "own";
}

$result = db_query('SELECT * FROM post WHERE id = %d', $post_id);
$row= db_fetch_assoc($result);
if (($usr->lvl > $elvl || $usr->login == $row['auth']) && (($title && $text) || $row['tp'] == 3)) {
	$lock = request::get_post('lock') == 'on' ? 1 : 0;

	$tag = tags_add_list(request::get_post('tag'));
	tags_remove_list($row['tag']);

	if ($row['tp'] == 3) {
		db_query('UPDATE post SET `lock` = %d, tag = %s, blog = %s, blogid = %d, lnk = %s WHERE id = %d',
			$lock, $tag, $blog, $blog_id, $lnk, $post_id);
	} else {
		$tz = new dtxt();
		$tz->cut($text);

		db_query('UPDATE post SET title = %s, text = %s, ftext = %s, `lock` = %d, blog = %s, blogid = %d, tag = %s, lnk = %s WHERE id = %d',
			$title, $tz->short_text, $tz->full_text, $lock, $blog, $blog_id, $tag, $lnk, $post_id);
	}
	redirect("post/" . $post_id);
} else {
	redirect('index.php');
}

?>