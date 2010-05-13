<?php
header("Content-type: text/javascript");
ob_start("ob_gzhandler");
include(str_replace("/","",$_GET['js']));
?>