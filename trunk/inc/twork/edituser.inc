<?php
$hml = request::get_post('hml') == 'on' ? 1 : 0;
$pr = request::get_post('pr') == 'on' ? 1 : 0;
$cr = request::get_post('cr') == 'on' ? 1 : 0;
$pmr = request::get_post('pmr') == 'on' ? 1 : 0;

db_query('UPDATE users SET icq = %s, hml = %d, mail = %s, jabber = %s,
	site = %s, about = %s, postre = %d, comre = %d, pmre = %d,
	juse = %d, jname = %s, jdate = "", city = %s, timezone = %d WHERE name = %s',
    request::get_post('icq'), $hml, request::get_post('mail'),
    request::get_post('jabber'), request::get_post('site'),
    request::get_post('about'), $pr, $cr, $pmr, request::get_post('juse'),
    request::get_post('jname'), request::get_post('city'),request::get_post('timezone'), $usr->login);

redirect('user/');
?>