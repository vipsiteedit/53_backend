<?php

session_start();
ini_set('display_errors', 'Off');
error_reporting(0);
date_default_timezone_set('Europe/Moscow');
define('SE_INDEX_INCLUDED', true);
require 'system/main/init.php';
require_once "system/main/googlemarket.php";

//Header("'Content-type: application/xml'");
header("Content-Type: text/xml");
header("Expires: Thu, 19 Feb 1998 13:24:18 GMT");
header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0,pre-check=0");
header("Cache-Control: max-age=0");
header("Pragma: no-cache");
echo se_googlemarket();
//Header("Location: modules/download/$sid/$filename");

?>