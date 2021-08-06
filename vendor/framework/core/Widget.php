<?php 

namespace framework\core;

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


		$view = ltrim($result['view'],'/');
		
		$file_view = APP . "/views/" . $view . ".php";

		if (is_file($file_view)){

			require_once $file_view;

		}else{

			echo "View " . $file_view . " not found !";

		}

		
	}


}