<?php
//inside you will find all the configurations of this webpage
setlocale(LC_TIME, "es_MX.UTF-8");
date_default_timezone_set("America/Mexico_City");
//URL
define('URL', 'http://localhost/social_network/');
//connection
define('USER', 'root');
define('PASSWORD', 'Alejandrom8');
define('HOST', 'localhost');
define('DB', 'users');
define('CHARSET', 'utf8');
define('MAX_FOTO_SIZE', 50000000);//6.25 MB

//TABLAS
define('TABLA_REGISTRO', 'registros');
//carpeta donde se guardaran las fotos
define('CARPETA_FOTOS', $_SERVER['DOCUMENT_ROOT'] . '/intranet/uploads/');
?>
