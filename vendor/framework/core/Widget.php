<?php 

namespace framework\core;
use framework\core\Language;
use Exception;

/**
 * 
 */
class Widget 
{

	//
	//Подключаем файл вида и передаем переменные 
	//

	public static function widget ()
	{

		$class = get_called_class();
		$obj = new $class;

		$result = $obj->run();

		if (isset($result)) { //Извлекаем переменные из контроллера для view
			extract($result);
		}

		try{
		   	/*Если не установлен путь к виду*/
			if (isset($result['view'])){
				$view = ltrim($result['view'],'/');
		
				$file_view = ROOT . "/vendor/framework/widgets/views/" . $view . ".php";
			}else{
		    	throw new Exception("View path not set");
		    }


		    try{
		   		/*Если нет такого вида по заданому пути*/
				if (is_file($file_view)){
					require_once $file_view;
				}else{
			    	throw new Exception("View " . $file_view . " not found !");
			    }
			} 
			catch (Exception $ex) {
			    echo $ex->getMessage();
			}

		} 
		catch (Exception $ex) {
		    echo $ex->getMessage();
		}
	}
	/*
	Подключение языкового файла
	*/
	public function language($view)
	{
		Language::includeLang($_COOKIE['lang'], $view);
	}


}