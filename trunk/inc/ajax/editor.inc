<?php
header("Content-Type: text/html; charset=utf-8");
$type=request::get_get('type',null);
$out['id']='mn';
$needle=array('fr'=>request::get_get('fr'),'el'=>request::get_get('el'));
$out['clean']=1;
$out['type']=$type;
switch ($type) {
    case "link":
        $out['select']='ins_url';
        $needle['type'] = 'Ссылка';
        $needle['action'] = 'urla';
        $out['content']=render_template(TPL_EDITOR.'/media.tpl.php',$needle);
        break;
    case "code":
        $out['select']="codelang";
        $out['content']=render_template(TPL_EDITOR.'/code.tpl.php',$needle);
        break;
    case "image":
        $out['select']='img_url';
        $out['content']=render_template(TPL_EDITOR.'/image.tpl.php',$needle);
        break;
    case "list":
        $out['content']=render_template(TPL_EDITOR.'/list.tpl.php',$needle);
        break;
    case "color":
        $out['content']=render_template(TPL_EDITOR.'/color.tpl.php',$needle);
        break;
    case "block":
        $out['content']=render_template(TPL_FRAMES.'/cause.tpl.php', array('type'=>request::get_get('el'),
    'url'=>"twork.php?wt=ban&who=".request::get_get('fr')."&cur=user/".request::get_get('fr')."&unb=0",'js'=>1));
        break;
    case "blockpost":
        $json=1;
        include 'inc/worked/bpost.inc';
        break;
    case "delete_user":
        $json=1;
        include 'inc/worked/delete_user.inc';
        break;
    case "new_post":
        $json=1;
        include 'inc/worked/newpost.inc';
        $out['text']=$text;
        $out['js']=$js;
        break;
    case "new_pm":
        $json=1;
        include "inc/worked/pmnew.inc";
        $out['content']=$text;
        $out['js']=$js;
        $out['select']='pm_title';
        break;
    case "video":
        $out['select']='ins_url';
        $needle['type'] = 'Видео';
        $needle['action'] = 'videoa';
        $out['content']=render_template(TPL_EDITOR.'/media.tpl.php',$needle);
        break;
    case "audio":
        $out['select']='ins_url';
        $needle['type'] = 'Аудио';
        $needle['action'] = 'audioa';
        $out['content']=render_template(TPL_EDITOR.'/media.tpl.php',$needle);
        break;
}
echo json_encode($out);
?>
