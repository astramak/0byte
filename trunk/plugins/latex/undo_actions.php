<?php
$text = preg_replace ("/\<img src\='http:\/\/latex\.codecogs\.com\/gif\.latex\?(.*?)' alt='(.*?)' />/is", "[latex]$1[/latex]", $text);
?>
