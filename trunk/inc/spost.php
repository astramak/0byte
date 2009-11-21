<?php
/*
 *     This file is part of 0byte.
 *
 *  0byte is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 2 of the License.
 *
 *  0byte is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  See <http://www.gnu.org/licenses/>.
 *
 */
$last_com_id=0;
$jstocom="var com_arr=new Array();";
$num_com=0;

$post_id = intval(request::get_get('post'));

$cur=$_SERVER['REQUEST_URI'];
$cur=str_replace("&","*amp",$cur);
$cur=str_replace("?","*qw",$cur);

$row = db_fetch_assoc(db_query('SELECT * FROM post WHERE id = %d', $post_id));
if (!$row) {
    redirect($dir.'error/not_found');
} else if ($row['blck']==1 && $usr->lvl<$blvl) {
    //        echo render_error("У вас недостаточно прав для просмотра данной страницы!");
        redirect($dir.'error/not_allow');
    } else {
    //spy
        if ($loged == 1) {
            $rw = db_fetch_assoc(db_query('SELECT `id`,`date` FROM hist WHERE `pid` = %d && `who` = %s', $post_id, $usr->login));
            $v_id=$rw['id'];
            $v_date=$rw['date'];
        }
        ///spy
        $post=post_echo($row,1);
        $allow_remove=0;
        $blck=$row['blck'];
        $allow_comment=($blck-$blck%100)/100;
        $allow_rate=($blck%100-$blck%10)/10;
        $blck=$blck%10;
        $block_url=null;
        $remove_url=null;
        if ($usr->lvl>=$rlvl) {
            $allow_remove=1;
            $block_url="work/blockpost/".$post_id;
            $remove_url="work/rmpost/".$post_id;
        }
        $allow_edit=0;
        if ($usr->login==$row['auth'] || $usr->lvl>=$elvl) {
            $allow_edit=1;
        }
        $allow_spy=0;
        if ($usr->login!=$row['auth'] && $loged==1) {
            $allow_spy=1;
            if (strpos($post->flw,$usr->login)===false) {
                $spyed=0;
                $spy_url="twork.php?wt=flw&id=".$post_id;
            } else {
                $spyed=1;
                $spy_url="twork.php?wt=flw&id=".$post_id."&un=1";
            }
        }
        $rate=$post->rate();
        $tags=null;
        if (strlen($row['tag'])>2) {
            $arr=split(",", $row['tag']);
            $q=sizeof($arr);
            for ($z=0; $z<$q; $z++) {
                $tags[] = trim($arr[$z]);
            }

        }
        $favourite=$loged==1?db_num_rows(db_query("SELECT `who`,`pid` FROM `favourite` WHERE `pid` = %d && `who`= %s",$post->id,$usr->login)):0;
        echo render_template(TPL_FRAMES.'/single_post.tpl.php', array('id'=>$post->id,'tags'=>$tags,
        'allow_edit'=>$allow_edit,'allow_remove'=>$allow_remove,'allow_spy'=>$allow_spy,
        'spy_url'=>@$spy_url,'spyed'=>@$spyed,'block_url'=>$block_url,'blocked'=>$blck,
        'rate'=>$rate,'ratep_url'=>"twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=p&amp;from=".$cur,
        'ratem_url'=>"twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=m&amp;from=".$cur,'remove_url'=>$remove_url,
        'favourite'=>$favourite,'favourite_url'=>'twork.php?wt=favourite&id='.$post->id,'loged'=>$loged,'hold'=>$post->top,'allow_hold'=>$usr->lvl>=$hlvl
        ,'rate_num'=>($post->ratep+$post->ratem)%100));
        $result = db_query('SELECT * FROM comment WHERE krnl = %d && lvl = 0 ORDER BY id', $post_id);
        echo "<a id='cm'></a><div id='cmn'>";
        if (!db_num_rows($result)) {
            echo "<span id='nocom'>Комментариев нет</span>";
        } else {
            if (!($out = readCache('comment_tree_'.$post_id.'.cache', CACHE_TIME_LIMIT/2))) {
                ob_start();
                while ($row = db_fetch_assoc($result)) {
                    com_echo(new comment($row),0,$allow_comment);
                }
                $out=ob_get_clean();
                writeCache($out,'comment_tree_'.$post_id.'.cache');
            }
            echo post_render_comment($out,$v_date);
            
        }
        echo "</div>";
        if ($loged==1 && !$allow_comment) {
            echo "	<div class='cprv' id='cprv-1'></div>	<div class='inpt' id='mkt'>
		 </div>
		<form onsubmit='s_c(this,\"$post->id\"); klcprv(-1); return false;' class='inpt' id='com' name='com' method='post' action='twork.php?wt=newcom&amp;id=".$post->id."&amp;from=".$cur."'>

		<textarea onkeypress='if (ce(event)) {s_c(this.form,\"$post->id\"); klcprv(-1);} do_key(this.form,\"com\",event);' 
onkeydown='if(\"\v\"==\"v\") {do_key(this.form,\"com\",event); }' name='text'  rows='10' cols='80'></textarea><br />
<input type='submit' value='Отправить' /><input type='button' id='prwb-1' onClick='prw_com(this.form.text.value,-1)' value='Предпросмотр' />
</form>";
            $script->add("document.getElementById('prwb-1').style.display='inline'; mk('mkt','com');");
        }
    }

//spy
if ($loged == 1) {
    if (!$v_id) {
        db_query('INSERT INTO `hist` SET `pid` = %d, `who` = %s, `date` = %d', $post_id, $usr->login, time());
    } else {
        db_query('UPDATE `hist` SET `date` = %s WHERE `id` = %d', time(), $v_id);
    }
}
///spy
if ($num_com==0) {$nam="&#8212;";} else {$nam=$num_com;}
echo "<div id='ebaa'><img onClick='upd_com()' style='cursor:pointer' src='style/n_img/refr.gif' /><br /><a href='javascript:upd_ls()' id='ln_doe'>".$nam."</a></div>";
$script->add("var last_com_id=".$last_com_id."; var post_id_com=".intval($_GET['post'])."; ".$jstocom." var num_com=".$num_com.";");
?>