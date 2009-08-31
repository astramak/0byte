<?php
$name=null;
if (request::get_get('name',0)) {
    $alien=new user;
    if ($alien->find(request::get_get('name'))!=0 ) {
        $name=request::get_get('name'); }
}
echo render_template(TPL_PM.'/new.tpl.php', $name);
$script->add(`mk("rd","pm");`);
?>
