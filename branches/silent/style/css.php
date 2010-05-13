<?php 
header("Content-type: text/css");
ob_start("ob_gzhandler");
include(str_replace("/","",$_GET['css']));
?>