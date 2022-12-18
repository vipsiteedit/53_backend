<?php
//# ! /usr/local/bin/php
error_reporting(0);
define('SE_INDEX_INCLUDED', true);
session_start();
date_default_timezone_set('Europe/Moscow');
//function setaction(){
chdir($_SERVER['DOCUMENT_ROOT']);
if (empty($_SERVER['DOCUMENT_ROOT'])) {
    define('SE_ROOT', '');
} 
else {
    $se_root = (substr($_SERVER['DOCUMENT_ROOT'], -1) == '/') ? $_SERVER['DOCUMENT_ROOT'] : $_SERVER['DOCUMENT_ROOT'] . '/';
    define('SE_ROOT', $se_root);
}
define('SE_INDEX_INCLUDED', true);
require 'system/main/init.php';
$payment = new plugin_payment(0, 0);
$payment->result();