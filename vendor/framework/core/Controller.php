<?php 
 /**
 * 
 */
namespace framework\core;
use framework\core\Logger;

abstract class Controller 
{

	public $layout;
	public $logger;

	function __construct($layout = '')
	{
		$this->layout = $layout ?: LAYOUT;
		$this->logger = new Logger;


	}

	//
	// Передаем имя вида , данные , и вызываем файл вида
	//

	public function render($view = '', $data = array() )
	{

		$view = new View($view, $data, $this->layout);

		$view->getView();

	}
	
}