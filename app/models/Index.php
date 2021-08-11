<?php 
namespace app\models;
/**
 * 
 */
class Index extends \framework\core\Model
{
	public $table = 'oc_category';

	public function getCategory($id){

		return $this->findBySql("
			SELECT * FROM {$this->table} 
			WHERE {$this->table}.category_id = ? ", [$id ] );
	}

}