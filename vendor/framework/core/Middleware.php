<?php 
 /**
 *  Middleware дает возможность передавать запрос в пользовательский Middleware
 	перед передачей запроса пользовательскому контроллеру
 */
namespace framework\core;


abstract class Middleware
{

	public function __construct($actions = [])
	{
		$this->actions = $actions;
	}
   
    abstract public function execute();
    

    
}  