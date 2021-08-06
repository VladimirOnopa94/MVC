<?php 

namespace framework\core;

/**
 *  DB
 */

class Db 
{
	protected $pdo;
	protected static $instance;

	protected function __construct()
	{
		$db = require ROOT . '/config/db.php';

		$options = [
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
		];

		$this->pdo = new \PDO ( $db['dsn'], $db['user'], $db['password'], $options);
	}

	public static function instance() 
	{
		if (self::$instance === null) {
			self::$instance = new self ;
		}
		return self::$instance;
	}

	public  function execute($sql ,$params = []) 
	{
		$stmp = $this->pdo->prepare($sql);

		return $stmp->execute($params);
	}

	public  function query($sql,$params = []) 
	{
		$stmp = $this->pdo->prepare($sql);

		$res = $stmp->execute($params);

		if ($res !== false) {
			return $stmp->fetchAll();
		}

		return [];
	}
}