<?php
require_once 'htmlpurifier-4.0.0/library/HTMLPurifier.auto.php';
$text = preg_replace ("/\<quote\>(.*?)\<\/quote\>/is", '<div class="quote">$1</div>', $text);
$text = preg_replace ("/\<code lang='([^']*)'\>(.*?)\<\/code\>/is", '[code=$1]$2[/code]', $text);
$text = preg_replace ('/\<code lang="([^"]*)"\>(.*?)\<\/code\>/is', '[code=$1]$2[/code]', $text);
$config = HTMLPurifier_Config::createDefault();
$config->set('Output.Newline','<br />');
$purifier = new HTMLPurifier($config);
$text = $purifier->purify( $text );
$text = preg_replace('/ xml\:lang\="([^"]*)"/is', "", $text);
?>