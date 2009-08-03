<?php
//$sql_get="SELECT * FROM `post` WHERE id = '".intval($_GET['post'])."'   ";
if (request::get_get('draft',0)) {
    $row=db_fetch_assoc(db_query('SELECT * FROM `draft` WHERE id = %d',request::get_get('post')));
    $row['blogid']=$row['blog'];
} else {
    $row=db_fetch_assoc(db_query('SELECT * FROM `post` WHERE id = %d',request::get_get('post')));
}
if ($usr->login==$row['auth'] || $usr->lvl>$elvl) {
	if (!request::get_get('draft',0)) {
            $zz=$row['ftext'];
            if (strpos($row['text'],"[fcut]")) {
                    $zz=$row['text'].$row['ftext'];
            }
        } else {
            $zz=$row['text'];
        }
	$h=null;
	if ($row['lock']==1) {
		$h='checked="checked"';
	}
        $mng=null;
        if ($row['lnk']==1) {
		$mng='checked="checked"';
	}
   		$sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."'  ";
		$resul=mysql_query($sql_get,$sql);
		if (!$resul) {
			echo  mysql_error();
		}
        $blogs[]=array('value'=>'own','text'=>'Персональный','active'=>null);
		while ($rw = mysql_fetch_assoc($resul)) {
			if ($rw['blogid']==$row['blogid']) {$fin='selected';} else {$fin="";}
               $blogs[]=array('value'=>$rw['blogid'],'text'=>$rw['bname'],'active'=>$fin);
//			echo "<option value='".$rw['blogid']."' $fin >".$rw['bname']."</option>";
		}
        $type=null;
        if ($row['tp']==3) {
            $type='answer';
        } else if  ($row['tp']==2) {
            $type='translate';
        } else  if ($row['tp']==1) {
            $type='link';
        }
        if ($row['tp']==3 && request::get_get('draft',0)) {
            $answers = explode(' ', $row['text']);
            trim_array($answers);
            echo render_template(TPL_FRAMES.'/draft_answer.tpl.php', array('url'=>"twork.php?wt=editpost&post=".intval(request::get_get('post')),
                'title'=>$row['title'],'blogs'=>$blogs,'len'=>count($answers),'answers'=>$answers,'tag'=>$row['tag'],'status'=>$h,'mng'=>$mng));
        } else echo render_edit_post(utext($row['title']), $blogs, "twork.php?wt=editpost&post=".intval(request::get_get('post')),
        $type, $row['tag'], $h, $zz, $row['lnk'],$draft=request::get_get('draft',0));
////	echo '
////		<h3>Редактирование сообщения</h3>';
////	echo '<form id="new" name="new" method="post" action="twork.php?wt=editpost&post='.intval($_GET['post']).'">';
//	if ($row['tp']==3) {
//		echo '<b>В опросах запрещено изменять вопрос и ответы, для редактирования доступны только теги и доступ!</b>
//			<br />
//Блог<select name="blog">
//		<option value="own">Персональный</option>';
//

//		echo "</select> <br />
//			Тэги ".'<input type="text" name="tag" style="width: 500px;" value="'.$row['tag'].'"/><br />';
//	} else {
//		echo '
//		<form name="new" id="new" method="post" action="twork.php?wt=editpost&post='.$_GET['post'].'">
//			<div id="prv"></div>
//		<table border="0" class="fullwidth">
//		<tr><td>Заголовок</td><td><input type="text" name="title" class="post-title" value="'.utext($row['title']).'" /></td></tr>
//		<tr><td>Блог</td><td><select name="blog">
//		<option value="own">Персональный</option>';
//
//		$sql_get="SELECT * FROM `inblog` WHERE name = '".$usr->login."'  ";
//		$resul=mysql_query($sql_get,$sql);
//		if (!$resul) {
//			echo  mysql_error();
//		}
//		while ($rw = mysql_fetch_assoc($resul)) {
//			if ($rw['blogid']==$row['blogid']) {$fin=' selected ';} else {$fin="";}
//
//			echo "<option value='".$rw['blogid']."' $fin >".$rw['bname']."</option>";
//		}
//
//		echo '</select> </td></tr>
//		<tr><td id="otxt">Текст</td><td><div id="mq" class="inpt"></div>
//		<textarea class="post-body" onkeypress="do_key(this.form,\'new\',event);" onkeydown="if(\'\v\'==\'v\') {do_key(this.form,\'new\',event);}" name="text" rows="15" cols="70">'.utext($zz).'</textarea>
//		</td></tr>
//		<tr><td>Тэги</td><td><input type="text" name="tag" class="post-tags" value="'.$row['tag'].'"/>
//		</td></tr>';
//		if  ($row['tp']==2) {
//			echo "<tr><td>Оригинал</td><td><input type='text' name='lnk' value='".$row['lnk']."' /></td></tr>";
//		} else if ($row['tp']==1) {
//			echo "<tr><td>Ссылка</td><td><input type='text' name='lnk' value='".$row['lnk']."' /></td></tr>";
//		}
//		echo '</table> '; }
//		echo '<input type="checkbox" name="lock" '.$h.' /> Только для друзей/собложников<br />
//		<input type="submit" value="Запостить!" />
//		</form>';
} else {
	render_error("Это не ваш пост!");
}
$script->add(`mk('mq','new');
document.getElementById("otxt").innerHTML+="<br /><a href='javascript:prv()'>Предпросмотр</a>";
		document.getElementById("mq").innerHTML+="<a class='tdx' href='javascript:insert(\"[cut]\",\"\",\"new\",\"text\")'>cut</a>"+
		"<a class='tdx' href='javascript:insert(\"[fcut]\",\"\",\"new\",\"text\")'>fcut</a>";`);
?>
