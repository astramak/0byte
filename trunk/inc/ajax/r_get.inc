<?php
session_start();
$loged=login();

class out {
    var $arr;
    var $num;
}
$api=request::get_get('api',0); #for third party application
$aft="";
$tp="";
if (isset($_GET['com'])) {
    $tp="`comment`.";
}
if (isset($_GET['aft'])) {
    $aft=" && ".$tp."`id` > ".intval($_GET['aft']);
} elseif (isset($_GET['bef'])) {
    $aft=" && ".$tp."`id` < ".intval($_GET['bef']);
}
$limit=8;
if (isset($_GET['lm'])) {
    $limit=intval($_GET['lm']);
}
$i=0;
if (isset ($_GET['noo'])) {
    if ($_GET['noo']==1) {
        $_SESSION['tp1']=0;
    } else {
        $_SESSION['tp2']=0;
    }
} elseif (isset($_GET['pst'])) {
    if (!$api) $_SESSION['tp1']='pst';
    $sql_get="SELECT * FROM `post` WHERE `blck`='0' && `lock` = 0 ".$aft." ORDER BY id DESC LIMIT ".$limit;
    $result=mysql_query($sql_get,$GLOBALS['sql']);
    while ($row = mysql_fetch_assoc($result)) {
        $arr[$i]['id']=$row['id'];
        $arr[$i]['title']=$row['title'];
        if ($row['blogid']==0) {
            $arr[$i]['who']=$row['auth'];
            $arr[$i]['url']='user/'.$row['auth'].'/';
        } else {
            $arr[$i]['who']=$row['blog'];
            $arr[$i]['url']='blog/'.$row['blogid']."/";
        }
        if (isset($_GET['date'])) {
            $arr[$i]['date']=$row['date'];
        }
        $arr[$i]['rate']=$row['ratep']-$row['ratem'];
        $i++;
    }
} elseif (isset($_GET['com'])) {
    if (!$api) $_SESSION['tp1']='com';
    $sql_get="SELECT *,`post`.`id` as `pid` FROM `post`,`comment` WHERE `post`.`id`=`comment`.`krnl` && `post`.`blck`='0' ".$aft." ORDER BY `comment`.`id` DESC LIMIT ".$limit;
    $result=mysql_query($sql_get,$sql);
    while ($row = mysql_fetch_assoc($result)) {
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
        if (isset($_GET['date'])) {
            $arr[$i]['date']=$row['date'];
        }
        $i++;
    }

} elseif (isset($_GET['top_user'])) {
    if (!$api) $_SESSION['tp2']='us';
    $sql_get=" SELECT * FROM `users` WHERE `lvl`='0'  ORDER BY (ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r) DESC LIMIT ".$limit;
    $result=mysql_query($sql_get,$sql);
    while ($row = mysql_fetch_assoc($result)) {
        $arr[$i]['name']=$row['name'];
        $arr[$i]['rate']=$row['ratep']-$row['ratem']+$row['prate']/$post_r+$row['crate']/$com_r+$row['brate']/$blog_r;
        $i++;
    }
} elseif (isset($_GET['top_blog'])) {
    if (!$api) $_SESSION['tp2']='bl';
    $sql_get=" SELECT * FROM `blogs` ORDER BY ratep - ratem DESC LIMIT ".$limit;
    $result=mysql_query($sql_get,$GLOBALS['sql']);
    while ($row = mysql_fetch_assoc($result)) {
        $arr[$i]['id']=$row['id'];
        $arr[$i]['name']=$row['name'];
        $arr[$i]['rate']=$row['ratep']-$row['ratem'];
        $i++;
    }
} elseif (isset($_GET['eye']) && $loged) {
    if (!$api) $_SESSION['tp1']='eye';
    if (!isset($_GET['no'])) {
        $sql_get=" SELECT * FROM `eye`,`post` WHERE `eye`.`pid`=`post`.`id` && `eye`.`who`='".$usr->login."' ORDER BY  `eye`.`id` DESC LIMIT ".$limit;
        $result=mysql_query($sql_get,$GLOBALS['sql']);
        while ($row = mysql_fetch_assoc($result)) {
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
} elseif (isset($_GET['last_com_id']) && isset($_GET['pid'])) {
    $post11=intval($_GET['pid']);
    $sql_get="SELECT * FROM `comment` WHERE `id`>'".intval($_GET['last_com_id'])."' && `krnl`='".intval($_GET['pid'])."' ORDER by `id`";
    $result=mysql_query($sql_get,$GLOBALS['sql']);
    while ($row = mysql_fetch_assoc($result)) {
        $arr[$i]['id']=$row['id'];
        $arr[$i]['lvl']=$row['lvl'];
        $arr[$i]['cid']=$row['cid'];
        $arr[$i]['txt'] = com_echo(new comment($row), 1);
        $i++;
    }
    if ($loged==1) {
        $sql_get="SELECT * FROM `hist` WHERE `pid` = '".intval($_GET['pid'])."' && `who`='".$usr->login."'  ";
        $result=mysql_query($sql_get,$sql);
        $rw = mysql_fetch_assoc($result);
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