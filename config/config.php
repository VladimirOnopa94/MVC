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
/* Логи */
define("LOG_PARAM", 
	[
		'log_dir' =>  ROOT . '/log' , // директория логов
		'maxLogSize' => 10240 , // максимальный размер файла, после которогор файл будет очищен
		'logs' => [ //массив файлов логов
			'success_register' => ROOT . '/log/register/success.log',
			'fail_payment' => ROOT . '/log/payment/fail.log'
		] 
	]
);
/* Шаблон по умолчанию */
define("LAYOUT", 'default');
