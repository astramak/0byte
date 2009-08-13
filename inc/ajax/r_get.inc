<?php
header("Content-Type: text/html; charset=utf-8");
$loged=login();
class out {
    var $arr;
    var $num;
}
$api=request::get_get('api',0); #for third party application
$aft="";
$tp="";
if (request::get_get('com',0)) {
    $tp="`comment`.";
}
if (request::get_get('aft',0)) {
    $aft=" && ".$tp."`id` > ".intval($_GET['aft']);
} elseif (request::get_get('bef',0)) {
    $aft=" && ".$tp."`id` < ".intval($_GET['bef']);
}
$limit=8;
if (request::get_get('lm',0)) {
    $limit=intval($_GET['lm']);
}
$i=0;
if (isset ($_GET['noo'])) {
    if ($_GET['noo']==1) {
        $_SESSION['tp1']=0;
    } else {
        $_SESSION['tp2']=0;
    }
} elseif (request::get_get('pst',0)) {
    if (!$api) $_SESSION['tp1']='pst';
    $result=db_query("SELECT * FROM `post` WHERE `blck`='0' && `lock` = 0 ".$aft." ORDER BY id DESC LIMIT ".$limit);
    while ($row = db_fetch_assoc($result)) {
        $arr[$i]['id']=$row['id'];
        $arr[$i]['title']=$row['title'];
        if ($row['blogid']==0) {
            $arr[$i]['who']=$row['auth'];
            $arr[$i]['url']='user/'.$row['auth'].'/';
        } else {
            $arr[$i]['who']=$row['blog'];
            $arr[$i]['url']='blog/'.$row['blogid']."/";
        }
        if (request::get_get('date',0)) {
            $arr[$i]['date']=$row['date'];
        }
        $arr[$i]['rate']=$row['ratep']-$row['ratem'];
        $i++;
    }
} elseif (request::get_get('com',0)) {
    if (!$api) $_SESSION['tp1']='com';
    $result=db_query("SELECT *,`post`.`id` as `pid` FROM `post`,`comment` WHERE `post`.`id`=`comment`.`krnl` && `post`.`blck`='0' ".$aft." ORDER BY `comment`.`id` DESC LIMIT ".$limit);
    while ($row = db_fetch_assoc($result)) {
        $arr[$i]['id']=$row['id'];
        $arr[$i]['wid']=$row['pid'];
        $arr[$i]['who']=$row['who'];
        $arr[$i]['where']=$row['title'];
        if ($row['blogid']==0) {
            $arr[$i]['blg']=$row['auth'];
        } else {
            $arr[$i]['blg']=$row['blog'];
        }
        $arr[$i]['rate']=$row['ratep']-$row['ratem'];
        if (request::get_get('date',0)) {
            $arr[$i]['date']=$row['date'];
        }
        $i++;
    }

} elseif (request::get_get('top_user',0)) {
    if (!$api) $_SESSION['tp2']='us';
   $result=db_query(" SELECT * FROM `users` WHERE `lvl`='0'  ORDER BY (ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r) DESC LIMIT ".$limit);
   while ($row = db_fetch_assoc($result)) {
        $arr[$i]['name']=$row['name'];
        $arr[$i]['rate']=$row['ratep']-$row['ratem']+$row['prate']/$post_r+$row['crate']/$com_r+$row['brate']/$blog_r;
        $i++;
    }
} elseif (request::get_get('top_blog',0)) {
    if (!$api) $_SESSION['tp2']='bl';
   $result=db_query(" SELECT * FROM `blogs` ORDER BY ratep - ratem DESC LIMIT ".$limit);
   while ($row = db_fetch_assoc($result)) {
        $arr[$i]['id']=$row['id'];
        $arr[$i]['name']=$row['name'];
        $arr[$i]['rate']=$row['ratep']-$row['ratem'];
        $i++;
    }
} elseif (request::get_get('eye',0) && $loged) {
    if (!$api) $_SESSION['tp1']='eye';
    if (!request::get_get('no',0)) {
        $result=db_query(" SELECT * FROM `eye`,`post` WHERE `eye`.`pid`=`post`.`id` && `eye`.`who`='".$usr->login."' ORDER BY  `eye`.`id` DESC LIMIT ".$limit);
        while ($row = db_fetch_assoc($result)) {
            $arr[$i]['id']=$row['id'];
            $arr[$i]['title']=$row['title'];
            if ($row['blogid']==0) {
                $arr[$i]['who']=$row['auth'];
                $arr[$i]['url']='user/'.$row['auth'].'/';
            } else {
                $arr[$i]['who']=$row['blog'];
                $arr[$i]['url']='blog/'.$row['blogid']."/";
            }
            $i++;
        } }
} elseif (request::get_get('last_com_id',0) && request::get_get('pid',0)) {
    $post11=intval($_GET['pid']);
    $result=db_query("SELECT * FROM `comment` WHERE `id`>'".intval($_GET['last_com_id'])."' && `krnl`='".intval($_GET['pid'])."' ORDER by `id`");
    while ($row = db_fetch_assoc($result)) {
        $arr[$i]['id']=$row['id'];
        $arr[$i]['lvl']=$row['lvl'];
        $arr[$i]['cid']=$row['cid'];
        $arr[$i]['txt'] = com_echo(new comment($row), 1);
        $i++;
    }
    if ($loged==1) {
        $result=db_query("SELECT id FROM `hist` WHERE `pid` = %d && `who`= %s  ",request::get_get('pid'),$usr->login);
        $sql_get="UPDATE `hist` SET `date` = '".time()."' WHERE `hist`.`id` =".$rw['id']." LIMIT 1";
        $result=mysql_query($sql_get,$sql);
    }

} else if (request::get_get('draft',0) && $loged) {
        if (!$api) $_SESSION['tp1']='draft';
        $res=db_query('SELECT `id`,`title`,`auth` FROM `draft` WHERE `auth`= %s ORDER BY `id` DESC LIMIT %d ',$usr->login,$limit);
        while ($row=db_fetch_assoc($res)) {
            $arr[$i]=$row;
            $arr[$i]['url']='draft/'.$row['id'];
            $arr[$i]['rate']=0;
            $i++;
        }
    } else if (request::get_get('favourite',0) && $loged) {
            if (!$api) $_SESSION['tp1']='favourite';
            $res=db_query('SELECT `post`.`id` AS `id` , `post`.`title` AS `title`,`post`.`auth` AS `auth`,
        `post`.`blog` AS `blog`, `post`.`blogid` AS `blogid`, `post`.`ratem` AS `ratem`, `post`.`ratep` AS `ratep`,
        `favourite`.`who`, `favourite`.`pid` FROM `post`,`favourite` WHERE `favourite`.`who`= %s
        && `favourite`.`pid`=`post`.`id` ORDER BY `post`.`id` DESC LIMIT %d ',$usr->login,$limit);
            while ($row=db_fetch_assoc($res)) {
                $arr[$i]['id']=$row['id'];
                $arr[$i]['title']=$row['title'];
                if ($row['blogid']==0) {
                    $arr[$i]['who']=$row['auth'];
                    $arr[$i]['url']='user/'.$row['auth'].'/';
                } else {
                    $arr[$i]['who']=$row['blog'];
                    $arr[$i]['url']='blog/'.$row['blogid']."/";
                }
                $arr[$i]['rate']=$row['ratep']-$row['ratem'];
                $i++;
            }
        } else if (request::get_get('online',0)) {
                $result = db_query('SELECT `name` FROM `users` WHERE `online` >= %d ORDER BY online DESC', time() - 300);
                $online= new user;
                while ($row = db_fetch_assoc($result)) {
                    $online->find($row['name']);
                    $arr[$i]['avatar']=$online->av;
                    $arr[$i]['name']=$online->login;
                    $arr[$i]['rate']=$online->rate();
                    $i++;
                }
            }
$out=new out;
$out->arr=$arr;
$out->num=$i;
echo json_encode($out);
?>