<?php 

return [
	/*
		Параметры лога
	*/
	'log_param' => [
		'log_dir' =>  ROOT . '/log' , 
		'maxLogSize' => 10240 , // максимальный размер файла, после которогор файл будет очищен
		'logs' => [ //массив файлов лога
			'error' => ROOT . '/log/error.log',
			'success_register' => ROOT . '/log/register/success.log',
			'fail_payment' => ROOT . '/log/payment/fail.log'
		]
	],
	/*
		Список событий и их слушателей
	*/
	'events' => [
		'app\components\events\RegisterUserEvent' => [
			'app\components\listeners\RegisterListener',
		]
	],
	/*
		Настройка языков
	*/
	'language' => [ 
		'def_lang' => 'ru',
		// список языков
		'langs' =>  [ 
			'ru' => [ 'name' => 'Русский', 'image' => ''], 
			'ua' => [ 'name' => 'Украинский', 'image' => ''], 
			'en' => [ 'name' => 'Английский', 'image' => ''], 
		], 
		// отображать язык по умолчанию в url
		'show_default' =>  true 
	],
	/*
		Префиксы в url на которые не распостраняется формирование ссылки с языком
	*/
	'service_prefix' => ['api'],

	

];

