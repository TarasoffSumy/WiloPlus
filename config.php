<?php
//верхний уровень
$rpath = $_SERVER['DOCUMENT_ROOT'];
//директория портала
define ('ROOT_DIRECTORY' , '/WiloPlus');
//определяем путь к файлам
define ('FULL_PATH', $rpath.ROOT_DIRECTORY);
//тестирование контроллера
define ('CONTROLLER_TEST_MODE' , TRUE);

define ('CORS_SERVER', 'http://localhost:8080');

//подключаем библиотеку для генерации и вывода pdf
//include_once FULL_PATH.'/mPDF/mpdf.php';

?>