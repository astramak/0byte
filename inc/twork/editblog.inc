<?php
db_query('UPDATE blogs SET about = %s WHERE owner = %s AND id = %d',
	request::get_post('text'), $usr->login, request::get_request('bid'));
redirect('work/myblog');
?>