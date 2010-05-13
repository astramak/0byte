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
header("Content-Type: image/jpeg");
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
session_start();

session_regenerate_id ();
$a=md5(session_id());
$a1=ord($a[2]);
$a2=ord($a[4]);
$zn=ord($a[6]);
while ($a1>15) {$a1=$a1-10; }
while ($a2>15) {$a2=$a2-10; }
if ($a2==0) $a2++;
$z=$zn;
if ($zn%2==0) { $zn='+';} else
if ($z%3==0) { $zn='*'; }
else { $zn='-'; }

$im = imagecreate(85,30);
$bg = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
$c1 = imagecolorallocate($im, rand(20,220), rand(20,220), rand(20,220));
$c2=$c1;
while (($c2==$c1) && ($c2=imagecolorallocate($im, rand(20,220), rand(20,220), rand(20,220)))) {}
imagecolortransparent($im,$bg);
$f1=rand(1,4);
$f2=$f1;
while(($f2=rand(2,3)) && ($f1==$f2)) { }
imagettftext ($im,rand(12,18), rand(-30,30), 5+rand(-2,5),rand(15,25) , $c1, "./".$f1.".ttf",$a1);
imagettftext ($im,rand(12,18), rand(-30,30), 55+rand(-2,5),rand(15,25), $c2, "./".$f2.".ttf",$a2);
imagettftext ($im,20, 0, 75, 20, $black, "./DejaVuSans.ttf",'=');
imagettftext ($im,20, 0, 35, 20, $black, "./DejaVuSans.ttf",$zn);
imagejpeg($im);
?>
