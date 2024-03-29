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
class blog {
    var $id;
    var $auth;
    var $name;
    var $ratep;
    var $ratem;
    var $av;
    var $about;
    var $owner;

    function blog($row = null) {
        if ($row) $this->make($row);
    }

    function make($record) {
        $alias = array('auth' => 'owner');
        foreach ($this as $prop => $val) {
            $this->{$prop} = $record[isset($alias[$prop]) ? $alias[$prop] : $prop];
        }
    }

    function rate() {
        return($this->ratep - $this->ratem);
    }
    /**
     * Make sql expression for special blogs
     *
     * @global array $special_blogs
     * @param string $id
     * @param string $operation
     * @param string $action
     * @return string
     */
    static function make_special_blogs($id='id',$operation='=',$action=' && ') {
        global $special_blogs;
        $sql=null;
        foreach ($special_blogs as $value) {
            $sql.='`'.$id.'` '.$operation.' '.get_int($value);
            if ($value!=end($special_blogs)) $sql.=$action;
        }
        return $sql;
    }
}
?>