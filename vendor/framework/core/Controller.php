<?php 
 /**
 * 
 */
namespace framework\core;
use framework\core\Logger;
use framework\core\Language;
use Exception;

//use framework\core\ErrorHandler;

abstract class Controller 
{

	public $layout;
	public $logger;
	public $csrf ;

	function __construct($layout = '')
	{
		$this->layout = $layout ?: LAYOUT;

		$this->logger = new Logger;

		(!isset($this->csrf)) ? $this->csrf = true : $this->csrf;

		$this->checkCSRF();
		//new ErrorHandler();	
	}

	
	/*
		Передаем имя вида , данные , и вызываем файл вида
	*/
		
	public function render($view = '', $data = array() )
	{
		$view = new View($view, $data, $this->layout);
		$view->getView();

	}

	/*
		Подключение языкового файла
	*/

	public function language($view)
	{
		Language::includeLang($_COOKIE['lang'], $view);
	}

	/*
		Проверка наличия и валидности переданого CSRF токена 
	*/

	private function checkCSRF ()
	{
		if ($this->csrf) { 
			if ($_SERVER['REQUEST_METHOD'] === 'POST') {
				if (!isset($_POST['token'])) {
					die("CSRF not passed");
					if (!hash_equals($_SESSION['token'], $_POST['token'])) {
						die("CSRF is invalid");
					}
				}
			}
		}
		
	}

	
	
}