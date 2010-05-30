<?php
/* 
 * Rewrited fuckin post.inc
 * File not tested.
 * After test file will be split to lib/post.inc and post.php
*/
//content of lib/post.inc:
//define post-list types:

class post_list {
    var $type;
    var $head;
    var $sql_result;
    var $current;
    var $limit;
    var $count;
    var $blck;
    var $url_ins;
    var $param;
    var $sort;
    /**
     * Append url
     *
     * @param string $url
     */
    private function make_url($url) {
        $this->url_ins.=htmlspecialchars($url);
    }
    /**
     * Make list by type
     *
     * @param numeric $type
     * @param string $str_type
     */
    private function make_list($type,$str_type) {
        $this->type=$type;
        $this->param=htmlspecialchars(request::get_get($str_type,null));
        $this->make_url($str_type.'/'.$this->param.'/');
    }
    /**
     * Make head of post list
     *
     * @global array $special_blogs
     * @global user $usr
     * @global numeric $loged
     * @global string $cur
     * @return string
     */
    function make_head() {
        global $special_blogs,$usr,$loged,$cur;
        switch ($this->type) {
            case BLOG:
                if (!in_array($this->param, $special_blogs)) {
                    $rowa= db_fetch_assoc(db_query("SELECT * FROM `blogs` WHERE id = %d ",$this->param));
                    $blg=new blog;
                    $blg->make($rowa);
                    $ro=db_fetch_assoc(db_query("SELECT `name`,`out` FROM `inblog` WHERE `blogid` = %d && `name` = %s",$this->param,$usr->login));
                    $avatar=0;
                    $avatar_url=null;
                    if (strlen($blg->av)>0) {
                        $avatar=1;
                        $avatar_url="res.php?t=bl&img=".$blg->av;
                    }
                    $in_blog=($ro['name']==$usr->login && $ro['out']==0 && $loged);
                    $owner=($blg->owner==$usr->login || $loged==0);
                   
                    $this->head=render_template(TPL_POST_LIST.'/blog.tpl.php', array('id'=>$blg->id,'avatar'=>$avatar,
                            'avatar_url'=>$avatar_url,'name'=>$blg->name,'about'=>$blg->about,
                            'in_blog'=>$in_blog,'inblog_url'=>"twork.php?wt=mergeblog&amp;id=".$blg->id,
                            'owner'=>$owner,'rate'=>$blg->rate(),'ratep_url'=>"twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=p&amp;from=".$cur,
                            'ratem_url'=>"twork.php?wt=rateblog&amp;id=".$blg->id."&amp;rate=m&amp;from=".$cur));
                }
                break;
            case LIKE:
                $name=db_result(db_query('SELECT `title` FROM `post` WHERE `id` = %d',$this->param));
                $this->head=render_template(TPL_POST_LIST.'/like.tpl.php', array('name'=>$name));
                break;
            case TAG:
                $this->head=render_template(TPL_POST_LIST.'/tag.tpl.php', array('text'=>$this->param));
                break;
            case AUTH:
                $alien=new user;
                $alien->find(request::get_get('auth'),'av, ratep, ratem',1);
                $avatar=0;
                $avatar_url=null;
                if (strlen($alien->av)>2) {
                    $avatar=1;
                    $avatar_url="res.php?t=av&img=".$alien->av;
                }
                $this->head=render_template(TPL_POST_LIST.'/user.tpl.php', array('avatar'=>$avatar,
                        'avatar_url'=>$avatar_url,'name'=>$alien->login,'rate'=>$alien->rate(),
                        'ratep_url'=>"twork.php?wt=rateuser&name=".$alien->login."&rate=p&from=".$cur,
                        'ratem_url'=>"twork.php?wt=rateuser&name=".$alien->login."&rate=m&from=".$cur));
                break;
            case FIND:
                $this->head=render_template(TPL_POST_LIST.'/find.tpl.php', array("text"=>htmlspecialchars($this->param)));
                break;
            case FAVOURITE:
                if ($loged) {
                    $this->head=render_template(TPL_POST_LIST.'/favourite.tpl.php', null);
                }
                break;
            case DRAFT:
                if ($loged) {
                    
			$this->head=render_template(TPL_POST_LIST.'/draft.tpl.php', null);
                }
                break;
            default:
                $this->head=null;
        }
        return $this->head;
    }
    /**
     * Make result of sql expressions of post list and return it. Create count of results;
     *
     * @global user $usr
     * @global nmeric $to_main
     * @return sql_result
     */
    function make_sql_result() {
        global $usr, $to_main;
        switch ($this->type) {
            case BLOG:
                $this->count=db_result(db_query("SELECT COUNT(`id`) FROM `post` WHERE `blogid` = %d ".$this->blck." ORDER BY  id DESC ",$this->param));
                $this->sql_result=db_query("SELECT * FROM `post` WHERE blogid = %d ".$this->blck." ORDER BY  ".$this->sort." DESC LIMIT %d, %d",$this->param,$this->current,$this->limit);
                break;
            case LIKE:
                $tags=db_result(db_query('SELECT `tag` FROM `post` WHERE `id` = %d',$this->param));
                $tags_arr=split(",", $tags);
                $where=null;
                foreach ($tags_arr as $tag) {
                    $query.="IF(`tag` LIKE '%".mysql_escape_string(trim($tag))."%',1,0)+";
                    $where.="`tag` LIKE '%".mysql_escape_string(trim($tag))."%' || ";
                }
                $query=substr($query, 0, strlen($query)-1);
                $where=substr($where, 0, strlen($where)-4);
                $where.=$this->blck;
                $query.=" AS `rel` FROM `post` WHERE ".$where." ORDER BY `rel` DESC";
                $count=db_fetch_assoc(db_query('SELECT COUNT(`id`) as `count`,'.$query));
                $this->count=$count['count'];
                $this->sql_result=db_query('SELECT *,'.$query.' LIMIT %d, %d',$this->current,$this->limit);
                break;
            case TAG:
                $sql_get=" FROM `post` WHERE tag LIKE '%".mysql_escape_string($this->param).",%' ||
                    tag LIKE '%, ".mysql_escape_string($this->param)."%'
                    || LOWER(tag) = LOWER('".mysql_escape_string($this->param)."')
                    || tag = '".mysql_escape_string($this->param)."' || tag LIKE '%,".mysql_escape_string($this->param)."%'  ".$this->blck." ORDER BY  ".$this->sort." DESC";
                $this->count=db_result(db_query('SELECT COUNT(`id`)'.$sql_get));
                $this->sql_result=db_query('SELECT *'.$sql_get.' LIMIT %d, %d',$this->current,$this->limit);
                break;
            case AUTH:
                $this->count=db_result(db_query("SELECT COUNT(`id`) FROM `post` WHERE auth = %s ".$this->blck." ORDER BY  id DESC ",$this->param));
                $this->sql_result=db_query("SELECT * FROM `post` WHERE auth = %s ".$this->blck." ORDER BY  ".$this->sort." DESC LIMIT %d, %d",$this->param,$this->current,$this->limit);
                break;
            case FIND:
                $sql_get=" FROM `post` WHERE ( title ILIKE '%".mysql_escape_string($this->param)."%' || text ILIKE '%".mysql_escape_string($this->param)."%' || ftext ILIKE '%".mysql_escape_string($this->param)."%' || tag ILIKE '%".mysql_escape_string($this->param)."%' )  ".$this->blck." ORDER BY  id DESC";
                $this->count=db_result(db_query('SELECT COUNT(`id`)'.$sql_get));
                $this->sql_result=db_query('SELECT *'.$sql_get.' LIMIT %d, %d',$this->current,$this->limit);
                break;
            case FAVOURITE:
                $this->count=db_result(db_query("SELECT COUNT(`id`) FROM `favourite` WHERE `favourite`.`who` = %s ",$usr->login));

                $this->sql_result=db_query("SELECT * FROM `favourite`,`post` WHERE `favourite`.`pid`=`post`.`id` && `favourite`.`who` = %s ORDER BY  `post`.`".$this->sort."` DESC LIMIT %d, %d",$usr->login,$this->current,$this->limit);
                break;
            case DRAFT:
                $this->count=db_result(db_query("SELECT  COUNT(`id`) FROM `draft` WHERE auth = %s ORDER BY  id DESC ",$usr->login)); 
                $this->sql_result=db_query("SELECT * FROM `draft` WHERE auth = %s ORDER BY  id DESC LIMIT %d, %d",$usr->login,$this->current,$this->limit);
                break;
case PERSONAL:
$sql_get="SELECT * FROM `post` WHERE blog = 'own' ".$this->blck." && ".get_special_blogs()." && ( `lock` = 0 || ".get_special()." ) ORDER BY  `".$this->sort."` DESC";
 $this->count=db_num_rows(db_query($sql_get));
                $this->sql_result=db_query($sql_get.' LIMIT %d, %d',$this->current,$this->limit);
break;
case INBLOG:
$sql_get="SELECT * FROM `post` WHERE blog != 'own' ".$this->blck." && ".get_special_blogs()." && ( `lock` = 0 || ".get_special()." ) ORDER BY  `".$this->sort."` DESC";
$this->count=db_num_rows(db_query($sql_get));
                $this->sql_result=db_query($sql_get.' LIMIT %d, %d',$this->current,$this->limit);
break;
            default:
                $sql_get="(SELECT * FROM `post` WHERE `top`=1 ORDER BY `id` DESC) UNION (SELECT * FROM `post` WHERE ratep-ratem >= $to_main ".$this->blck." && ".get_special_blogs()." && ( `lock` = 0 || ".get_special()." ) ORDER BY ".$this->sort." DESC) ORDER BY `top` DESC , `".$this->sort."` DESC";
                $this->count=db_num_rows(db_query($sql_get));
                $this->sql_result=db_query($sql_get.' LIMIT %d, %d',$this->current,$this->limit);
        }

        return $this->sql_result;
    }
    /**
     * Make post_list class and choose type of posts and return type
     *
     * @global numeric $loged
     * @global user  $usr
     * @global numeric $rlvl
     * @param string $current
     * @param numeric $limit
     * @return numeric
     */
    function  __construct($current,$limit) {
        global $loged,$usr,$rlvl;
        $blck="&& blck != 1";
        if ($usr->lvl>=$rlvl) {
            $blck="";
        } else if ($loged) {
            $blck='&& (`blck` != 1 || `auth` = "'.$usr->login.'")';
        }
        $this->blck=$blck;
        $this->current=$current;
        $this->limit=$limit;
        $this->url_ins=null;
        if (request::get_get('pg','0')!='0') {
            $this->make_url(request::get_get('pg',0)."/");
	    if (request::get_get('pg','0')=='main') {
$this->type=INBLOG;
} else if (request::get_get('pg','0')=='pers') {
$this->type=PERSONAL;
} else    $this->type=MAIN;
        } else if (request::get_get('blog',0)) {
            $this->make_list(BLOG,'blog');
        } else if (request::get_get('like',0)) {
            $this->make_list(LIKE,'like');
        } else if (request::get_get('tag',0)) {
            $this->make_list(TAG,'tag');
        } else if (request::get_get('auth',0)) {
            $this->make_list(AUTH,'auth');
        } else if (request::get_get('fnd',0)) {
            $this->type=FIND;
            $this->param=request::get_get('fnd',0);
        } else if ($loged) {
            if (request::get_get('favourite',0)) {
                $this->make_url('favourite/');
                $this->type=FAVOURITE;
            } else if (request::get_get('draft',0)) {
                $this->make_url('draft/');
                $this->type=DRAFT;
            }
        }
        $this->sort=(request::get_get('by','date')=='date')?DATE:LAST_MODIFY;
        return $this->type;
    }
    /**
     * Return error text when page is clear or redirect to error page
     *
     * @return text
     */
    function not_yet() {
        switch ($this->type) {
            case BLOG:
                return render_error('Блог пуст!');
                break;
            case AUTH:
                return render_error('Пользователь ещё ничего не написал!');
                break;
            case FIND:
                return render_error('Ничего не найденно!');
                break;
            default:
                redirect($dir.'error/not_found');
        }
    }
}
//content of inc/post.php:
$cur=$_SERVER['REQUEST_URI'];
$cur=str_replace("&","*amp",$cur);
$cur=str_replace("?","*qw",$cur);
$post_list=new post_list(request::get_get('frm',0),POST_COUNT);
echo $post_list->make_head();
$result=$post_list->make_sql_result();
$first=0;
if ($post_list->count>0) {
    while ($row = db_fetch_assoc($result)) {
if ($post_list->type!=DRAFT && $row['tp']!=3) {
$path = 'post_'.$row['id'].'.cache';
	if(!($out = readCache($path, CACHE_TIME_LIMIT))) {
	    ob_start();

        $post=post_echo($row,0,($post_list->type==DRAFT));
        if ($post->visible) {
            if ($post->tp==1 || ($post->tp!=3 && $post->havecut()==1)) {
                $full=1;
            } else {
                $full=0;
            }
            
        
echo render_template(TPL_POST_LIST.'/bottom.tpl.php', array('show_full'=>$full,
            'id'=>$post->id,'comments'=> '-1',
            'ratep_url'=>"twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=p&amp;from=".$cur,
            'ratem_url'=>"twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=m&amp;from=".$cur,
            'rate'=>$post->rate(),'draft'=>($post_list->type==DRAFT),'rate_num'=>($post->ratep+$post->ratem)%100)); }
   $out=ob_get_clean();

    writeCache($out,$path);
}






if ($first==0) $out = str_replace("<div class={top_class}>","<div class='fst_top'>", $out); 
else $out = str_replace("<div class={top_class}>","<div class='top'>", $out);
$out = str_replace("{comments}",klist($row['id']), $out);
$first++;
echo $out;   
 } else {
  ob_start();
 $post=post_echo($row,0,($post_list->type==DRAFT));
        if ($post->visible) {
            if ($post->tp==1 || ($post->tp!=3 && $post->havecut()==1)) {
                $full=1;
            } else {
                $full=0;
            }
            
        
echo render_template(TPL_POST_LIST.'/bottom.tpl.php', array('show_full'=>$full,
            'id'=>$post->id,'comments'=> klist($row['id']),
            'ratep_url'=>"twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=p&amp;from=".$cur,
            'ratem_url'=>"twork.php?wt=ratepost&amp;id=".$post->id."&amp;rate=m&amp;from=".$cur,
            'rate'=>$post->rate(),'draft'=>($post_list->type==DRAFT),'rate_num'=>($post->ratep+$post->ratem)%100));
	    }
$out=ob_get_clean();
if ($first==0) $out = str_replace("<div class={top_class}>","<div class='fst_top'>", $out); 
else $out = str_replace("<div class={top_class}>","<div class='top'>", $out);
echo $out;
$first++;
}
}
    echo render_paginator($post_list->url_ins, POST_COUNT, $post_list->count, $post_list->current, '/'.($post_list->type==FIND?$post_list->param:''));
} else {
    echo $post_list->not_yet();
}
?>
