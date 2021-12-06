<?php 

/*Каталог логов*/
define("LOG", dirname(__FILE__) . '/tmp/log');
/*Каталог кэша*/
define("CACHE", dirname(__FILE__) . '/tmp/cache');
/* Публичный каталог */
define("CATALOG", dirname(__FILE__) . '/public');
/* Каталог конфига */
define("CONFIG", dirname(__FILE__) . '/config');
/* Каталог приложения */
define("APP", dirname(__FILE__) . '/app');
/* Корень сайта */
define("ROOT", dirname(__FILE__));
/* Отладка */
define("DEBUG", [
	'enable' => true,
	// список ip (необязательно) с которых видны ошибки (не указав, ошибки будут видны всем при enable => true) 
	'ip' =>  [ 
		//'188.163.94.58'
	]  
]);
/* Шаблон по умолчанию */
define("LAYOUT", 'default');
