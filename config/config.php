<?php 
ini_set('memory_limit', '256M');
/* Публичный каталог */
define("PUBLIC", dirname(__DIR__).'/public');
/* Каталог конфига */
define("CONFIG", dirname(__DIR__).'/config');
/* Каталог приложения */
define("APP", dirname(__DIR__).'/app');
/* Корень сайта */
define("ROOT", dirname(__DIR__));

define("DEBUG", true);
/* Логи */
define("LOG_PARAM", [
	'log_dir' =>  ROOT . '/log' , 
	'maxLogSize' => 10240 , // максимальный размер файла, после которогор файл будет очищен
	'logs' => [ //массив файлов лога
		'error' => ROOT . '/log/error.log',
		'success_register' => ROOT . '/log/register/success.log',
		'fail_payment' => ROOT . '/log/payment/fail.log'
	] 
]);
/*Языки*/
define("LANG", [
	'def_lang' => 'ru',
	'langs' =>  [ // список языков
		'ru' => [ 'name' => 'Русский', 'image' => ''], 
		'ua' => [ 'name' => 'Украинский', 'image' => ''], 
		'en' => [ 'name' => 'Английский', 'image' => ''], 
	] , 
	'show_default' =>  true // отображать язык по умолчанию в url
]);
/* Шаблон по умолчанию */
define("LAYOUT", 'default');
