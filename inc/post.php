<?php
/*
 * THIS FILE DEPRECATED AND IN FUTURE WILL BE REPLACED BY post.rewrited.php
 * 
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
$inser='';
if (request::get_get('pg',0)) {
    $inser.=request::get_get('pg',0)."/";
}
if (request::get_get('blog',0)) {
    $inser.="blog/".request::get_get('blog',0)."/";
}
$blck="&& blck != 1";
if ($usr->lvl>=$rlvl) {
    $blck="";
} else if ($loged) {
    $blck='&& (`blck` != 1 || `auth` = "'.$usr->login.'")';
}
if (request::get_get('count',0)) {
    $count=request::get_get('count',0);
} else {
    $count=10;
}
$favourite=request::get_get('favourite',0);
$pg=request::get_get('pg','');
$draft=request::get_get('draft',0);
$frm=request::get_get("frm",0,0);
if (sizeof($_GET)==0 || ($frm>0 && strlen($pg)<2 && !request::get_get('like',0) && !$favourite && !$draft && !request::get_get('tag',0) 
                && !request::get_get('auth',0) && !request::get_get('blog',0) && !request::get_get('fnd',0))) {
    $sql_get="(SELECT * FROM `post` WHERE `top`=1 ORDER BY `id` DESC) UNION (SELECT * FROM `post` WHERE ratep-ratem >= $to_main $blck && ( `lock` = 0 || ".get_special()." ) ORDER BY id DESC) ORDER BY `top` DESC , `id` DESC";


}
else 
if ($loged && $draft) {
    $inser.='draft/';
    $sql_get="SELECT * FROM `draft` WHERE auth = '".$usr->login."' ORDER BY  id DESC ";
    echo render_template(TPL_POST_LIST.'/draft.tpl.php', null);
} else if ($loged && $favourite) {
    $inser.='favourite/';
    $sql_get="SELECT * FROM `favourite`,`post` WHERE `favourite`.`pid`=`post`.`id` && `favourite`.`who` = '".$usr->login."' ORDER BY  `post`.`id` DESC";
    echo render_template(TPL_POST_LIST.'/favourite.tpl.php', null);
} else if (request::get_get('like',0)>0) {
    $tags=db_result(db_query('SELECT `tag` FROM `post` WHERE `id` = %d',request::get_get('like',0)));
    $tags_arr=split(",", $tags);
    $query="SELECT *, ";
    $where=null;
    foreach ($tags_arr as $tag) {
        $query.="IF(`tag` LIKE '%".mysql_escape_string(trim($tag))."%',1,0)+";
        $where.="`tag` LIKE '%".mysql_escape_string(trim($tag))."%' || ";
    }
    $query=substr($query, 0, strlen($query)-1);
    $where=substr($where, 0, strlen($where)-4);
    $query.=" AS `rel` FROM `post` WHERE ".$where." ORDER BY `rel` DESC";
    $sql_get=$query;
    $inser.='like/'.request::get_get('like',0);
}
else
if (request::get_get('tag',0)) {
    $sql_get="SELECT * FROM `post` WHERE tag LIKE '%".mysql_escape_string(request::get_get('tag')).",%' ||
 tag LIKE '%, ".mysql_escape_string(request::get_get('tag'))."%'
|| LOWER(tag) = LOWER('".mysql_escape_string(request::get_get('tag'))."')
			|| tag = '".mysql_escape_string(request::get_get('tag'))."' || tag LIKE '%,".mysql_escape_string(request::get_get('tag'))."%'  $blck ORDER BY  id DESC";
    $inser.="tag/".htmlspecialchars(request::get_get('tag'))."/";
    echo render_template(TPL_POST_LIST.'/tag.tpl.php', array('text'=>htmlspecialchars(request::get_get('tag'))));
} else if (request::get_get('pg','null')==='pers') {
    $sql_get="SELECT * FROM `post` WHERE blog = 'own' $blck && ( `lock` = 0 || ".get_special()." ) ORDER BY  id DESC ";
} else {
    if (request::get_get('auth',0)) {
        $sql_get="SELECT * FROM `post` WHERE auth = '".mysql_escape_string(request::get_get('auth'))."' $blck ORDER BY  id DESC ";
        $inser.="auth/".request::get_get('auth')."/";
        $au=1;
    } else if (request::get_get('blog',0)) {
        $sql_get="SELECT * FROM `post` WHERE blogid = '".intval(request::get_get('blog'))."' $blck ORDER BY  id DESC ";
        $bl=1;
    } else {
        $sql_get="SELECT * FROM `post` WHERE blog != 'own' $blck ORDER BY  id DESC ";
    }
}
if (request::get_get('fnd',0)) {

    $fnd=trim(str_replace(" ", "%", request::get_get('fnd')));
    $sql_get="SELECT * FROM `post` WHERE ( title LIKE '%".mysql_escape_string($fnd)."%' || text LIKE '%".mysql_escape_string($fnd)."%' || ftext LIKE '%".mysql_escape_string($fnd)."%' || tag LIKE '%".mysql_escape_string($fnd)."%' )  $blck ORDER BY  id DESC";
    echo render_template(TPL_POST_LIST.'/find.tpl.php', array("text"=>htmlspecialchars(request::get_get('fnd'))));
}
if (request::get_get('pg',0)!=0 && request::get_get('pg',0)=='lenta' && $loged==1) {
    $sql_get = 'SELECT * FROM `post` WHERE  `blck` = 0 && `auth` != "'.$usr->login.'" && '.get_special().' ORDER BY `id` DESC';
}
$result=db_query($sql_get);
$i=0;
$k=0;
$cur=$_SERVER['REQUEST_URI'];
$cur=str_replace("&","*amp",$cur);
$cur=str_replace("?","*qw",$cur);
$kol=db_num_rows($result);
$result=db_query($sql_get." LIMIT ".$frm." , ".$count);
if ($kol<1 && request::get_get('blog',0)==0) {
    if (request::get_get('fnd',0)!=0) {
        echo render_error("Ничего не найдено!");
    } else {
        redirect($dir.'error/not_found');
    }
} else {
    if (isset($bl) && $bl==1 && !in_array(request::get_get('blog'), $special_blogs)) {
//        $sql_get="SELECT * FROM `blogs` WHERE id = '".intval($_GET['blog'])."' ";
//        $resul=mysql_query($sql_get,$sql);
//        $rowa = mysql_fetch_assoc($resul);
        $rowa= db_fetch_assoc(db_query("SELECT * FROM `blogs` WHERE id = %d ",request::get_get('blog')));
        $blg=new blog;
        $blg->make($rowa);
//        $sql_get="SELECT * FROM `inblog` WHERE blogid = '".intval($_GET['blog'])."' && name =
//			'".$usr->login."'";
//        $res=mysql_query($sql_get,$sql);
//        $ro = mysql_fetch_assoc($res);
        $ro=db_fetch_assoc(db_query("SELECT * FROM `inblog` WHERE blogid = %d && name = %s",request::get_get('blog'),$usr->login));
        $avatar=0;
        $avatar_url=null;
        if (strlen($blg->av)>0) {
            $avatar=1;
            $avatar_url="res.php?t=bl&img=".$blg->av;
        }
        $in_blog=1;
        if ($ro['name']==$usr->login && $ro['out']==0 ) {
            $in_blog=0;
        }
        $owner=1;
        if ($blg->owner==$usr->login || $loged==0) {
            $owner=0;
        }
        echo render_template(TPL_POST_LIST.'/blog.tpl.php', array('avatar'=>$avatar,
        'avatar_url'=>$avatar_url,'name'=>$blg->name,'about'=>$blg->about,
        'in_blog'=>$in_blog,'inblog_url'=>"twork.php?wt=mergeblog&amp;id=".$blg->id,
        'owner'=>$owner,'rate'=>$blg->rate(),'ratep_url'=>"twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=p&amp;from=".$cur,
        'ratem_url'=>"twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=m&amp;from=".$cur));
        if ($kol<1) {
            echo render_error("Блог пуст!");
        }
    } else {
        if (@$au==1) {
            $alien=new user;
            $alien->find(request::get_get('auth'),'av, ratep, ratem',1);
            $avatar=0;
            $avatar_url=null;
            if (strlen($alien->av)>2) {
                $avatar=1;
                $avatar_url="res.php?t=av&img=".$alien->av;
            }
            echo render_template(TPL_POST_LIST.'/user.tpl.php', array('avatar'=>$avatar,
            'avatar_url'=>$avatar_url,'name'=>$alien->login,'rate'=>$alien->rate(),
            'ratep_url'=>"twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur,
            'ratem_url'=>"twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur));
        }
    }
    while ($row = db_fetch_assoc($result)) {
//        if (isset($_GET['hl']) && $_GET['hl']==$row['id']) {
//            echo "<a id='hl'></a>";
//        }
        $posts[$k]=post_echo($row,0,$draft);
        if ($posts[$k]->visible) {
            if ($posts[$k]->tp==1 || ($posts[$k]->tp!=3 && $posts[$k]->havecut()==1)) {
                $full=1;
            } else {
                $full=0;
            }
            echo render_template(TPL_POST_LIST.'/bottom.tpl.php', array('show_full'=>$full,
            'id'=>$posts[$k]->id,'comments'=>klist($posts[$k]->id),
            'ratep_url'=>"twork.php?wt=ratepost&amp;id=".$posts[$k]->id."&amp;rate=p&amp;from=".$cur,
            'ratem_url'=>"twork.php?wt=ratepost&amp;id=".$posts[$k]->id."&amp;rate=m&amp;from=".$cur,
            'rate'=>$posts[$k]->rate(),'draft'=>$draft,'rate_num'=>($posts[$k]->ratep+$posts[$k]->ratem)%100));
        }
        $k++;
    }
}

$fnd=request::get_get('fnd',null);
echo render_paginator($inser, $count, $kol, request::get_get('frm',0), '/'.$fnd);
?>