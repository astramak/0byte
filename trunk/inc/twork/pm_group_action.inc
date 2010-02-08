<?php
$ids=json_decode(base64_decode(request::get_post('ids')));
$action=request::get_post('delete','no')!='no'?1:(request::get_post('mark','no')!='no'?2:0);
$limit=0;
$sql=null;
foreach ($ids as $id) {
    if (request::get_post('pmc_'.$id,'off')=='on') {
        $sql.='`id` = '.get_int($id).' ||';
        if ($action==1) {
            pm_del(get_int($id));
        }
        $limit++;
    }
}
$sql=substr($sql, 0, strlen($sql)-2);
if ($action==2) {
    db_query("UPDATE `pm` SET `readed` = '1' WHERE (`to` = %s) && ( ".$sql." )",$usr->login);
    echo db_error();
    deleteCache('top_'.$usr->login.'.cache');
}
if (!request::get_get('json',0)) {
    redirect('work/pmls'.(request::get_post('type','to')=='auth'?'/out':''));
}
?>
