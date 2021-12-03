<?php 
namespace framework\core;

use  framework\core\Registry;

/**
 * Класс содержащий все объекты с конфига kernel 'components'
 */
class App 
{
	public static $app ; // объект
	
	public function __construct(){

		self::$app = Registry::instance();

	}
	
}