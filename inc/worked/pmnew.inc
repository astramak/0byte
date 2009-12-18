<?php
$name=null;
if (request::get_get('name',0)) {
    $alien=new user;
    if ($alien->find(request::get_get('name'))!=0 ) {
        $name=request::get_get('name'); }
}
$text=render_template(TPL_PM.'/new.tpl.php', array('name'=>$name));
$js='mk("rd","pm");';
if (@$script && !@$json) $script->add($js);
if (!@$json) {
    echo $text;
}
?>
