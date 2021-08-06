<?php 
 /**
 * 
 */
namespace framework\core;

abstract class Controller 
{

	public $layout;

	function __construct($layout = '')
	{
		$this->layout = $layout ?: LAYOUT;

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