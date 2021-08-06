<?php 
namespace app\models;
/**
 * 
 */
class Index extends \framework\core\Model
{
	public $table = 'user';

	public function getUser($id){

		return $this->findBySql("SELECT * FROM {$this->table} WHERE id = ? ", [$id ] );
	}

}