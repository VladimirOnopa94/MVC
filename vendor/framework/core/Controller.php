<?php 
namespace framework\core;

use framework\core\Mail;
use framework\core\Csrf;
use framework\core\Logger;
use framework\core\Language;
use framework\core\Auth\Authenticate;
 /**
 * Класс контроллера приложения
 */
abstract class Controller 
{

	public $title;
	protected $middlewares = [];
	public $layout;
	public $logger;
	public $csrf ;
	
	use Authenticate;

	function __construct($layout = '')
	{
		$this->layout = $layout ?: LAYOUT;

		$this->logger = new Logger;

		CSRF::getCSRFToken(); // Пишем в сессию CSRFToken

		(!isset($this->csrf)) ? $this->csrf = true : $this->csrf;

		$this->checkCSRF();
		
	}

	/*
		Получает экземпляр Middleware
	*/
	public function getMiddlewares():array
	{
		return $this->middlewares;
	}

	/*
		Устанавливает Middleware
	*/
	public function Middleware(Middleware $middleware)
	{
		$this->middlewares[] = $middleware;
	}
	
	/*
		Передаем имя вида , данные , и вызываем файл вида
	*/	
	public function render($view = '', $data = array(), $returnHtml = false)
	{	
		$view = new View($view, $data, $this->layout, $this->title);
		$view->getView($returnHtml);
	}

	/*
		Подключение языкового файла
	*/
	public function language($view)
	{
		Language::includeLang($_COOKIE['lang'], $view);
	}

	/*
		Функция отправки писем
	*/
	public function sendMail($subject, $message, $to, $headers, $view, $data)
	{
		$mail = new Mail($subject, $message, $to, $headers, $view, $data);
		$mail = $mail->init();
	}

	/*
		Задать заголовок
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
	
	/*
		Проверка наличия и валидности переданого CSRF токена 
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