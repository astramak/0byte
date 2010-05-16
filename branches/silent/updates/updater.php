<?php

function ulog($item) {
	echo '* ' . $item . "\n";
}

DEFINE('MPATH', 'migration/');

require('../config.php');
require('../lib/cache.inc');
require('../lib/db.inc');

// checking for version table
$tables = DB::tables();

if (!in_array('version', $tables)) {
	// creating update table if it doesn't exists
	DB::exec('create table version (id int primary key, updated int(10));');
}

$dbversion = DB::selectFirstVal('select max(id) from version');

if (!$dbversion)
	$dbversion = 0;
	
foreach(glob(MPATH . '*.php') as $path) {
	$filename = str_replace(MPATH, '', $path);
	
	preg_match('/^([0-9]+)/', $filename, $matches);
	
	if (!$matches)
		continue;
	
	$version = (int) $matches[0];
	
	if ($version > $dbversion)
		break;
}

if ($dbversion >= $version)
	die('There is nothing to update');

$path = dirname(__FILE__) . '/' . $path;

require($path);
	
if (
	isset($_GET['doit'])
	&& intval($_GET['doit']) == $version
) {
	echo '<pre>';
	$result = update();
	echo '</pre><hr />';
	
	if (!$result)
		die('Failed to update');
		
	DB::exec('insert into version select %d, %d', array($version, time()));
	
	echo <<<EOF
Success!
EOF;
} else {
	$description = function_exists('description') ? description() : 'no description';
	
	echo <<<EOF
Update script {$filename}:
<pre>
{$description}
</pre>
	
<a href="?doit={$version}">Update to version {$version}</a>
EOF;
}

