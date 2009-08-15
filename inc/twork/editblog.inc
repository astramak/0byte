<?php
if (request::get_get('single',0) && $usr->lvl>=$elvl) {
    db_query('UPDATE `blogs` SET `about` = %s , `name` = %s WHERE id = %d',
	request::get_post('text'), request::get_post('name'), request::get_get('bid'));
    redirect('blog/'.request::get_get('bid'));
} else {
db_query('UPDATE blogs SET about = %s WHERE owner = %s AND id = %d',
	request::get_post('text'), $usr->login, request::get_request('bid'));
redirect('work/myblog');
}
?>