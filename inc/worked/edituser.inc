<?php
$usr->find($usr->login);
$hml=null;
$pr=null;
$cr=null;
$pmr=null;
$juick=null;
$twitter=null;
if ($usr->pr==1) {$pr=" checked ";}
if ($usr->cr==1) {$cr=" checked ";}
if ($usr->pmr==1) {$pmr=" checked ";}
if ($usr->hml==1) {$hml=" checked ";}
if ($usr->g_j()==1) {$juick=" selected ";}
if ($usr->juse==2) {$twitter=" selected ";}
if (strlen($usr->av)>2) {
    $avatar=1;
} else $avatar=0;
$me_on=$usr->get_me_on();
if ($usr->juse!=0) {$mn=$usr->jname;} else { $mn="Ник в микроблоге";}
echo render_edit_user(array('mail'=> trim($usr->mail),'show_mail'=>$hml,'icq'=>trim($usr->icq),
'jabber'=>utext(trim($usr->jabber)),'city'=>utext(trim($usr->city)),'login'=>$usr->login,
'usite'=>utext(trim($usr->site)),'about'=>utext(trim($usr->about)),
'post_reply'=>$pr,'comment_reply'=>$cr,'pm_reply'=>$pmr,'juick'=>$juick,
'twitter'=>$twitter,'micro_name'=>$mn,'av_use'=>$avatar,'av'=>$usr->av,'error'=>request::get_get('err',0),'timezone'=>$usr->timezone
,'me_on'=>$me_on,'me_on_count'=>count($me_on)?count($me_on):0));
?>
