<?php
//inside you will find all the configurations of this webpage
setlocale(LC_TIME, "es_MX.UTF-8");
date_default_timezone_set("America/Mexico_City");
//URL
define("LOCAL","http://192.168.1.71/");
define('URL', constant("LOCAL") . "social_network/");
//connection
define('USER', 'root');
define('PASSWORD', 'Alejandrom8');
define('HOST', 'localhost');
define('DB', 'users');
define('CHARSET', 'utf8');
//TABLAS
define('TABLA_REGISTRO', 'registros');
//carpeta donde se guardaran las fotos
define('CARPETA_FOTOS', $_SERVER['DOCUMENT_ROOT'] . '/intranet/uploads/');
define('URL_FOTOS', constant('LOCAL') . "intranet/uploads/");
define('CARPETA_MENSAJES', $_SERVER['DOCUMENT_ROOT'] . '/intranet/mensajes/');
//constantes visibles
define('DEFAULT_FOTO', constant("LOCAL") ."intranet/uploads/porfile-default.png");
//Cantidades
define('MAX_FOTO_SIZE', 50000000);//6.25 MB
define('MAX_SEARCH_RESULTS', 40);
?>
