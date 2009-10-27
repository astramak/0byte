<?php
$hml = request::get_post('hml') == 'on' ? 1 : 0;
$pr = request::get_post('pr') == 'on' ? 1 : 0;
$cr = request::get_post('cr') == 'on' ? 1 : 0;
$pmr = request::get_post('pmr') == 'on' ? 1 : 0;
$num=request::get_post('me_on_count');

$arr=null;
if (request::get_post('me_on_url1')!="Адрес вашей страницы") { //i can fix it
    for ($i=1;$i<=$num;$i++) {
        if (request::get_post('me_on_url'.$i)!="Адрес вашей страницы") {
            $arr[gtext(request::get_post('me_on_name'.$i))]=gtext(request::get_post('me_on_url'.$i));
        }
    }
    $other=json_encode($arr);
} else {
    $other=null;
}
db_query('UPDATE users SET icq = %s, hml = %d, mail = %s, jabber = %s,
	site = %s, about = %s, postre = %d, comre = %d, pmre = %d,
	juse = %d, jname = %s, jdate = "", city = %s, timezone = %d, other = %s WHERE name = %s',
    gtext(request::get_post('icq')), $hml, gtext(request::get_post('mail')),
    gtext(request::get_post('jabber')), gtext(request::get_post('site')),
    gtext(request::get_post('about')), $pr, $cr, $pmr, request::get_post('juse'),
    gtext(request::get_post('jname')), gtext(request::get_post('city')),gtext(request::get_post('timezone')), $other, $usr->login);

redirect('user/');
?>