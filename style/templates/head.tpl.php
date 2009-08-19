<?php echo "<?xml version='1.0' encoding='UTF-8'?>\r\n"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru">
	<head>
		<base href="<?php echo $base; ?>" />
		<title><?php echo $title ?></title>
		<meta name="keywords" content="<?php echo $kwd ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<link rel="shortcut icon" href="<?php echo $site ?>favicon.ico" type="image/x-icon" />
		<link rel="stylesheet" href="style/css.php?css=new.css" type="text/css" />
		<link rel="search" type="application/opensearchdescription+xml" href="<?php echo $site ?>opensearch.php" title="<?php echo $sl_name; ?>" />
		<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php echo $rss ?>" />
        <?php echo $SCRIPT; ?>
	</head>
	<body onkeydown="to_(event)">