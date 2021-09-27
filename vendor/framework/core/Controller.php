<?php 
 /**
 * 
 */
namespace framework\core;
use framework\core\Logger;
use framework\core\Language;
use framework\core\Mail;
use framework\core\Auth\Authenticate;
use Exception;

//use framework\core\ErrorHandler;

abstract class Controller 
{

	public $title;
	public $layout;
	public $logger;
	public $csrf ;
	
	use Authenticate;

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
		$view = new View($view, $data, $this->layout,  $this->title);
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
					if (!hash_equals($_SESSION['token'], $_POST['token'])) {
						die("CSRF is invalid");
					}
				}
			}
		}
		
	}

	
	
}