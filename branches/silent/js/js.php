<?php

// @todo refactoring (see css.php)
    
if (!isset($_GET['js']))
    die();
    
$filename = $_GET['js'];

// test it
    
if (!preg_match('/^[a-z]+\.js$/i', $filename))
    die();

// great, lets check it

$filename = __DIR__ . '/' . $filename;

if (!file_exists($filename))
    die();
    
$lastModified = filemtime($filename);

// send header with last modified date

header('Last-Modified: ' . gmdate('D, d M Y H:i:s', $lastModified) . ' GMT');

// lets get all headers to find "If-Modified-Since"

$request = getallheaders();

$modifiedSince = 0;

if (isset($request['If-Modified-Since'])) {
    $modifiedSince = strtotime($request['If-Modified-Since']);

    // set it to zero if strtotime fails
    
    if ( !$modifiedSince ) {
        $modifiedSince = 0;
    }
}

// don't send content that we already have in browser cache

if ($lastModified <= $modifiedSince) { 
    header('HTTP/1.1 304 Not Modified'); 
    die();
} 

// additionally set the expiration date +1 hour

header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 60 * 60) . ' GMT');

// return content only if it is really needed

header("Content-type: text/javascript");

ob_start( "ob_gzhandler" );
include( $filename );
