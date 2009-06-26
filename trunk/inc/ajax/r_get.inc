<?php
session_start();
$loged=login();

class out {
	var $arr;
	var $num;
}

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
		$_SESSION['tp1']='none';
	} else {
		$_SESSION['tp2']='none';
	}
} elseif (isset($_GET['pst'])) {
	$_SESSION['tp1']='pst';
	$sql_get="SELECT * FROM `post` WHERE `blck`='0' ".$aft." ORDER BY id DESC LIMIT ".$limit;
	$result=mysql_query($sql_get,$GLOBALS['sql']);
	while ($row = mysql_fetch_assoc($result)) {
		$arr[$i]['id']=$row['id'];
		$arr[$i]['title']=$row['title'];
		if ($row['blog']=="own") {
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
	$_SESSION['tp1']='com';
	$sql_get="SELECT *,`post`.`id` as `pid` FROM `post`,`comment` WHERE `post`.`id`=`comment`.`krnl` && `post`.`blck`='0' ".$aft." ORDER BY `comment`.`id` DESC LIMIT ".$limit;
	$result=mysql_query($sql_get,$sql);
	while ($row = mysql_fetch_assoc($result)) {
		$arr[$i]['id']=$row['id'];
		$arr[$i]['wid']=$row['pid'];
		$arr[$i]['who']=$row['who'];
		$arr[$i]['where']=$row['title'];
		if ($row['blog']=='own') {
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
	$_SESSION['tp2']='us';
	$sql_get=" SELECT * FROM `users` WHERE `lvl`='0'  ORDER BY (ratep - ratem + prate / $post_r + crate / $com_r + brate / $blog_r) DESC LIMIT ".$limit;
	$result=mysql_query($sql_get,$sql);
	while ($row = mysql_fetch_assoc($result)) {
		$arr[$i]['name']=$row['name'];
		$arr[$i]['rate']=$row['ratep']-$row['ratem']+$row['prate']/$post_r+$row['crate']/$com_r+$row['brate']/$blog_r;
		$i++;
	}
} elseif (isset($_GET['top_blog'])) {
	$_SESSION['tp2']='bl';
	$sql_get=" SELECT * FROM `blogs` ORDER BY ratep - ratem DESC LIMIT ".$limit;
	$result=mysql_query($sql_get,$GLOBALS['sql']);
	while ($row = mysql_fetch_assoc($result)) {
		$arr[$i]['id']=$row['id'];
		$arr[$i]['name']=$row['name'];
		$arr[$i]['rate']=$row['ratep']-$row['ratem'];
		$i++;
	}
} elseif (isset($_GET['eye']) && $loged=1) {
	$_SESSION['tp1']='eye';
	if (!isset($_GET['no'])) {
		$sql_get=" SELECT * FROM `eye`,`post` WHERE `eye`.`pid`=`post`.`id` && `eye`.`who`='".$usr->login."' ORDER BY  `eye`.`id` DESC LIMIT ".$limit;
		$result=mysql_query($sql_get,$GLOBALS['sql']);
		while ($row = mysql_fetch_assoc($result)) {
			$arr[$i]['id']=$row['id'];
			$arr[$i]['title']=$row['title'];
			if ($row['blog']=="own") {
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

}
$out=new out;
$out->arr=$arr;
$out->num=$i;
echo json_encode($out);
?>