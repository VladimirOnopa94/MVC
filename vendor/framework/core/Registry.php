<?php 	

namespace framework\core;

class Registry
{ 
	
	public static $storage = []; // хранилище 

	protected static $instance ; // объект

 	public static $components = []; //Компоненты

	/**
	 * Создание экземпляра объекта и добавление в хранилище компонентов
	 */
	public static function instance()
	{ 
		self::$components= config('kernel.components');

		if (self::$instance === null) {
			self::$instance = new self;
		}
		foreach (self::$components as $key => $component) {
			self::$storage[$key] = new $component;
		}


		return self::$instance;
	}
	/**
	 * Установка значения.
	 */
	public function __set($key, $value)
	{ 
		if(!isset(self::$storage[$key])){
			self::$storage[$key] = new $value;    
		}
	}
 
	/**
	 * Получение значения.
	 */
	public function __get($key)
	{
		return (is_object(self::$storage[$key])) ? self::$storage[$key] : null;
	}

	public static  function list(){

		return self::$storage;
	}
 
	
}