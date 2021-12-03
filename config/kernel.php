<?php 

return [
	/*
		Параметры лога
	*/
	'log_param' => [
		'max_log_size' => 10240 , // максимальный размер файла, после которогор будет очищен
		'logs' => [ //массив файлов лога
			'error' => LOG . '/error.log',
			'success_register' => LOG . '/success.log',
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
		'def_lang' => 'ua',
		// список языков
		'langs' =>  [ 
			//'ru' => [ 'name' => 'Русский', 'image' => ''], 
			'ua' => [ 'name' => 'Украинский', 'image' => ''], 
			'en' => [ 'name' => 'Английский', 'image' => ''], 
		], 
		// отображать язык по умолчанию в url
		'show_default' =>  false 
	],
	/*
		Префиксы в url на которые не распостраняется формирование ссылки с языком
	*/
	'service_prefix' => ['api','panel_adm'],
	/*
		Компоненты 
	 */
	'components' => [
		'cache' => 'framework\core\Cache',
		'request' => 'framework\core\Request',
	],

];

