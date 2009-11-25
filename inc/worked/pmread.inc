<?php
$row=db_fetch_assoc(db_query("SELECT * FROM `pm` WHERE `id` = %d &&
 (`to` = %s || `auth` = %s) ORDER BY  id DESC  ",request::get_get('id'),$usr->login,$usr->login));
if ($row['id']==request::get_get('id')) {
    echo render_template(TPL_PM."/top.tpl.php", array('id'=>intval(request::get_get('id')),'login'=>$usr->login));
    pm_echo($row);
    db_query("UPDATE `pm` SET `readed` = '1' WHERE `id` = %d",request::get_get('id'));
}
?>
