<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
$text = preg_replace('/\[user\](.*?)\[\/user\]/is', '<user>$1</user>', $text);
$text = preg_replace ("/\[code\](.*?)\[\/code\]/is", '[code]$1[/code]', $text);
$text = preg_replace ("/\[code=([^\]]*)](.*?)\[\/code\]/is", '<code lang="$1">$2</code>', $text);
$text = preg_replace ('/\<div class\="quote"\>(.*?)\<\/div\>/is', '<quote>$1</quote>', $text);
$text=str_replace('<br />', "\n", $text);
?>
