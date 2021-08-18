<?php 

namespace framework\core;

/**
 * 
 */
class View 
{
	
	public $view ;
	public $data ;
	public $layout ;

	function __construct($view, $data, $layout)
	{
		$this->view = $view;
		$this->data = $data;
		$this->layout = $layout;

	}

	//
	//Подключаем файл вида 
	//

	public function getView ()
	{
		
		$view = ltrim($this->view,'/');
		
		$file_view = APP . "/views/" . $view . ".php";

		ob_start(); // Буферезируем вывод для шаблона layout

		if (isset($this->data)) { //Извлекаем переменные из контроллера для view
			extract($this->data);
		}

		if (is_file($file_view)){

			require_once $file_view;

		}else{

			echo "View " . $file_view . " not found !";

		}

		$content = ob_get_clean(); // Выводим переменную в layout шаблоне

		$file_layout = APP . '/views/layouts/' . $this->layout . '.php';

		if (is_file($file_layout)){

			require_once $file_layout;

		}else{

			echo "Layout " . $file_layout . " not found !";

		}
	}

}