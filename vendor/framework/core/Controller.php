<?php 
 /**
 * 
 */
namespace framework\core;
use framework\core\Logger;
use framework\core\Language;
use framework\core\ErrorHandler;

abstract class Controller 
{

	public $layout;
	public $logger;

	function __construct($layout = '')
	{
		$this->layout = $layout ?: LAYOUT;
		$this->logger = new Logger;
		new ErrorHandler();	
	}

	//
	// Передаем имя вида , данные , и вызываем файл вида
	//

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
		Language::init($_COOKIE['lang'], $view);
	}

	
	
}