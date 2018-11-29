<?php
//Подключаем все классы портала
require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';

//подключаемся к базе
$DB_USER = 'root';
$DB_PASS = '';
$DB_HOST = 'localhost';

define ('DB_NAME', 'wiloplus');

//Объявляем глобальную переменную - объект PDO::MySQL
$dbObject = new PDO('mysql:host='.$DB_HOST.';dbname='.DB_NAME."", $DB_USER, $DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET CHARACTER SET utf8"));
//;charset=utf-8


$dbObject->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$dbObject->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


Route::start(); // запускаем маршрутизатор




