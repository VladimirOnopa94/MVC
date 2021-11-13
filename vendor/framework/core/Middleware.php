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

	public function __construct($actions = [])
	{
		$this->actions = $actions;
	}
   
    abstract public function execute();
    

    
}  