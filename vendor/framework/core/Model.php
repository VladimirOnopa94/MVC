<?php 


namespace framework\core;

use vendor\core\Db;

abstract class Model
{
	protected $pdo;
	protected $table;

	function __construct()
	{
		$this->pdo = Db::instance();
	}

	public function query ($sql,$params)
	{
		return $this->pdo->execute($sql);
	}

	public function findAll ()
	{
		$sql = "SELECT * FROM " . $this->table ;

		return $this->pdo->query($sql);
	}

	public function findBySql ($sql,$params = [])
	{

		return $this->pdo->query($sql,$params);
	}

}