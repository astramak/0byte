<?php
header("Content-Type: text/html; charset=utf-8");
$type=request::get_get('type',null);
$out['id']='mn';
$needle=array('fr'=>request::get_get('fr'),'el'=>request::get_get('el'));
$out['clean']=1;
switch ($type) {
    case "link":
        $out['content']=render_template(TPL_EDITOR.'/link.tpl.php',$needle);
        break;
    case "code":
        $out['content']=render_template(TPL_EDITOR.'/code.tpl.php',$needle);
        break;
    case "image":
        $out['content']=render_template(TPL_EDITOR.'/image.tpl.php',$needle);
        break;
    case "list":
        $out['content']=render_template(TPL_EDITOR.'/list.tpl.php',$needle);
        break;
//    case "head":
//        $out['content']=render_template(TPL_EDITOR.'/head.tpl.php',$needle);
//        $out['id']=request::get_get('el');
//    break;
    case "color":
        $out['content']=render_template(TPL_EDITOR.'/color.tpl.php',$needle);
        break;
    case "block":
        $out['content']=render_template(TPL_FRAMES.'/cause.tpl.php', array('type'=>request::get_get('el'),
    'url'=>"twork.php?wt=ban&who=".request::get_get('fr')."&cur=user/".request::get_get('fr')."&unb=0",'js'=>1));
        break;
}
echo json_encode($out);
?>