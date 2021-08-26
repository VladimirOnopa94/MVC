<?php 

namespace framework\core;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 *  DB
 */

class Db 
{
	protected static $instance;

	protected function __construct()
	{
		$db = require ROOT . '/config/db.php';

		$capsule = new Capsule;

		$capsule->addConnection([
		    'driver' => $db['driver'],
		    'host' => $db['host'],
		    'database' => $db['dbname'],
		    'username' => $db['user'],
		    'password' => $db['password'],
		    'charset' => $db['charset'],
		    'collation' => 'utf8_unicode_ci',
		    'prefix' => '',
		]);

		$capsule->setAsGlobal();  //this is important
		$capsule->bootEloquent();
		

	}

	public static function instance() 
	{
		if (self::$instance === null) {
			self::$instance = new self ;
		}
		return self::$instance;
	}

}