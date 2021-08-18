<?php 

namespace framework\core;
use Exception;
/**
 *  Класс переводов
 */
class Language 
{

	public static $lang_data = [];

	/*
	 Подключение файлов по имени вида
	*/
	public static function init ($code = LANG['def_lang'], $view )
	{

		$lang_file = APP . '/language/' . $code . '/' .$view . '.php';
		
		if (file_exists($lang_file)) {
			self::$lang_data = require_once $lang_file;
		}

	}

	/*
	Получить фаруз по ключу 
	*/
	public static function get ($key)
	{
		return isset(self::$lang_data[$key]) ? self::$lang_data[$key] : $key;
	}


}