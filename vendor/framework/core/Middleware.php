<?php 
 /**
 *  Middleware дает возможность передавать запрос в пользовательский Middleware
 	перед передачей запроса пользовательскому контроллеру
 */
namespace framework\core;
use framework\core\Auth\Authenticate;

abstract class Middleware
{

	use Authenticate;

	/**
	 * Записать массив методов на которые действует Middleware
	 * @param array $actions 
	 */
	public function __construct($actions = [])
	{
		$this->actions = $actions;
	}
   	/**
   	 * Выполнить скрипт  
   	 */
    abstract public function execute();
    

    
}  