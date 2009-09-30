<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$text = preg_replace ('/\<div class\="quote"\>(.*?)\<\/div\>/is', '<quote>$1</quote>', $text);
$text=str_replace('<br />', "\n", $text);
?>
