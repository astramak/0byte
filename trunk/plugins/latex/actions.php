<?php
$text = preg_replace ("/\[latex\](.*?)\[\/latex\]/is", "<img src='http://latex.codecogs.com/gif.latex?$1' alt='$1' />", $text);
?>
