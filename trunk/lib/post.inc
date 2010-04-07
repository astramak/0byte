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
$fst_post=1;

class post {
    var $title;
    var $date;
    var $auth;
    var $id;
    var $text;
    var $ftext;
    var $ratep;
    var $ratem;
    var $blog;
    var $blogid;
    var $blck;
    var $tp;
    var $flw;
    var $lnk;
    var $top;
    var $visible;
    function post($row = null) {
        if ($row) $this->make($row);
    }

    function make($row) {
        foreach ($row as $key => $val) {
            $this->{$key} = $val;
        }
    }

    function havecut() {
        if (strstr($this->ftext,"[cut]")===false && strstr($this->ftext,"[fcut]")===false) {
            return 0;
        } else {
            return 1;
        }
    }

    function rate() {
        return($this->ratep - $this->ratem);
    }

    function is_voting() {
        return ($this->tp == 3);
    }
}

function post_echo($row, $t,$draft=null) {
    global $usr,$cur,$fst_post,$loged,$script;

    $alien = new user();
    $a = new post($row);
    $txt = code(($t == 1 ? $a->ftext : $txt=$a->text));

    $bls="";
    $array['blocked'] = $a->blck;
    $array['avatar']=0;
    $alien->find($a->auth,"av, lck",0);
    if ($alien->lck==3) {
        $a->visible=0;
        echo render_template(TPL_DELETED.'/post.tpl.php', null);
    } else {
        $a->visible=1;
        if ($a->blogid==0) {

            $array['not_in_blog']=1;
            if (strlen($alien->av)>2) {
                $array['avatar']=1;
                $array['avatar_url']='res.php?t=av&amp;img='.$alien->av;
            }
        } else {
            $array['not_in_blog']=0;
            $result = db_query('SELECT * FROM `blogs` WHERE id = %d', $a->blogid);
            $rowa = db_fetch_assoc($result);
            $blg = new blog($rowa);
            if (strlen($blg->av)>0) {
                $array['avatar']=1;
                $array['avatar_url']='res.php?t=bl&amp;img='.$blg->av;
            }
            $array['blog_name']=$blg->name;
            $array['blog_id']=$a->blogid;
        }
        if ($a->tp==1) {
            $array['type'] = 'link';
        } elseif ($a->tp==2) {
            $txt="<a href='".$a->lnk."' rel='nofollow'>Оригинал</a><br />".$txt;
            $array['type']='translate';
        } else {
            $array['type']='other';
        }
        $answ="";
        if (!$draft && $a->is_voting()) {
            $lnk=$row['lnk'];
            $result = db_query('SELECT * FROM wansw WHERE who = %s AND cid = %d', $usr->login, $a->id);
            $row = db_fetch_assoc($result);
            if (!$loged || $row['cid'] == $a->id) {
                $answ .= answ_echo($a->id);
            } else {
                $action="twork.php?wt=answ&cur=".$cur."&id=".$a->id;
                if ($lnk==1) {
                    $ttp="checkbox";
                    $script->add("var a_type=1;");
                } else {
                    $ttp="radio";
                    $script->add("var a_type=2;");
                }
                $i=0;
                $result = db_query('SELECT * FROM `answ` WHERE cid = %d', $a->id);
                while ($ro = db_fetch_assoc($result)) {
                    if ($lnk==1) {
                        $nam=$ro['id'];
                        $vl="";
                        $fn="onClick=\"set_b('".$ro['id']."')\"";
                    } else {
                        $nam="answ";
                        $vl=" value='".$ro['id']."'";
                        $fn="onClick=\"set_a(this.form,'".$ro['id']."')\"";
                    }
                    $answer_ar[$i]['options']=" type='".$ttp."' name='".$nam."' ".$fn." ".$vl;
                    $answer_ar[$i]['title']=$ro['title'];
                    $i++;
                }
                $answ.=render_answer( $answer_ar, 0, $a->id, $loged,$action);
            }
        }
        if ($fst_post==1) {
            $fst_post=0;
            $array['first']=1;
        } else {
            $array['first']=0;
        }
        $array['text']=str_replace("[cut]"," ",str_replace("[fcut]"," ",$txt)).$answ;
        $array['author']=$a->auth;
        $array['title']=$a->title;
        $array['date']=date('d.m.y  H:i',$a->date+TZ);
        $array['link']=$a->lnk;
        $array['id']=$a->id;
        if ($draft) {
            if ($a->tp==3) {
                $array['text']=null;
            } else {
                $array['text']=gtext($txt);
            }
        }
        $array['draft']=$draft;
        $array['hold']=$a->top;
        echo render_post($array);
        return($a);
    }
}

function chkin($a) {
    global $usr,$loged;
    if ($a['lock']==0) {
        return(1);
    } elseif ($loged==0) {
        return (0);
    } elseif ($a['auth']==$usr->login) {
        return(1);
    } elseif ($a['blogid']==0) {
        $name = db_result(db_query('SELECT name FROM users WHERE name = %s AND frnd LIKE %s', $usr->login, '%' . $a['auth'] . '%'));
        if ($name == $usr->login) {
            return(1);
        } else {
            return(0);
        }
    } else {
        $name = db_result(db_query('SELECT * FROM inblog WHERE name = %s AND blogid = %d', $usr->login, $a['blogid']));
        if ($name == $usr->login) {
            return(1);
        } else {
            return(0);
        }
    }
}


function answ_echo ($id) {
    $num = 0;
    $aval = 0;
    $result = db_query('SELECT * FROM answ WHERE cid = %d', $id);
    while ($ro = db_fetch_assoc($result)) {
        $num++;
        $ak[$num]['title'] = $ro['title']	;
        $ak[$num]['val'] = $ro['val'];
        $aval += $ro['val'];
    }
    $prc = $aval / 100;
    for ($i = 1; $i <= $num; $i++) {
        $ak[$i]['size'] = $ak[$i]['val'] / $prc;
    }
    return(render_answer($ak,1));
}
$get_special_result=null;
$get_special_blogs_result=null;
function get_special_blogs() {
	global $get_special_blogs_result, $special_blogs;
    if ($get_special_blogs_result == null) {
		$get_special_blogs_result = '';
		foreach ($special_blogs as $sb) {
			$get_special_blogs_result .= ('`post`.`blogid` != '.$sb);
			if ($sb != end($special_blogs)) {
				$get_special_blogs_result .= ' && ';
		}
		}
	}

	return $get_special_blogs_result;
}
function get_special() {
    global $usr,$special_sql,$loged,$special_blogs,$get_special_result;
    if ($get_special_result == null) {
	
		if (!$loged) {
			$special_sql = '0';
		}   else if (strlen($special_sql)<2 &&  $special_sql != '0') {
				$where = array();
				$result = db_query('SELECT `blogid` FROM `inblog` WHERE `name` = %s && `out` = 0 ORDER BY id DESC', $usr->login);
				$ids = array();
				while ($row = db_fetch_object($result)) $ids[] = $row->blogid;
				if ($ids) $where[] = '`post`.`blogid` IN (' . implode(',', $ids) . ')';
				
				$frnd = db_result(db_query('SELECT `frnd` FROM `users` WHERE `name` = %s', $usr->login));
				if ($frnd) {
					$arr = explode(',', $frnd);
					trim_array($arr, '_db_escape_string');
					if ($arr) $where[] = '`post`.`auth` IN (' . implode(',', $arr) . ')';
				}
				if ($where) {
					$special_sql='('.implode(' || ', $where).')';
				} else {
					$special_sql = '0';
				}
				
			}
		
		$get_special_result = $special_sql;
		#echo $special_sql;
		return $special_sql;
	} else {
		return $get_special_result;
	}
}
?>
