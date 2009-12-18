<?php
require_once 'htmlpurifier-4.0.0/library/HTMLPurifier.auto.php';
$text = str_replace('<cut/>', '[cut]', $text);
$text = str_replace('<fcut/>', '[fcut]', $text);
$text = preg_replace('/\<user\>(.*?)\<\/user\>/is', '[user]$1[/user]', $text);
$text = preg_replace('/\<spoiler\>(.*?)\<\/spoiler\>/is', '<div class="spoiler">$1</div>', $text);
$text = preg_replace ("/\<quote\>(.*?)\<\/quote\>/is", '<div class="quote">$1</div>', $text);
$text = preg_replace ("/\<code\>(.*?)\<\/code\>/is", '[code]$1[/code]', $text);
$text = preg_replace ("/\<code lang='([^']*)'\>(.*?)\<\/code\>/is", '[code=$1]$2[/code]', $text);
$text = preg_replace ('/\<code lang="([^"]*)"\>(.*?)\<\/code\>/is', '[code=$1]$2[/code]', $text);
$text = preg_replace(
    "/\[code\](.*?)\[\/code\]/ise",
    "'[code]' . prepare_code('$1') . '[/code]'",
    $text
);
$text = preg_replace(
    "/\[code([^\]]*?)\](.*?)\[\/code\]/ise",
    "'[code$1]' . prepare_code('$2') . '[/code]'",
    $text
);

$config = HTMLPurifier_Config::createDefault();
$config->set('Output.Newline','<br />');
$purifier = new HTMLPurifier($config);
$text = $purifier->purify( $text );
$text = preg_replace('/ xml\:lang\="([^"]*)"/is', "", $text);
?>