<?php 
ob_start();
session_start();
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
require_once 'config.php';
require_once 'application/boot.php';
header("Access-Control-Allow-Origin: ".CORS_SERVER);
header("Access-Control-Allow-Methods: POST,GET");
header("Access-Control-Allow-Headers: *");
?>