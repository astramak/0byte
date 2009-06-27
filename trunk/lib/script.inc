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

class script {
    var $text;
    function  __construct() {
        $this->flush();
    }
    function add($what) {
        $this->text.=$what;
    }
    function flush() {
        $this->text=null;
    }
    function result() {
        return '<script type="text/javascript">'. $this->text.'</script>';
    }
    function write($flush=1) {
        echo $this->result();
        if ($flush) {
            $this->flush();
        }
    }
}
?>
