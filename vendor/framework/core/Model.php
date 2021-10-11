<?php 


namespace framework\core;

use \framework\core\Db;

abstract class Model
{
	protected $pdo;
	protected $table;
	protected $pk = 'id';

	function __construct()
	{
		$this->pdo = Db::instance();
	}

	public function query ($sql, $params)
	{	
		
		return $this->pdo->execute($sql, $params);
	}

	public function findAll ()
	{
		$sql = "SELECT * FROM " . $this->table ;

		return $this->pdo->query($sql);
	}

	public function findBySql ($sql, $params = [])
	{
		return $this->pdo->query($sql,$params);
	}

	public function findOne ($id, $field = '')
	{
		$field = $field ?: $this->pk;

		$sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1" ;

		return $this->pdo->query($sql, [$id]);
	}


}