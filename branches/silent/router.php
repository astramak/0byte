<?php

require('config.php');

$request = isset($_SERVER['REQUEST_URI']) ? explode('/', $_SERVER['REQUEST_URI']) : array();

// unset unusable parts
foreach($request as $key => $value) {
	if (trim($value) == '')
		unset($request[$key]);
}

// second one is the controller name
$controller = array_shift($request);
$controller_path = 'controller/' . $controller . '.php';
$controller_class = ucfirst($controller) . '_Controller';

if (!file_exists($controller_path)) {
	// it is wrong path
	header("HTTP/1.1 404 Not Found");
	die();
}

// some modules
require('lib/cache.inc');
require('lib/db.inc');

// require our main parent
require('controller/controller.php');

// and then require the requested controller
require($controller_path);

$ctrl = new $controller_class($request);

// lets turn on output buffering
ob_start();

// and handle a request with a controller
$ctrl->handle();
