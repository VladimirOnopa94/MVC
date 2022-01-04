<?php 

/* Публичный каталог */
define("CATALOG", dirname(__FILE__) . '/public');
/* Каталог изображений */
define("IMAGE", CATALOG . '/image');
/* Каталог конфига */
define("CONFIG", dirname(__FILE__) . '/config');
/* Каталог приложения */
define("APP", dirname(__FILE__) . '/app');
/* Корень сайта */
define("ROOT", dirname(__FILE__));
/* Каталог хранилище */
define("STORAGE", dirname(__FILE__) . '/storage');
/*Каталог логов*/
define("LOG", STORAGE . '/log');
/*Каталог кэша*/
define("CACHE", STORAGE . '/cache');
/* Отладка */
define("DEBUG", [
	'enable' => true,
	// список ip (необязательно) с которых видны ошибки (не указав, ошибки будут видны всем если enable => true) 
	'ip' =>  [ 
		//'188.163.94.58'
	]  
]);
/* Шаблон по умолчанию */
define("LAYOUT", 'default');
