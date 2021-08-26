<?php 


namespace framework\core;

use \framework\core\Db;

abstract class Model
{
	protected $pdo;
	protected $table;

	function __construct()
	{
		$this->pdo = Db::instance();
	}


}