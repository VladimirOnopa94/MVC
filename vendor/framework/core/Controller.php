<?php 
namespace framework\core;

use framework\core\Mail;
use framework\core\App;
use framework\core\Localization;


 /**
 * Класс контроллера приложения
 */
abstract class Controller 
{
	public $global_vars = [];
	public $title;
	protected $middlewares = [];
	public $layout;
	public $csrf ;
	public $meta = [];
	public $style = [];
	public $script = [] ;
	


	function __construct($layout = '')
	{
		if (is_null($this->layout)) { //Если не установлен глобальный шаблон в контроллере 
			$this->layout = $layout ?: LAYOUT; // Если в методе контроллера не переопределен шаблон, берем шаблон по умолчанию
		}else{
			$this->layout = $this->layout;
		}
		
		App::$app->request->getCSRFToken(); // Пишем в сессию CSRFToken

		Localization::getLang(); //Установить язык по умолчанию

		(!isset($this->csrf)) ? $this->csrf = true : $this->csrf;

		$this->checkCSRF();
		
	}

	/**
	 * Получает экземпляр Middleware
	 * @return array 
	 */
	public function getMiddlewares():array
	{
		return $this->middlewares;
	}

	/**
	 * Устанавливает Middleware
	 * @param Middleware $middleware
	 */
	public function Middleware(Middleware $middleware)
	{
		$this->middlewares[] = $middleware;
	}
		
	/**
	 * Передаем имя вида , данные , и вызываем файл вида
	 * @param  string  $view       [description]
	 * @param  array   $data       [description]
	 * @param  boolean $returnHtml [description]
	 */
	public function render($view = '', $data = array(), $returnHtml = false)
	{	
		$view = new View($view, $data, $this->layout, $this->title,  $this->meta,  $this->style,  $this->script,  $this->global_vars);
		$view->getView($returnHtml);
	}

	/**
	 * Подключение языкового файла
	 * @param  String $view 
	 */
	public function language($view)
	{
		$code = (isset($_COOKIE['lang'])) ? $_COOKIE['lang'] :  config('kernel.language')['def_lang'];

		Localization::includeLang($code, $view);
	}
	/**
	 * Задать заголовок
	 */
	public function setTitle($title)
	{
		if (isset($title) && !empty($title)) {
			$this->title = $title;
			return;
		}
		$this->title = '';
		return;
		
	}
	/**
	 * Установить мета тег
	 * @param  String $name 
	 * @param  String $content 
	 * @param  String $type 
	 */
	public function setMeta($name, $content, $type = 'name'){
		$this->meta[] = array('type' => $type, 'name' => $name, 'content' => $content);
	}
	/**
	 * Установить тег стилей
	 * @param  String $style 
	 */
	public function setStyle($style){ 
		$this->style[] = $style;
	}
	/**
	 * Установить тег скрипта
	 * @param  String $script 
	 */
	public function setScript($script){
		$this->script[] = $script;	
	}
	/**
	 * Проверка наличия и валидности переданого CSRF токена 
	 */
	private function checkCSRF ()
	{
		if ($this->csrf) { 

			if ($_SERVER['REQUEST_METHOD'] === 'POST') {

				if (!isset($_POST['token'])) {
					die("CSRF not passed");
				}
				if (!hash_equals($_SESSION['token'], $_POST['token'])) {
					die("CSRF is invalid");
				}
			}
		}
		
	}

	
	
}