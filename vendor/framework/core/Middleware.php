<?php 
 /**
 *  Middleware дает возможность передавать запрос в пользовательский Middleware
 	перед передачей запроса пользовательскому контроллеру
 */
namespace framework\core;

use framework\core\Localization;

abstract class Middleware
{

	/**
	 * Записать массив методов на которые действует Middleware
	 * @param array $actions  
	 * @param array $data опциональные данные
	 */
	public function __construct($actions = [], $data = [])
	{
		$this->actions = $actions;
		$this->data = $data;
	}
   	/**
   	 * Выполнить скрипт  
   	 */
    abstract public function execute();

    /**
	 * Подключение языкового файла
	 * @param  String $view 
	 */
	public function language($view)
	{
		$code = (isset($_COOKIE['lang'])) ? $_COOKIE['lang'] :  config('kernel.language')['def_lang'];

		Localization::includeLang($code, $view);
	}
    

    
}  