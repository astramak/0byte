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
header('Content-type: image/'.preg_replace ('/(.*?)\.(.*?)/is', '$2', $_GET['img']));
header('Content-Disposition:  filename='.$_GET['img']);
header("Expires: Thu, 01 Jan 2013 00:00:01  GMT");
header("Cache-control: public");
ob_start("ob_gzhandler");
readfile("tmp/".$_GET['t']."/".$_GET['img']);
?>