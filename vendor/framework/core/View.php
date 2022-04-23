<?php 

namespace framework\core;
use Exception;

/**
 *  View class
 */
class View 
{
	
	public $view ;
	public $global_vars ;
	public $data ;
	public $layout ;
	public $title ;
	public $meta ;
	public $style ;
	public $script ;

	function __construct($view, $data, $layout, $title, $meta, $style, $script, $global_vars)
	{
		$this->view = $view;
		$this->global_vars = $global_vars;
		$this->data = $data;
		$this->layout = $layout;
		$this->title = $title;
		$this->meta = $meta;
		$this->style = $style;
		$this->script = $script;
	}
	/**
	 * Получить meta
	 * @return  array $meta 
	 */
	public function getMeta(){
		if (isset($this->meta) && !empty($this->meta)) {
			return $this->meta;
		}		
	}
		/**
	 * Получить style
	 * @return  array $style 
	 */
	public function getStyle(){
		if (isset($this->style) && !empty($this->style)) {
			return $this->style;
		}		
	}
	/**
	 * Получить script
	 * @return  array $script 
	 */
	public function getScript(){
		if (isset($this->script) && !empty($this->script)) {
			return $this->script;
		}		
	}
	/**
	 * Подключение языкового файла
	 * @param  String $view 
	 */
	public function language($view)
	{
		localization::includeLang($_COOKIE['lang'], $view);
	}
	/**
	 * Подключаем файл вида 
	 * @param  boolean $returnHtml 
	 */
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
	

	/**
	 * Получить заголовок страницы
	 * @return string
	 */
	public function getTitle()
	{
		if (isset($this->title) && !empty($this->title)) {
			return $this->title;
		}
		return '';
	}

	/**
	 * Передаем имя вида , данные , и вызываем файл вида
	 * @param  string $view 
	 * @param  array  $data 
	 */
	public function render($view = '', $data = array())
	{	

		$view = ltrim($view,'/');
		
		$file_view = APP . "/views/" . $view . ".php";
		
		if (isset($data)) { //Извлекаем переменные из контроллера для view
			extract($data);
		}

		//Извлекаем "глобальные" переменные из пользовательского контроллера /app/controllers/Controller
		if (isset($this->global_vars)) { 
			extract($this->global_vars);
		}

		if (is_file($file_view)){
			require $file_view;
		}else{
			throw new Exception("View {$file_view} not found !");
		}


	}

}