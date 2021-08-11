<?php 

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
define("LOG_PARAM", 
	[
		'log_dir' =>  ROOT . '/log' , 
		'maxLogSize' => 10240 , // максимальный размер файла, после которогор файл будет очищен
		'logs' => [ //массив файлов лога
			'error' => ROOT . '/log/error.log',
			'success_register' => ROOT . '/log/register/success.log',
			'fail_payment' => ROOT . '/log/payment/fail.log'
		] 
	]
);
/* Шаблон по умолчанию */
define("LAYOUT", 'default');
