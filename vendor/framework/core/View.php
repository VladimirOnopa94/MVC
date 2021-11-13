<?php 

namespace framework\core;
use Exception;

//use framework\core\Auth\Authenticate;

/**
 *  View class
 */
class View 
{
	
	public $view ;
	public $data ;
	public $layout ;
	public $title ;
	//use Authenticate;

	function __construct($view, $data, $layout, $title)
	{
		$this->view = $view;
		$this->data = $data;
		$this->layout = $layout;
		$this->title = $title;
	}

	//
	//Подключаем файл вида 
	//
	public function getView ($returnHtml)
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
			throw new Exception("View {$file_view} not found !");
		}
		
		if ($returnHtml) {
			$html = ob_get_clean(); 
			echo json_encode($html);
			return true;
		}	
		$content = ob_get_clean(); // Выводим переменную в layout шаблоне

		$file_layout = APP . '/views/layouts/' . $this->layout . '.php';

		if (is_file($file_layout)){
			require_once $file_layout;
		}else{
			throw new Exception("Layout {$file_layout} not found !");
		}
	}
	
	/*
		Получить заголовок страницы
	*/
	public function getTitle()
	{
		if (isset($this->title) && !empty($this->title)) {
			return $this->title;
		}
		return '';
		
	}

	/*
		Передаем имя вида , данные , и вызываем файл вида
	*/	
	public function render($view = '', $data = array())
	{	

		$view = ltrim($view,'/');
		
		$file_view = APP . "/views/" . $view . ".php";
		
		if (isset($data)) { //Извлекаем переменные из контроллера для view
			extract($data);
		}

		if (is_file($file_view)){
			require_once $file_view;
		}else{
			throw new Exception("View {$file_view} not found !");
		}


	}

}