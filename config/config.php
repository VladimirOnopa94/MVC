<?php 

ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

/* Публичный каталог */
define("PUBLIC", dirname(__DIR__).'/public');
/* Каталог конфига */
define("CONFIG", dirname(__DIR__).'/config');
/* Каталог приложения */
define("APP", dirname(__DIR__).'/app');
/* Корень сайта */
define("ROOT", dirname(__DIR__));
/* Каталог кэша */
define("CACHE", dirname(__DIR__).'/cache');
/* Шаблон по умолчанию */
define("LAYOUT", 'default');
