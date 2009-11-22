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
class mel {
    var $name;
    var $url;
    var $cur;
    var $new;
    var $show;

    function chcur() {
        global $index,$pg;
        $frm=request::get_get("frm");

//        if ( (isset($index) && $this->url=="." && strlen($pg)<1) && (sizeof($_GET)==0 || sizeof($_GET)==sizeof($frm)   /*|| strncmp($this->url,$pg,strlen($pg))==0*/  )) {
//            $this->cur=1;
//        } else if (strlen($pg)>2 && strncmp($this->url,$pg,strlen($pg))==0 ) {
//            $this->cur=1;
//        } else
         $this->cur=0;
        if ((strcmp(request::get_get('wt',0),'lenta')==0 && strcmp($this->url,'lenta')==0) || (request::get_get('pg',0)==$this->url && $index)) {
            $this->cur=1;
        }
        return $this->cur;
    }

    function snew() {
        global $usr,$to_main,$loged,$special_sql;

        $dt = time() - 86400;
        $this->show = 1;
        switch ($this->url) {
            case '.':
                $new = db_result(db_query('SELECT COUNT(id) FROM `post` WHERE `date` > %d && `ratep` - `ratem` >= %f && ( `lock` = 0 || '.get_special().' )', $dt, $to_main));
                break;
            case 'main':
                $new = db_result(db_query("SELECT COUNT(id) FROM `post` WHERE date > %d AND blck = 0 AND blogid != 0 && ( `lock` = 0 || ".get_special()." )", $dt));
                break;
            case 'pers':
                $new = db_result(db_query("SELECT COUNT(id) FROM `post` WHERE date > %d AND blck = 0 AND blogid = 0 && ( `lock` = 0 || ".get_special()." )", $dt));
                break;
            case 'lenta':
                if ($loged==1) {
                    $frnd = db_result(db_query('SELECT `frnd` FROM `users` WHERE `name` = %s', $usr->login));
                    $where="1 = 0";
                    if ($frnd) {
                        $arr = explode(',', $frnd);
                        trim_array($arr, '_db_escape_string');
                        if ($arr) $where = '`lenta`.`who` IN (' . implode(',', $arr) . ')';
                    }
//                    $new=db_result(db_query("SELECT COUNT(`type`) FROM `post`,`lenta`,`inblog`
//                    WHERE `lenta`.`date` > %d && ( (`lenta`.`who` = %s && `lenta`.`type` = 0) ||
//                    (`lenta`.`who`= `inblog`.`bname` && `lenta`.`type`= 1 && `inblog`.`name` = %s && `inblog`.`out` = 0 && `post`.`id`=`lenta`.`uid` && `post`.`auth`!= %s) ||
//                    (`lenta`.`type` = 2 && ".$where."))  GROUP BY `lenta`.`id`
//                     ",$dt,$usr->login,$usr->login,$usr->login));
                   db_query("SET SQL_BIG_SELECTS=1 ");
                  $new=db_num_rows(db_query("SELECT `lenta`.*,`inblog`.`bname` FROM `post`,`lenta`,`inblog`
                    WHERE (`lenta`.`who` = %s && `lenta`.`type` = 0) ||
                    (`lenta`.`who`= `inblog`.`bname` && `lenta`.`type`= 1 && `inblog`.`name` = %s && `inblog`.`out` = 0 && `post`.`id`=`lenta`.`uid` && `post`.`auth`!= %s) ||
                    (`lenta`.`type` = 2 && ".$where." ) && `lenta`.`date` > %d GROUP BY `lenta`.`id`
                     ORDER BY `date` DESC  ",$usr->login,$usr->login,$usr->login,$dt));
                      db_query("SET SQL_BIG_SELECTS=0 ");
                } else {
                    $this->show = 0;
                }
                break;
            default:
                $new = 0;
        }

        if ($this->show) {
            $this->new = $new ? ("+" . $new) : '';
        }
    }
}

class mn {
    var $title;
    var $menu;
    var $menu_c;

    function gt () {
        echo $this->title;
    }

    function mg ($el) {
        return($this->menu[$el]);
    }
}

function cmenu($en) {
    $result = db_query('SELECT * FROM menu ORDER BY id ASC');
    $en->menu_c=0;
    while ($row = db_fetch_assoc($result)) {
        $en->menu[$en->menu_c]=new mel;
        $en->menu[$en->menu_c]->name=$row['name'];
        $en->menu[$en->menu_c]->url=$row['url'];
        $en->menu[$en->menu_c]->chcur();
        $en->menu_c++;
    }
    return ($en);
}
?>